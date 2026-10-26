<?php
$pageTitle='Início';
$includeMapAssets=true;
require __DIR__.'/includes/header.php';
global $animals,$ongs,$news;
$available=array_filter($animals,fn($a)=>$a['status']==='Disponível');
$featured=array_slice($available,0,3,true);
$ongIds=array_slice(array_keys($ongs),0,4);
?>
<section class="home-hero">
  <div class="hero-glow"></div>
  <div class="container hero-inner">
    <div class="hero-copy">
      <span class="hero-kicker">PROTEÇÃO ANIMAL É UM ESFORÇO COLETIVO</span>
      <h1>Eles não podem<br><em>se defender.</em><br>Mas você pode.</h1>
      <p>O Guardião Animal conecta pessoas, ONGs e ações que fazem a diferença na vida de animais em situação de risco, abandono ou vulnerabilidade.</p>
      <div class="hero-actions">
        <a class="btn btn-mint" href="<?=base_url('denuncia.php')?>">Fazer uma denúncia</a>
        <a class="btn btn-white" href="<?=base_url('adocao.php')?>">Ver animais para adoção ♡</a>
      </div>
    </div>
  </div>
  <div class="hero-note">
    <span>Hoje na rede</span>
    <strong>16 animais</strong>
    <small>com perfil publicado</small>
  </div>
  <div class="hero-scroll"><span>Role para continuar</span><i></i></div>
</section>

<section class="ways-section" id="participar">
  <div class="container">
    <div class="ways-head reveal">
      <div>
        <span class="eyebrow">Como participar</span>
        <h2>Escolha por onde começar.</h2>
      </div>
      <p>Você pode ajudar em um caso, abrir espaço na sua casa ou contribuir com quem cuida todos os dias.</p>
    </div>
    <div class="ways-grid">
      <a class="way-card way-card-denounce reveal" href="<?=base_url('denuncia.php')?>">
        <div class="way-top"><span class="way-number">01</span><span class="way-label">ATENÇÃO</span></div>
        <div class="way-icon-image"><img src="https://cdn-icons-png.flaticon.com/512/5610/5610989.png" alt="Alerta"></div>
        <div class="way-content"><h3>Denunciar</h3><p>Avistou um animal em risco? Registre o local, explique o que aconteceu e informe a urgência.</p><span>Registrar denúncia <b>→</b></span></div>
      </a>
      <a class="way-card way-card-adopt reveal" href="<?=base_url('adocao.php')?>">
        <div class="way-top"><span class="way-number">02</span><span class="way-label">ADOÇÃO</span></div>
        <div class="way-icon-image"><img src="https://cdn-icons-png.flaticon.com/512/3662/3662079.png" alt="Adoção"></div>
        <div class="way-content"><h3>Adotar</h3><p>Veja fotos, histórias e características de quem está esperando uma família.</p><span>Conhecer os animais <b>→</b></span></div>
      </a>
      <a class="way-card way-card-support reveal" href="<?=base_url('doacao.php')?>">
        <div class="way-top"><span class="way-number">03</span><span class="way-label">APOIO</span></div>
        <div class="way-icon-image"><img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/apoiar-icon-svg-download-png-7083843.png?f=webp&w=128" alt="Apoio"></div>
        <div class="way-content"><h3>Apoiar</h3><p>Uma contribuição ajuda a manter alimentação, consultas, medicamentos e acolhimento.</p><span>Ver formas de ajudar <b>→</b></span></div>
      </a>
    </div>
  </div>
</section>

<section class="story-section section">
  <div class="container story-split">
    <div class="story-photo reveal" role="img" aria-label="Cão sendo cuidado"></div>
    <div class="story-copy reveal">
      <span class="eyebrow">O problema que a plataforma enfrenta</span>
      <h2>Um caso pode passar por várias mãos. A informação não pode se perder.</h2>
      <p>Entre a denúncia, o resgate, a consulta e a adoção, muita coisa acontece. O Guardião foi pensado para reunir essas informações de forma simples e facilitar o contato entre a comunidade e as organizações.</p>
      <div class="simple-points">
        <div><strong>Registro</strong><span>Local, urgência e descrição do caso.</span></div>
        <div><strong>Acompanhamento</strong><span>ONG responsável e situação do atendimento.</span></div>
        <div><strong>Destino</strong><span>Adoção, apadrinhamento ou acolhimento.</span></div>
      </div>
      <a class="btn btn-dark" href="<?=base_url('sobre.php')?>">Conhecer o projeto</a>
    </div>
  </div>
</section>

