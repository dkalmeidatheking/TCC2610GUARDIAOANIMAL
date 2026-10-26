<?php
require __DIR__.'/../includes/bootstrap.php';
require __DIR__.'/../includes/ourinhos.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$regions = ourinhos_neighborhoods();
$counts = array_fill_keys(array_keys($regions), 0);
$denuncias = read_store('denuncias');

foreach ($denuncias as $d) {
    $cidade = ourinhos_lower(trim((string)($d['cidade'] ?? '')));
    if ($cidade !== '' && strpos($cidade, 'ourinhos') === false) continue;

    $bairro = normalize_ourinhos_bairro((string)($d['bairro'] ?? ''));
    if ($bairro) $counts[$bairro]++;
}

$items = [];
foreach ($regions as $bairro => $coord) {
    $count = $counts[$bairro] ?? 0;

    // 0 a 5 = verde | 6 a 10 = amarelo/laranja | acima de 10 = vermelho
    $nivel = $count > 10 ? 'alto' : ($count >= 6 ? 'medio' : 'baixo');

    $items[] = [
        'bairro' => $bairro,
        'lat' => $coord['lat'],
        'lng' => $coord['lng'],
        'count' => $count,
        'nivel' => $nivel,
    ];
}

$total = array_sum($counts);
$max = $total ? max($counts) : 0;

echo json_encode([
    'cidade' => 'Ourinhos - SP',
    'total' => $total,
    'max' => $max,
    'atualizado' => date('d/m/Y H:i:s'),
    'regioes' => $items,
    'legenda' => [
        'baixo' => '0 a 5',
        'medio' => '6 a 10',
        'alto' => 'mais de 10'
    ]
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
