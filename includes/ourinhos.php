<?php
/**
 * Regiões usadas pelo mapa demonstrativo do Guardião Animal.
 * Coordenadas são pontos centrais aproximados dos bairros e servem para a visualização.
 */
function ourinhos_neighborhoods(): array {
    return [
        'Centro' => ['lat'=>-22.9795,'lng'=>-49.8705],
        'Jardim Itamaraty' => ['lat'=>-22.9980,'lng'=>-49.8558],
        'Jardim Matilde' => ['lat'=>-22.9960,'lng'=>-49.8815],
        'Jardim Paulista' => ['lat'=>-22.9665,'lng'=>-49.8870],
        'Jardim Santa Fé' => ['lat'=>-22.9550,'lng'=>-49.8830],
        'Vila Nova' => ['lat'=>-22.9700,'lng'=>-49.8545],
        'Vila Perino' => ['lat'=>-22.9870,'lng'=>-49.8575],
        'Jardim Ouro Verde' => ['lat'=>-22.9585,'lng'=>-49.8980],
        'Vila Musa' => ['lat'=>-23.0010,'lng'=>-49.8785],
        'Vila Soares' => ['lat'=>-22.9680,'lng'=>-49.9020],
        'Jardim Anchieta' => ['lat'=>-22.9590,'lng'=>-49.8490],
        'Parque Minas Gerais' => ['lat'=>-22.9535,'lng'=>-49.8670],
        'Jardim das Paineiras' => ['lat'=>-22.9650,'lng'=>-49.8740],
        'Vila Boa Esperança' => ['lat'=>-22.9890,'lng'=>-49.8490],
        'Jardim Santos Dumont' => ['lat'=>-22.9470,'lng'=>-49.8730],
        'Nova Ourinhos' => ['lat'=>-22.9690,'lng'=>-49.9160],
    ];
}
function ourinhos_lower(string $value): string {
    return function_exists('mb_strtolower') ? mb_strtolower($value, 'UTF-8') : strtolower($value);
}
function normalize_ourinhos_bairro(string $bairro): ?string {
    $clean = ourinhos_lower(trim($bairro));
    foreach (array_keys(ourinhos_neighborhoods()) as $name) {
        if ($clean === ourinhos_lower($name)) return $name;
    }
    return null;
}