<section class="stats-band">
  <div class="container stats">
    <div class="stat reveal"><strong class="count-up" data-count="37">0</strong><span>ocorrências na demonstração</span></div>
    <div class="stat reveal"><strong class="count-up" data-count="16">0</strong><span>animais com perfil</span></div>
    <div class="stat reveal"><strong class="count-up" data-count="8">0</strong><span>ONGs na rede</span></div>
    <div class="stat reveal"><strong class="count-up" data-count="29">0</strong><span>voluntários cadastrados</span></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <div><span class="eyebrow">Adoção</span><h2>Alguns dos animais disponíveis</h2></div>
      <a class="text-link" href="<?=base_url('adocao.php')?>">Ver todos →</a>
    </div>
    <div class="cards">
      <?php foreach($featured as $id=>$a): ?>
      <article class="animal-card reveal"><a href="animal.php?id=<?=$id?>">
        <div class="card-photo" style="background-image:url('<?=e($a['foto'])?>')"></div>
        <div class="card-body"><span class="chip"><?=e($a['especie'])?></span><h3><?=e($a['nome'])?></h3><div class="meta"><?=e($a['idade'])?> · <?=e($a['porte'])?> · <?=e($a['sexo'])?></div><div class="card-bottom"><span class="text-link">Abrir perfil</span><span class="chip"><?=e($a['status'])?></span></div></div>
      </a></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="big-story reveal">
      <div class="big-story-photo"></div>
      <div class="big-story-copy"><span class="eyebrow" style="color:var(--mint)">História em destaque</span><h2>Joca chegou com uma pata machucada. Hoje espera por uma família.</h2><p>O perfil mostra o que aconteceu desde o primeiro atendimento e ajuda quem pensa em adotar a conhecer melhor a rotina dele.</p><a class="btn btn-mint" href="animal.php?id=1">Ver perfil do Joca</a></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal"><div><span class="eyebrow">Rede parceira</span><h2>Organizações que fazem o atendimento acontecer</h2></div><a class="text-link" href="<?=base_url('ongs.php')?>">Ver todas →</a></div>
    <div class="cards">
      <?php foreach($ongIds as $oid): $o=$ongs[$oid]; ?>
      <article class="ong-card reveal"><a href="ong.php?id=<?=$oid?>"><div class="ong-photo" style="background-image:url('<?=e($o['foto'])?>')"></div><div class="ong-body"><div class="card-bottom" style="margin-top:0"><span class="chip">Desde <?=$o['ano']?></span><span class="meta"><?=$o['animais']?> animais</span></div><h3><?=e($o['nome'])?></h3><div class="ong-location"><?=e($o['cidade'])?> · <?=e($o['bairro'])?></div><span class="ong-focus"><?=e($o['foco'])?></span><p><?=e($o['descricao'])?></p><span class="text-link">Abrir perfil →</span></div></a></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-soft">
  <div class="container">
    <div class="section-head reveal"><div><span class="eyebrow">Histórias da rede</span><h2>O que está acontecendo por aqui</h2></div><a class="text-link" href="<?=base_url('noticias.php')?>">Ver histórias →</a></div>
    <div class="cards">
      <?php foreach(array_slice($news,0,3) as $n): ?>
      <article class="story-card reveal"><div class="card-photo" style="background-image:url('<?=e($n['foto'])?>')"></div><div class="card-body"><span class="chip"><?=e($n['categoria'])?></span><div class="meta" style="margin:11px 0"><?=e($n['data'])?></div><h3><?=e($n['titulo'])?></h3><p><?=e($n['resumo'])?></p><a class="text-link" href="<?=base_url('noticias.php')?>">Ler história →</a></div></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section map-home-section">
  <div class="container">
    <div class="section-head reveal"><div><span class="eyebrow">Ourinhos</span><h2>Veja onde os registros estão concentrados.</h2></div><a class="text-link" href="<?=base_url('mapa.php')?>">Abrir mapa completo →</a></div>
    <div class="map-mini">
      <div id="ourinhos-map" class="ourinhos-map" aria-label="Mapa de denúncias de Ourinhos"></div>
    </div>
  </div>
</section>

<section class="request-panel">
  <div class="container request-inner reveal">
    <div class="request-copy"><span class="eyebrow">Precisa registrar uma situação?</span><h2>Comece pelo que você sabe.</h2><p>Local, espécie, urgência e uma descrição já ajudam a equipe a entender o caso.</p></div>
    <a class="request-button" href="<?=base_url('denuncia.php')?>"><span>Registrar denúncia</span><b>→</b></a>
  </div>
</section>
<?php require __DIR__.'/includes/footer.php'; ?>
