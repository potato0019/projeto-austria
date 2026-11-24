
<?php
// Painel administrativo do site da Áustria

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/includes/admin-config.php';

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: includes/admin-login.php');
    exit;
}

require_once __DIR__ . '/includes/conexao.php';
require_once __DIR__ . '/includes/segredos.php';

/*
|--------------------------------------------------------------------------
| CAMPOS EDITÁVEIS
|--------------------------------------------------------------------------
*/

$camposEditaveis = [
    'hero_description' => [
        'label' => 'Texto de apresentação (início)',
        'fallback' => 'Entre montanhas, palácios e lendas: uma viagem pela cultura e pela história de um país fascinante.'
    ],
    'identity_description' => [
        'label' => 'Apresentação da identidade',
        'fallback' => 'A Áustria reúne símbolos, tradições e expressões culturais que atravessaram séculos e continuam presentes no cotidiano do país.'
    ],
    'folklore_description' => [
        'label' => 'Apresentação do folclore',
        'fallback' => 'Criaturas misteriosas, aparições e personagens que fazem parte do imaginário popular austríaco.'
    ],
    'vienna_description' => [
        'label' => 'Apresentação de Viena',
        'fallback' => 'De um acampamento romano a uma das capitais culturais mais conhecidas da Europa.'
    ],
    'curiosities_description' => [
        'label' => 'Apresentação das curiosidades',
        'fallback' => 'Detalhes que revelam um pouco mais da personalidade austríaca.'
    ],
];

/*
|--------------------------------------------------------------------------
| IMAGENS EDITÁVEIS
|--------------------------------------------------------------------------
*/

$imagensEditaveis = [
    'hero' => [
        'label' => 'Imagem principal (início)',
        'fallback' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=2400&q=90'
    ],
    'vienna' => [
        'label' => 'Imagem de Viena',
        'fallback' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af?auto=format&fit=crop&w=2000&q=85'
    ],
    'identity' => [
        'label' => 'Imagem da identidade e dos Alpes',
        'fallback' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1400&q=85'
    ],
    'legend' => [
        'label' => 'Imagem da seção de lendas',
        'fallback' => 'https://images.unsplash.com/photo-1511497584788-876760111969?auto=format&fit=crop&w=1400&q=85'
    ],
    'krampus' => [
        'label' => 'Lenda: Krampus',
        'fallback' => 'assets/img/krampus.png'
    ],
    'white_lady' => [
        'label' => 'Lenda: A Dama Branca',
        'fallback' => 'assets/img/damabranca.jpg'
    ],
    'perchten' => [
        'label' => 'Lenda: Perchten',
        'fallback' => 'assets/img/bichofeio.jpg'
    ],
    'music' => [
        'label' => 'Curiosidades: Música',
        'fallback' => 'assets/img/musica-austria.jpg'
    ],
    'cities' => [
        'label' => 'Curiosidades: Cidades',
        'fallback' => 'assets/img/palacio.jpg'
    ],
    'traditions' => [
        'label' => 'Curiosidades: Tradições',
        'fallback' => 'assets/img/images.jpg'
    ],
];

/*
|--------------------------------------------------------------------------
| REQUISIÇÕES AO SUPABASE
|--------------------------------------------------------------------------
*/

function admin_supabase_request($endpoint, $method = 'GET', $body = null)
{
    if (
        !defined('SUPABASE_URL') ||
        !defined('SUPABASE_ADMIN_KEY') ||
        SUPABASE_ADMIN_KEY === 'COLOQUE_SUA_NOVA_SECRET_KEY_AQUI'
    ) {
        throw new RuntimeException(
            'Configure a Secret Key do Supabase no arquivo includes/segredos.php.'
        );
    }

    if (!function_exists('curl_init')) {
        throw new RuntimeException('A extensão cURL do PHP não está ativada no XAMPP.');
    }

    $url = rtrim(SUPABASE_URL, '/') . '/rest/v1/' . ltrim($endpoint, '/');

    $headers = [
        'apikey: ' . SUPABASE_ADMIN_KEY,
        'Authorization: Bearer ' . SUPABASE_ADMIN_KEY,
        'Content-Type: application/json',
        'Accept: application/json'
    ];

    if ($method === 'POST' || $method === 'PATCH') {
        $headers[] = 'Prefer: resolution=merge-duplicates,return=representation';
    }

    $curl = curl_init($url);

    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_TIMEOUT => 20
    ]);

    if ($body !== null) {
        curl_setopt(
            $curl,
            CURLOPT_POSTFIELDS,
            json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );
    }

    $response = curl_exec($curl);
    $status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);

    curl_close($curl);

    if ($response === false) {
        throw new RuntimeException('Falha de conexão com o Supabase: ' . $curlError);
    }

    if ($status < 200 || $status >= 300) {
        $detalhes = json_decode($response, true);

        $mensagemErro = is_array($detalhes) && isset($detalhes['message'])
            ? $detalhes['message']
            : $response;

        throw new RuntimeException(
            'Supabase retornou HTTP ' . $status . ': ' . $mensagemErro
        );
    }

    if ($response === '' || $response === 'null') {
        return [];
    }

    $dados = json_decode($response, true);

    return is_array($dados) ? $dados : [];
}

