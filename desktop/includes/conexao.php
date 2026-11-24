
<?php

define('SUPABASE_URL', 'https://scutwjumfktpdvocwtyl.supabase.co');
define('SUPABASE_KEY', 'sb_publishable_AlZEDvCvBkhrGmaNU30I4g_PBymMppW');

function supabase_request(string $endpoint): array
{
    if (!function_exists('curl_init')) {
        error_log('ERRO: cURL não está habilitado no PHP.');
        return [];
    }

    $url = rtrim(SUPABASE_URL, '/') . '/rest/v1/' . ltrim($endpoint, '/');

    $curl = curl_init($url);

    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'apikey: ' . SUPABASE_KEY,
            'Authorization: Bearer ' . SUPABASE_KEY,
            'Accept: application/json'
        ],
        CURLOPT_TIMEOUT => 15
    ]);

    $resposta = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($resposta === false) {
        error_log('Erro cURL: ' . curl_error($curl));
        curl_close($curl);
        return [];
    }

    curl_close($curl);

    if ($status < 200 || $status >= 300) {
        error_log('Erro Supabase HTTP ' . $status . ': ' . $resposta);
        return [];
    }

    $dados = json_decode($resposta, true);

    return is_array($dados) ? $dados : [];
}
