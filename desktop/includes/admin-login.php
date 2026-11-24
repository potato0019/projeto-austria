
<?php

// Configuração da autenticação
require_once __DIR__ . '/admin-config.php';

// Criar token de segurança
if (empty($_SESSION['admin_csrf'])) {
    $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));
}

$mensagem = '';

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $token = $_POST['csrf_token'] ?? '';

    // Verificar token CSRF
    if (
        !is_string($token) ||
        !hash_equals($_SESSION['admin_csrf'], $token)
    ) {

        $mensagem = 'Sessão inválida. Atualize a página e tente novamente.';

    } else {

        // Verificar credenciais
        if (
            hash_equals(ADMIN_USER, $usuario) &&
            password_verify($senha, ADMIN_PASSWORD)
        ) {

            // Renovar identificador da sessão
            session_regenerate_id(true);

            // Criar sessão administrativa
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = ADMIN_USER;

            // Renovar token
            unset($_SESSION['admin_csrf']);

            // Redirecionar para o painel
            header('Location: ../admin.php');
            exit;

        } else {

            $mensagem = 'Usuário ou senha incorretos.';

        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administração | Áustria</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        night: '#171313',
                        aus: '#D52B3F',
                        cream: '#F1EEE8'
                    }
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .background-image {
            background-image:
                linear-gradient(
                    rgba(16, 15, 15, .78),
                    rgba(16, 15, 15, .86)
                ),
                url('../assets/img/cidades-austria.jpg');

            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .serif {
            font-family: Georgia, 'Times New Roman', serif;
        }

        .input-admin {
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .18);
            transition: .3s;
        }

        .input-admin:focus {
            outline: none;
            border-color: #D52B3F;
            background: rgba(255, 255, 255, .07);
        }

        .login-button {
            transition: .3s;
        }

        .login-button:hover {
            background: #b91f32;
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="bg-night text-white min-h-screen">

    <main class="background-image min-h-screen flex flex-col relative">

        <!-- Cabeçalho -->
        <header class="relative z-10 flex items-center justify-between px-6 md:px-12 lg:px-16 py-7">

            <a href="../index.php"
               class="text-lg font-black tracking-[.3em]">
                ÁUSTRIA<span class="text-aus">.</span>
            </a>

            <a href="../index.php"
               class="text-[10px] font-bold uppercase tracking-[.2em] text-white/70 hover:text-white transition">
                ← Voltar ao site
            </a>

        </header>


        <!-- Conteúdo central -->
        <section class="relative z-10 flex-1 flex flex-col items-center justify-center px-5 py-10">

            <div class="w-full max-w-[650px] mx-auto">

                <!-- Título da área administrativa -->
                <div class="text-center mb-9">

                    <h1 class="font-black uppercase tracking-[-.06em]">

                        <span class="block text-5xl sm:text-6xl md:text-7xl leading-[.9]">
                            ÁREA
                        </span>

                        <div class="flex items-center justify-center gap-3 sm:gap-5 mt-3">

                            <span class="w-7 sm:w-10 h-[2px] bg-aus shrink-0"></span>

                            <span class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl text-white/65 leading-none">
                                ADMINISTRATIVA
                            </span>

                            <span class="w-7 sm:w-10 h-[2px] bg-aus shrink-0"></span>

                        </div>

                    </h1>


                </div>


                <!-- Card de login -->
                <div class="w-full max-w-[430px] mx-auto">

                    <div class="border border-white/15 bg-black/35 backdrop-blur-md p-7 sm:p-9 shadow-2xl">

                        <!-- Cabeçalho do card -->
                        <div class="mb-8">

                            <p class="text-[10px] font-bold uppercase tracking-[.3em] text-aus mb-4">
                                Acesso restrito
                            </p>

                            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">
                                Bem-vindo de volta.
                            </h2>

                            <p class="text-sm text-white/50 mt-3">
                                Entre com suas credenciais administrativas.
                            </p>

                        </div>


                        <!-- Formulário -->
                        <form method="POST" action="" class="space-y-6">

                            <!-- Token de segurança -->
                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?= htmlspecialchars($_SESSION['admin_csrf'], ENT_QUOTES, 'UTF-8') ?>"
                            >

                            <!-- Usuário -->
                            <div>

                                <label for="usuario"
                                       class="block text-[10px] font-bold uppercase tracking-[.2em] text-white/70 mb-3">
                                    Usuário
                                </label>

                                <input
                                    type="text"
                                    id="usuario"
                                    name="usuario"
                                    placeholder="Seu usuário"
                                    autocomplete="username"
                                    required
                                    class="input-admin w-full px-4 py-4 text-sm text-white placeholder:text-white/25">

                            </div>


                            <!-- Senha -->
                            <div>

                                <label for="senha"
                                       class="block text-[10px] font-bold uppercase tracking-[.2em] text-white/70 mb-3">
                                    Senha
                                </label>

                                <div class="relative">

                                    <input
                                        type="password"
                                        id="senha"
                                        name="senha"
                                        placeholder="Sua senha"
                                        autocomplete="current-password"
                                        required
                                        class="input-admin w-full px-4 py-4 pr-20 text-sm text-white placeholder:text-white/25">

                                    <button
                                        type="button"
                                        id="toggleSenha"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] uppercase tracking-wider text-white/50 hover:text-white transition">

                                        Mostrar

                                    </button>

                                </div>

                            </div>


                            <!-- Mensagem de erro -->
                            <?php if (!empty($mensagem)): ?>

                                <p class="text-xs text-red-400" role="alert">
                                    <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>
                                </p>

                            <?php endif; ?>


                            <!-- Botão de acesso -->
                            <button
                                type="submit"
                                class="login-button w-full bg-aus py-4 text-[10px] font-bold uppercase tracking-[.25em] text-white">

                                ACESSAR PAINEL
                                <span class="ml-2"></span>

                            </button>

                        </form>


                        <!-- Rodapé do card -->
                        <div class="mt-8 pt-6 border-t border-white/10">

                            <div class="flex items-center justify-between">

                                <p class="text-[9px] uppercase tracking-[.2em] text-white/35">
                                    Acesso privado
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Identificação inferior -->
                <div class="flex justify-center items-center gap-3 mt-8">

                    <span class="w-8 h-1 bg-aus"></span>
                    <span class="w-8 h-1 bg-white/30"></span>
                    <span class="w-8 h-1 bg-white/30"></span>

                    <p class="text-[9px] uppercase tracking-[.25em] text-white/40 ml-2">
                        Painel de gerenciamento
                    </p>

                </div>

                <p class="text-center text-[9px] uppercase tracking-[.2em] text-white/30 mt-6">
                    © 2026
                </p>

            </div>

        </section>

    </main>


    <!-- JavaScript -->
    <script>

        // Mostrar e ocultar senha
        const senha = document.getElementById('senha');
        const toggleSenha = document.getElementById('toggleSenha');

        toggleSenha.addEventListener('click', () => {

            const ocultar = senha.type === 'password';

            senha.type = ocultar ? 'text' : 'password';

            toggleSenha.textContent = ocultar
                ? 'Ocultar'
                : 'Mostrar';

        });

    </script>

</body>
</html>