/*
|--------------------------------------------------------------------------
| VARIÁVEIS DO PAINEL
|--------------------------------------------------------------------------
*/

$mensagem = '';
$tipoMensagem = '';

$abrirCardSenha = false;
$abrirCardTextos = false;
$abrirCardImagens = false;

$imagensSalvas = [];
$textosSalvos = [];

if (empty($_SESSION['admin_csrf'])) {
    $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));
}

/*
|--------------------------------------------------------------------------
| PROCESSAMENTO DOS FORMULÁRIOS
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $token = $_POST['csrf_token'] ?? '';

    if (
        !is_string($token) ||
        !hash_equals($_SESSION['admin_csrf'], $token)
    ) {
        $mensagem = 'Sessão inválida. Atualize a página e tente novamente.';
        $tipoMensagem = 'erro';

    } elseif (isset($_POST['logout'])) {

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: includes/admin-login.php');
        exit;

    } elseif (isset($_POST['save_texts'])) {

        $abrirCardTextos = true;

        try {
            $linhas = [];

            foreach ($camposEditaveis as $chave => $configCampo) {

                $valor = trim((string) ($_POST['textos'][$chave] ?? ''));

                $tamanho = function_exists('mb_strlen')
                    ? mb_strlen($valor, 'UTF-8')
                    : strlen($valor);

                if ($tamanho > 5000) {
                    throw new RuntimeException(
                        'Um dos textos ultrapassou o limite de 5.000 caracteres.'
                    );
                }

                $linhas[] = [
                    'key' => $chave,
                    'value' => $valor
                ];

                $textosSalvos[$chave] = $valor;
            }

            admin_supabase_request(
                'site_texts?on_conflict=key',
                'POST',
                $linhas
            );

            $mensagem = 'Textos atualizados com sucesso!';
            $tipoMensagem = 'sucesso';

        } catch (Throwable $erro) {

            $mensagem = $erro->getMessage();
            $tipoMensagem = 'erro';
        }

    } elseif (isset($_POST['save_image'])) {

        $abrirCardImagens = true;

        $chaveImagem = (string) ($_POST['image_key'] ?? '');
        $arquivoSalvo = null;

        try {

            if (!isset($imagensEditaveis[$chaveImagem])) {
                throw new RuntimeException('Imagem selecionada inválida.');
            }

            if (
                !isset($_FILES['image_file']) ||
                $_FILES['image_file']['error'] !== UPLOAD_ERR_OK
            ) {
                throw new RuntimeException('Selecione uma imagem válida para enviar.');
            }

            $arquivo = $_FILES['image_file'];

            if ($arquivo['size'] > 8 * 1024 * 1024) {
                throw new RuntimeException('A imagem deve ter no máximo 8 MB.');
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($arquivo['tmp_name']);

            $extensoes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
                'image/gif' => 'gif'
            ];

            if (!isset($extensoes[$mime])) {
                throw new RuntimeException(
                    'Formato não permitido. Use JPG, PNG, WEBP ou GIF.'
                );
            }

            $diretorioUploads = __DIR__ . '/uploads/site';

            if (
                !is_dir($diretorioUploads) &&
                !mkdir($diretorioUploads, 0755, true) &&
                !is_dir($diretorioUploads)
            ) {
                throw new RuntimeException('Não foi possível criar a pasta de imagens.');
            }

            $nomeArquivo = $chaveImagem . '-' .
                bin2hex(random_bytes(10)) . '.' .
                $extensoes[$mime];

            $destino = $diretorioUploads . '/' . $nomeArquivo;

            if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
                throw new RuntimeException('Não foi possível armazenar a imagem enviada.');
            }

            $arquivoSalvo = $destino;

            $caminhoRelativo = 'uploads/site/' . $nomeArquivo;

            admin_supabase_request(
                'site_images?on_conflict=image_key',
                'POST',
                [[
                    'image_key' => $chaveImagem,
                    'image_path' => $caminhoRelativo
                ]]
            );

            $imagensSalvas[$chaveImagem] = $caminhoRelativo;

            $mensagem = 'Imagem atualizada com sucesso!';
            $tipoMensagem = 'sucesso';

        } catch (Throwable $erro) {

            if ($arquivoSalvo && is_file($arquivoSalvo)) {
                @unlink($arquivoSalvo);
            }

            $mensagem = $erro->getMessage();
            $tipoMensagem = 'erro';
        }

    } elseif (isset($_POST['change_password'])) {

        $abrirCardSenha = true;

        $senhaAtual = (string) ($_POST['senha_atual'] ?? '');
        $novaSenha = (string) ($_POST['nova_senha'] ?? '');
        $confirmarSenha = (string) ($_POST['confirmar_senha'] ?? '');

        if (
            !defined('ADMIN_PASSWORD') ||
            !password_verify($senhaAtual, ADMIN_PASSWORD)
        ) {

            $mensagem = 'A senha atual está incorreta.';
            $tipoMensagem = 'erro';

        } elseif (strlen($novaSenha) < 8) {

            $mensagem = 'A nova senha deve possuir pelo menos 8 caracteres.';
            $tipoMensagem = 'erro';

        } elseif ($novaSenha !== $confirmarSenha) {

            $mensagem = 'As novas senhas não coincidem.';
            $tipoMensagem = 'erro';

        } elseif ($novaSenha === $senhaAtual) {

            $mensagem = 'A nova senha deve ser diferente da atual.';
            $tipoMensagem = 'erro';

        } else {

            $arquivoConfig = __DIR__ . '/includes/admin-config.php';
            $conteudoConfig = file_get_contents($arquivoConfig);

            $hash = password_hash($novaSenha, PASSWORD_DEFAULT);

            $novoConteudo = preg_replace_callback(
                '~define\s*\(\s*([\'"])ADMIN_PASSWORD\1\s*,\s*([\'"])(.*?)\2\s*\)\s*;~s',
                function ($matches) use ($hash) {
                    return "define('ADMIN_PASSWORD', '" . $hash . "');";
                },
                $conteudoConfig,
                1,
                $quantidade
            );

            if ($novoConteudo === null || $quantidade !== 1) {

                $mensagem = 'Não foi possível localizar ADMIN_PASSWORD no arquivo admin-config.php.';
                $tipoMensagem = 'erro';

            } elseif (file_put_contents($arquivoConfig, $novoConteudo, LOCK_EX) === false) {

                $mensagem = 'Não foi possível salvar a nova senha. Verifique as permissões do arquivo.';
                $tipoMensagem = 'erro';

            } else {

                session_regenerate_id(true);

                $mensagem = 'Senha alterada com sucesso!';
                $tipoMensagem = 'sucesso';
            }
        }
    }
}

/*
|--------------------------------------------------------------------------
| CARREGAR TEXTOS E IMAGENS
|--------------------------------------------------------------------------
*/

