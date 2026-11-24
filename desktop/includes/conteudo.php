
<?php
/**
 * Carrega textos e imagens do Supabase.
 */

require_once __DIR__ . '/conexao.php';

/**
 * Retorna um texto editável cadastrado no Supabase.
 */
function site_text(string $key, string $fallback): string
{
    static $texts = null;

    if ($texts === null) {
        $texts = [];

        $dados = supabase_request(
            'site_texts?select=key,value'
        );

        foreach ($dados as $linha) {
            if (isset($linha['key'], $linha['value'])) {
                $texts[$linha['key']] = $linha['value'];
            }
        }
    }

    $valor = $texts[$key] ?? $fallback;

    return htmlspecialchars(
        $valor,
        ENT_QUOTES,
        'UTF-8'
    );
}

/**
 * Retorna uma imagem cadastrada no Supabase.
 * Caso não exista, utiliza a imagem padrão.
 */
function site_image(string $key, string $fallback): string
{
    static $images = null;

    if ($images === null) {
        $images = [];

        $dados = supabase_request(
            'site_images?select=image_key,image_path'
        );

        foreach ($dados as $linha) {
            if (isset($linha['image_key'], $linha['image_path'])) {
                $images[$linha['image_key']] = $linha['image_path'];
            }
        }
    }

    $path = $images[$key] ?? $fallback;

    return htmlspecialchars(
        $path,
        ENT_QUOTES,
        'UTF-8'
    );
}
