<?php
// Configuração local para apresentação acadêmica.
// Projeto Google Cloud / Gemini: 807583692458

/**
 * Gemini é usado no servidor para normalizar o bairro informado no endereço.
 * Recomendado: defina GEMINI_API_KEY no ambiente do Apache/PHP.
 */
function gemini_api_key(): string {
    return trim((string)(getenv('GEMINI_API_KEY') ?: ($_SERVER['GEMINI_API_KEY'] ?? '')) ?: 'AQ.Ab8RN6Ldf5o_HtAzVjiQXsx4uP1laaO7s9S2aDOeErSBypDAvA');
}

function gemini_normalize_bairro(string $local, string $cidade, array $bairros): ?string {
    $key = gemini_api_key();
    if ($key === '' || trim($local) === '') return null;

    $lista = implode(', ', $bairros);
    $prompt = "Você é um classificador de localização para o site Guardião Animal. " .
        "A cidade permitida é Ourinhos, São Paulo. Analise o local abaixo e escolha EXATAMENTE um bairro da lista. " .
        "Se não houver informação suficiente, responda DESCONHECIDO. Não invente bairros. " .
        "Lista: {$lista}. Cidade: {$cidade}. Local: {$local}. Responda somente com o nome exato do bairro ou DESCONHECIDO.";

    $payload = json_encode([
        'contents' => [[ 'parts' => [[ 'text' => $prompt ]] ]],
        'generationConfig' => ['temperature' => 0, 'maxOutputTokens' => 40]
    ], JSON_UNESCAPED_UNICODE);

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key='.rawurlencode($key);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_TIMEOUT => 8,
        CURLOPT_CONNECTTIMEOUT => 4,
    ]);
    $response = curl_exec($ch);
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($response === false || $status < 200 || $status >= 300) return null;

    $json = json_decode($response, true);
    $text = trim((string)($json['candidates'][0]['content']['parts'][0]['text'] ?? ''));
    if ($text === '' || strtoupper($text) === 'DESCONHECIDO') return null;

    foreach ($bairros as $bairro) {
        if (ourinhos_lower(trim($text)) === ourinhos_lower($bairro)) return $bairro;
    }
    return null;
}