try {

    if (!$textosSalvos) {

        $registros = admin_supabase_request(
            'site_texts?select=key,value'
        );

        foreach ($registros as $registro) {

            if (isset($registro['key'], $registro['value'])) {
                $textosSalvos[$registro['key']] = $registro['value'];
            }
        }
    }

    $registrosImagens = admin_supabase_request(
        'site_images?select=image_key,image_path'
    );

    foreach ($registrosImagens as $registro) {

        if (isset($registro['image_key'], $registro['image_path'])) {
            $imagensSalvas[$registro['image_key']] = $registro['image_path'];
        }
    }

} catch (Throwable $erro) {

    if ($mensagem === '') {
        $mensagem = 'Não foi possível carregar os dados do Supabase: ' .
            $erro->getMessage();

        $tipoMensagem = 'erro';
    }
}

$usuario = htmlspecialchars(
    (string) ($_SESSION['admin_user'] ?? 'Administrador'),
    ENT_QUOTES,
    'UTF-8'
);

$csrfToken = htmlspecialchars(
    (string) $_SESSION['admin_csrf'],
    ENT_QUOTES,
    'UTF-8'
);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Painel Administrativo | Áustria</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CONFIGURAÇÃO DO TAILWIND ANTES DO CARREGAMENTO -->
    <script>
        tailwind = {
            config: {
                theme: {
                    extend: {
                        colors: {
                            night: '#171313',
                            aus: '#D52B3F',
                            cream: '#F1EEE8',
                            muted: '#A49B95'
                        },
                        fontFamily: {
                            sans: ['Inter', 'sans-serif']
                        }
                    }
                }
            }
        };
    </script>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Inter, sans-serif;
            background: #171313;
            color: #F1EEE8;
        }

        /* Mantém o cabeçalho e o conteúdo alinhados na mesma largura. */
        .admin-container {
            width: min(100% - 48px, 1440px);
            margin-inline: auto;
        }

        @media (min-width: 768px) {
            .admin-container {
                width: min(100% - 80px, 1440px);
            }
        }

        .admin-card {
            background: #211c1b;
            border: 1px solid rgba(255,255,255,.08);
            transition: .25s ease;
        }

        .admin-card:hover {
            border-color: rgba(213,43,63,.4);
        }

        .red-line {
            height: 2px;
            background: #D52B3F;
            width: 32px;
            flex-shrink: 0;
        }

        .form-input {
            width: 100%;
            background: #171313;
            border: 1px solid rgba(255,255,255,.12);
            padding: 14px 15px;
            color: #F1EEE8;
            outline: none;
            border-radius: 2px;
            transition: .2s ease;
        }

        .form-input:focus {
            border-color: #D52B3F;
        }

        .form-input::placeholder {
            color: #716965;
        }

        .form-input option {
            background: #211c1b;
            color: #F1EEE8;
        }

        button {
            cursor: pointer;
        }

        .admin-button {
            background: #D52B3F;
            color: #fff;
            transition: .2s ease;
        }

        .admin-button:hover {
            background: #b91f32;
        }

        .text-muted {
            color: #A49B95;
        }

        .text-aus {
            color: #D52B3F;
        }

        .text-cream {
            color: #F1EEE8;
        }

        .hidden {
            display: none;
        }

        ::selection {
            background: #D52B3F;
            color: #fff;
        }
    </style>
