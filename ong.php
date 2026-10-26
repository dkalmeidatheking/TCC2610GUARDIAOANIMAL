<?php
require __DIR__.'/includes/bootstrap.php';
$id=(int)($_GET['id']??0);
$ong=find_ong($id);
if(!$ong){http_response_code(404);exit('ONG não encontrada.');}
$pageTitle=$ong['nome'];
$linked=array_filter($animals,fn($a)=>$a['ong']===$id);
require __DIR__.'/includes/header.php';
?>
<section class="detail-hero ong-detail-hero">
  <div class="container ong-detail-head reveal">
    <div>
      <a class="back-link" href="<?=base_url('ongs.php')?>">← Voltar para ONGs</a>
      <span class="eyebrow" style="color:var(--mint)">ONG parceira · desde <?=$ong['ano']?></span>
      <h1><?=e($ong['nome'])?></h1>
      <p><?=e($ong['descricao'])?></p>
    </div>
    <div class="ong-hero-mini"><span>Atuação principal</span><strong><?=e($ong['foco'])?></strong><small><?=e($ong['cidade'])?> · <?=e($ong['bairro'])?></small></div>
  </div>
</section>
<section class="section ong-detail-content">
  <div class="container">
    <div class="ong-overview reveal">
      <div class="ong-main-photo"><img src="<?=e($ong['foto'])?>" alt="<?=e($ong['nome'])?>" loading="eager"></div>
      <div class="ong-story">
        <span class="eyebrow">Sobre a organização</span>
        <h2>Um trabalho feito no dia a dia.</h2>
        <p><?=e($ong['historia'])?></p>
        <p><?=e($ong['descricao'])?></p>
        <div class="ong-facts-row">
          <div><b><?=$ong['ano']?></b><span>Ano de criação</span></div>
          <div><b><?=$ong['voluntarios']?></b><span>Voluntários</span></div>
          <div><b><?=$ong['animais']?></b><span>Animais acompanhados</span></div>
        </div>
        <a class="btn btn-dark" href="contato.php">Falar com a rede</a>
      </div>
    </div>
  </div>
</section>
<section class="section section-soft ong-cases">
  <div class="container">
    <div class="section-head reveal">
      <div><span class="eyebrow">Casos acompanhados</span><h2>Animais que passaram por esta ONG</h2></div>
      <p><?=count($linked)?> perfil(is) demonstrativo(s) nesta página.</p>
    </div>
    <?php if($linked): ?>
    <div class="cards">
      <?php foreach($linked as $aid=>$a): ?>
      <article class="animal-card reveal"><a href="animal.php?id=<?=$aid?>"><div class="card-photo" style="background-image:url('<?=e($a['foto'])?>')"></div><div class="card-body"><span class="chip"><?=e($a['status'])?></span><h3><?=e($a['nome'])?></h3><div class="meta"><?=e($a['idade'])?> · <?=e($a['porte'])?> · <?=e($a['sexo'])?></div><p class="case-location"><strong>Encontrado em:</strong> <?=e($a['local'])?></p><p><?=e($a['temperamento'])?></p><span class="text-link">Abrir ficha →</span></div></a></article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
<section class="contact-strip"><div class="container contact-strip-inner reveal"><div><span class="eyebrow">Contato da ONG</span><h2>Quer saber mais sobre o trabalho?</h2><p><?=e($ong['email'])?> · <?=e($ong['contato'])?></p></div><a class="btn btn-mint" href="<?=base_url('contato.php')?>">Enviar mensagem</a></div></section>
<?php require __DIR__.'/includes/footer.php'; ?>
