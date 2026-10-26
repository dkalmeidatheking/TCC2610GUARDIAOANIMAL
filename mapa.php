<?php
$pageTitle='Mapa de denúncias';
$includeMapAssets=true;
require __DIR__.'/includes/header.php';
?>
<section class="page-hero map-page-hero">
  <div class="container">
    <span class="eyebrow">Ourinhos · mapa de ocorrências</span>
    <h1>Onde os casos estão acontecendo.</h1>
    <p>O mapa reúne as denúncias registradas em Ourinhos e transforma os registros em um mapa de calor para mostrar onde as ocorrências estão mais concentradas.</p>
  </div>
</section>
<section class="map-section">
  <div class="container">
    <div class="map-toolbar">
      <div>
        <span class="eyebrow">Atualização automática</span>
        <h2>Mapa de denúncias de Ourinhos</h2>
        <p id="map-status">Carregando registros...</p>
      </div>
      <div class="map-legend" aria-label="Legenda do mapa">
        <span><i class="legend-dot green"></i> 0 a 5 denúncias</span>
        <span><i class="legend-dot orange"></i> 6 a 10 denúncias</span>
        <span><i class="legend-dot red"></i> Mais de 10 denúncias</span>
      </div>
    </div>
    <div class="map-shell">
      <div id="ourinhos-map" class="ourinhos-map" aria-label="Mapa de denúncias de Ourinhos"></div>
      <div class="map-loading" id="map-loading">Carregando mapa...</div>
    </div>
    <div class="map-note"><span><strong>Áreas aproximadas:</strong> o mapa de calor é uma visualização aproximada de concentração e não representa os limites oficiais dos bairros.</span></div>
    <div class="map-note">
      <strong>Como o calor é definido?</strong>
      <span>Verde: 0 a 5 denúncias · Amarelo/Laranja: 6 a 10 · Vermelho: mais de 10.</span>
      <span>O mapa é atualizado automaticamente a cada 5 segundos.</span>
    </div>
    <div class="map-ai-card">
      <div class="map-ai-icon">✦</div>
      <div>
        <span class="eyebrow">Integração com Gemini</span>
        <h3>Classificação automática do local</h3>
        <p>Quando a chave da API estiver configurada no servidor, o Gemini analisa o texto do local da denúncia e tenta associá-lo a um dos bairros cadastrados de Ourinhos. Se a IA não conseguir identificar, o bairro escolhido no formulário é mantido.</p>
      </div>
    </div>
  </div>
</section>
<?php require __DIR__.'/includes/footer.php'; ?>
