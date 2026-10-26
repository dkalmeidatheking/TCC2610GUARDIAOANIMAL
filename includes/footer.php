</main>
<footer class="site-footer">
  <div class="container footer-main">
    <div class="footer-brand">
      <a class="footer-logo" href="<?=base_url()?>" aria-label="Página inicial do Guardião Animal"><img src="<?=base_url('assets/img/logo-guardiao-circular.png')?>" alt="Logo Guardião Animal"></a>
      <div class="footer-brand-text"><strong>Guardião Animal</strong><p>Uma rede para organizar informações, aproximar pessoas e facilitar o cuidado.</p></div>
    </div>
    <div class="footer-columns">
      <div><h4>Explorar</h4><a href="<?=base_url('adocao.php')?>">Adoção</a><a href="<?=base_url('ongs.php')?>">ONGs</a><a href="<?=base_url('noticias.php')?>">Histórias</a></div>
      <div><h4>Participar</h4><a href="<?=base_url('denuncia.php')?>">Fazer denúncia</a><a href="<?=base_url('doacao.php')?>">Doar</a><a href="<?=base_url('apadrinhar.php')?>">Apadrinhar</a></div>
      <div><h4>Projeto</h4><a href="<?=base_url('sobre.php')?>">Sobre</a><a href="<?=base_url('mapa.php')?>">Mapa de denúncias</a><a href="<?=base_url('contato.php')?>">Contato</a><a href="<?=base_url('admin/login.php')?>">Área administrativa</a></div>
    </div>
  </div>
  <div class="container footer-bottom"><span>© <?=date('Y')?> Guardião Animal</span><span>Projeto acadêmico</span><a href="#main">Voltar ao topo ↑</a></div>
</footer>
<script src="<?=base_url('assets/js/app.js')?>?v=13"></script>
<?php if(!empty($includeMapAssets)): ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>
<script src="<?=base_url('assets/js/ourinhos-map.js')?>?v=16"></script>
<?php endif; ?>
</body></html>