</head>

<body class="min-h-screen text-cream">

<header class="border-b border-white/10 bg-[#1D1817]">
    <div class="admin-container flex items-center justify-between py-5">

        <a href="index.php" class="text-xl font-bold tracking-[.25em] text-cream">
            ÁUSTRIA<span class="text-aus">.</span>
        </a>

        <div class="flex items-center gap-5">

            <a href="index.php"
               class="hidden text-xs font-semibold uppercase tracking-widest text-white/60 transition hover:text-white sm:block">
                Visualizar site
            </a>

            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                <button type="submit"
                        name="logout"
                        value="1"
                        class="text-xs font-bold uppercase tracking-widest text-aus hover:text-white">
                    Sair
                </button>
            </form>

        </div>
    </div>
</header>

<main class="admin-container py-12 md:py-16">

    <!-- APRESENTAÇÃO -->

    <section class="mb-12">

        <div class="mb-5 flex items-center gap-3">
            <div class="red-line"></div>

            <span class="text-[10px] font-bold uppercase tracking-[.3em] text-aus">
                Área administrativa
            </span>
        </div>

        <h1 class="text-4xl font-bold leading-tight text-cream md:text-6xl">
            Bem-vindo ao<br>
            <span class="text-white/45">painel de controle.</span>
        </h1>

        <p class="mt-5 max-w-xl text-sm leading-7 text-muted">
            Gerencie e acompanhe os conteúdos do projeto. Este espaço reúne as ferramentas administrativas do site da Áustria.
        </p>

        <p class="mt-2 text-xs text-white/40">
            Conectado como <?= $usuario ?>
        </p>

    </section>

    <!-- MENSAGENS -->

    <?php if ($mensagem !== ''): ?>

        <div class="mb-8 rounded-sm border p-4 text-sm
            <?= $tipoMensagem === 'sucesso'
                ? 'border-green-500/30 bg-green-500/10 text-green-400'
                : 'border-aus/30 bg-aus/10 text-red-300' ?>">

            <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>

        </div>

    <?php endif; ?>

    <!-- EDITAR TEXTOS -->

    <section id="editar-textos" class="mb-16">

        <div class="admin-card flex flex-col justify-between gap-6 rounded-sm p-6 sm:flex-row sm:items-center md:p-8">

            <div class="flex items-center gap-4">

                <div class="flex h-12 w-12 items-center justify-center border border-white/10 text-xl text-cream">
                    <i class="bi bi-pencil"></i>
                </div>

                <div>

                    <div class="mb-3 flex items-center gap-3">
                        <div class="red-line"></div>

                        <span class="text-[10px] font-bold uppercase tracking-[.25em] text-aus">
                            Conteúdo do site
                        </span>
                    </div>

                    <h2 class="text-xl font-semibold text-cream">
                        Editar textos do site
                    </h2>

                    <p class="mt-2 text-sm text-muted">
                        Altere os textos das seções da página inicial.
                    </p>

                </div>
            </div>

            <button type="button"
                    id="abrirTextos"
                    aria-expanded="<?= $abrirCardTextos ? 'true' : 'false' ?>"
                    class="admin-button shrink-0 px-6 py-4 text-xs font-bold uppercase tracking-[.15em]">

                <?= $abrirCardTextos ? 'Fechar opções ↑' : 'Gerenciar textos →' ?>

            </button>

        </div>

        <div id="cardTextos"
             class="admin-card mt-5 <?= $abrirCardTextos ? '' : 'hidden' ?> rounded-sm p-6 md:p-8">

            <p class="mb-7 max-w-2xl text-sm leading-6 text-muted">
                Altere os textos abaixo e clique em salvar. As informações ficam guardadas no Supabase.
            </p>

            <form method="POST" class="space-y-6">

                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                <?php foreach ($camposEditaveis as $chave => $configCampo): ?>

                    <div>

                        <label for="texto_<?= htmlspecialchars($chave, ENT_QUOTES, 'UTF-8') ?>"
                               class="mb-2 block text-xs font-semibold text-white/75">

                            <?= htmlspecialchars($configCampo['label'], ENT_QUOTES, 'UTF-8') ?>

                        </label>

                        <textarea
                            id="texto_<?= htmlspecialchars($chave, ENT_QUOTES, 'UTF-8') ?>"
                            name="textos[<?= htmlspecialchars($chave, ENT_QUOTES, 'UTF-8') ?>]"
                            rows="3"
                            maxlength="5000"
                            class="form-input resize-y"><?= htmlspecialchars($textosSalvos[$chave] ?? $configCampo['fallback'], ENT_QUOTES, 'UTF-8') ?></textarea>

                    </div>

                <?php endforeach; ?>

                <div class="flex justify-end border-t border-white/10 pt-5">

                    <button type="submit"
                            name="save_texts"
                            value="1"
                            class="admin-button px-6 py-4 text-xs font-bold uppercase tracking-[.15em]">

                        Salvar textos

                    </button>

                </div>

            </form>

        </div>

    </section>

    <!-- EDITAR IMAGENS -->

    <section id="editar-imagens" class="mb-16">

        <div class="admin-card flex flex-col justify-between gap-6 rounded-sm p-6 sm:flex-row sm:items-center md:p-8">

            <div class="flex items-center gap-4">

                <div class="flex h-12 w-12 items-center justify-center border border-white/10 text-xl text-cream">
                    <i class="bi bi-images"></i>
                </div>

                <div>

                    <div class="mb-3 flex items-center gap-3">
                        <div class="red-line"></div>

                        <span class="text-[10px] font-bold uppercase tracking-[.25em] text-aus">
                            Mídia do site
                        </span>
                    </div>

                    <h2 class="text-xl font-semibold text-cream">
                        Alterar imagens do site
                    </h2>

                    <p class="mt-2 text-sm text-muted">
                        Envie novas fotos para substituir as imagens das seções.
                    </p>

                </div>
            </div>

            <button type="button"
                    id="abrirImagens"
                    aria-expanded="<?= $abrirCardImagens ? 'true' : 'false' ?>"
                    class="admin-button shrink-0 px-6 py-4 text-xs font-bold uppercase tracking-[.15em]">

                Gerenciar imagens →

            </button>

        </div>

        <div id="cardImagens"
             class="admin-card mt-5 <?= $abrirCardImagens ? '' : 'hidden' ?> rounded-sm p-6 md:p-8">

            <p class="mb-7 max-w-2xl text-sm leading-6 text-muted">
                Escolha a imagem que deseja substituir. São aceitos JPG, PNG, WEBP e GIF, com até 8 MB por arquivo.
            </p>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                <?php foreach ($imagensEditaveis as $chaveImagem => $configImagem):
                    $previewImagem = $imagensSalvas[$chaveImagem] ?? $configImagem['fallback'];
                ?>

                    <form method="POST"
                          enctype="multipart/form-data"
                          class="space-y-3 border border-white/10 bg-[#1D1817] p-4">

                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                        <input type="hidden"
                               name="image_key"
                               value="<?= htmlspecialchars($chaveImagem, ENT_QUOTES, 'UTF-8') ?>">

                        <div class="aspect-video overflow-hidden bg-black/30">

                            <img
                                src="<?= htmlspecialchars($previewImagem, ENT_QUOTES, 'UTF-8') ?>"
                                alt="Prévia: <?= htmlspecialchars($configImagem['label'], ENT_QUOTES, 'UTF-8') ?>"
                                class="h-full w-full object-cover"
                                loading="lazy">

                        </div>

                        <h3 class="text-sm font-semibold text-cream">
                            <?= htmlspecialchars($configImagem['label'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <input
                            type="file"
                            name="image_file"
                            accept=".jpg,.jpeg,.png,.webp,.gif,image/jpeg,image/png,image/webp,image/gif"
                            required
                            class="block w-full text-xs text-white/65 file:mr-3 file:border-0 file:bg-white/10 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white">

                        <button
                            type="submit"
                            name="save_image"
                            value="1"
                            class="admin-button w-full px-4 py-3 text-[10px] font-bold uppercase tracking-[.15em]">

                            <i class="bi bi-cloud-arrow-up mr-2"></i>
                            Enviar imagem

                        </button>

                    </form>

                <?php endforeach; ?>

            </div>

        </div>

    </section>

    <!-- CONFIGURAÇÕES DA CONTA -->

    <section id="configuracoes" class="mt-20">

        <div class="mb-7 flex items-center gap-3">

            <div class="red-line"></div>

            <h2 class="text-xs font-bold uppercase tracking-[.25em] text-cream">
                Configurações da conta
            </h2>

        </div>

        <div class="admin-card flex flex-col justify-between gap-6 rounded-sm p-6 sm:flex-row sm:items-center md:p-8">

            <div class="flex items-center gap-4">

                <div class="flex h-12 w-12 items-center justify-center border border-white/10 text-xl text-cream">
                    <i class="bi bi-gear"></i>
                </div>

                <div>

                    <h3 class="text-lg font-semibold text-cream">
                        Segurança da conta
                    </h3>

                    <p class="mt-2 text-sm text-muted">
                        Gerencie sua senha de acesso ao painel administrativo.
                    </p>

                </div>

            </div>

            <button type="button"
                    id="abrirSenha"
                    aria-expanded="<?= $abrirCardSenha ? 'true' : 'false' ?>"
                    class="admin-button shrink-0 px-6 py-4 text-xs font-bold uppercase tracking-[.15em]">

                <?= $abrirCardSenha ? 'Fechar configurações ↑' : 'Gerenciar senha →' ?>

            </button>

        </div>

        <div id="cardSenha"
             class="admin-card mt-5 <?= $abrirCardSenha ? '' : 'hidden' ?> max-w-2xl rounded-sm p-6 md:p-8">

            <div class="mb-8 flex items-start justify-between gap-4">

                <div>

                    <span class="text-[10px] font-bold uppercase tracking-[.2em] text-aus">
                        Configurações de segurança
                    </span>

                    <h3 class="mt-3 text-2xl font-semibold text-cream">
                        Alterar senha
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-muted">
                        Preencha os campos abaixo para atualizar sua senha.
                    </p>

                </div>

                <button type="button"
                        id="fecharSenha"
                        aria-label="Fechar configurações de senha"
                        class="text-xl text-white/50 hover:text-white">

                    ✕

                </button>

            </div>

            <form method="POST" class="space-y-5">

                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                <div>

                    <label for="senha_atual"
                           class="mb-2 block text-xs font-semibold text-white/70">

                        Senha atual

                    </label>

                    <input
                        type="password"
                        id="senha_atual"
                        name="senha_atual"
                        class="form-input"
                        placeholder="Digite sua senha atual"
                        autocomplete="current-password"
                        required>

                </div>

                <div>

                    <label for="nova_senha"
                           class="mb-2 block text-xs font-semibold text-white/70">

                        Nova senha

                    </label>

                    <input
                        type="password"
                        id="nova_senha"
                        name="nova_senha"
                        class="form-input"
                        placeholder="Mínimo de 8 caracteres"
                        minlength="8"
                        autocomplete="new-password"
                        required>

                </div>

                <div>

                    <label for="confirmar_senha"
                           class="mb-2 block text-xs font-semibold text-white/70">

                        Confirmar nova senha

                    </label>

                    <input
                        type="password"
                        id="confirmar_senha"
                        name="confirmar_senha"
                        class="form-input"
                        placeholder="Digite novamente sua nova senha"
                        minlength="8"
                        autocomplete="new-password"
                        required>

                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-white/10 pt-6 sm:flex-row sm:justify-end">

                    <button type="button"
                            id="cancelarSenha"
                            class="border border-white/15 px-6 py-4 text-xs font-bold uppercase tracking-widest text-white/60 hover:text-white">

                        Cancelar

                    </button>

                    <button type="submit"
                            name="change_password"
                            value="1"
                            class="admin-button px-6 py-4 text-xs font-bold uppercase tracking-widest">

                        Salvar nova senha

                    </button>

                </div>

            </form>

        </div>

    </section>

    <footer class="mt-20 border-t border-white/10 pt-7">

        <p class="text-[10px] uppercase tracking-[.15em] text-white/35">
            Painel administrativo · Áustria
        </p>

    </footer>

</main>

<script>
    // ABRIR E FECHAR TEXTOS

    const abrirTextos = document.getElementById('abrirTextos');
    const cardTextos = document.getElementById('cardTextos');

    abrirTextos.addEventListener('click', () => {

        const abrir = cardTextos.classList.contains('hidden');

        cardTextos.classList.toggle('hidden');

        abrirTextos.setAttribute('aria-expanded', String(abrir));

        abrirTextos.textContent = abrir
            ? 'Fechar opções ↑'
            : 'Gerenciar textos →';

        if (abrir) {
            cardTextos.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }
    });


    // ABRIR E FECHAR IMAGENS

    const abrirImagens = document.getElementById('abrirImagens');
    const cardImagens = document.getElementById('cardImagens');

    abrirImagens.addEventListener('click', () => {

        const abrir = cardImagens.classList.contains('hidden');

        cardImagens.classList.toggle('hidden');

        abrirImagens.setAttribute('aria-expanded', String(abrir));

        abrirImagens.textContent = abrir
            ? 'Fechar opções ↑'
            : 'Gerenciar imagens →';

        if (abrir) {
            cardImagens.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }
    });


    // ABRIR E FECHAR SENHA

    const abrirSenha = document.getElementById('abrirSenha');
    const cardSenha = document.getElementById('cardSenha');

    function alternarSenha() {

        const abrir = cardSenha.classList.contains('hidden');

        cardSenha.classList.toggle('hidden');

        abrirSenha.setAttribute('aria-expanded', String(abrir));

        abrirSenha.textContent = abrir
            ? 'Fechar configurações ↑'
            : 'Gerenciar senha →';

        if (abrir) {
            cardSenha.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }
    }

    abrirSenha.addEventListener('click', alternarSenha);

    document.getElementById('fecharSenha')
        .addEventListener('click', alternarSenha);

    document.getElementById('cancelarSenha')
        .addEventListener('click', alternarSenha);
</script>

</body>
</html>
