<?php
require __DIR__.'/includes/bootstrap.php';
require __DIR__.'/includes/ourinhos.php';
require __DIR__.'/config/gemini.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    check_csrf();
    $cidade = 'Ourinhos - SP';
    $bairroInformado = trim((string)($_POST['bairro'] ?? ''));
    $bairros = array_keys(ourinhos_neighborhoods());
    $bairro = normalize_ourinhos_bairro($bairroInformado);
    $origemBairro = $bairro ? 'Formulário' : 'Não identificado';

    // Se houver GEMINI_API_KEY no servidor, a IA tenta normalizar o local.
    $bairroGemini = gemini_normalize_bairro(trim((string)($_POST['local'] ?? '')), $cidade, $bairros);
    if($bairroGemini){
        $bairro = $bairroGemini;
        $origemBairro = 'Gemini';
    }

    if(!$bairro){
        flash('bad','Selecione o bairro da ocorrência para que ela apareça no mapa de Ourinhos.');
        redirect('denuncia.php');
    }

    add_store('denuncias',[
        'nome'=>trim((string)($_POST['nome'] ?? '')) ?: 'Não informado',
        'email'=>trim((string)($_POST['email'] ?? '')),
        'telefone'=>trim((string)($_POST['telefone'] ?? '')),
        'especie'=>trim((string)($_POST['especie'] ?? '')),
        'urgencia'=>trim((string)($_POST['urgencia'] ?? '')),
        'cidade'=>$cidade,
        'bairro'=>$bairro,
        'bairro_origem'=>$origemBairro,
        'local'=>trim((string)($_POST['local'] ?? '')),
        'descricao'=>trim((string)($_POST['descricao'] ?? '')),
        'identificacao'=>isset($_POST['identificacao'])?'Sim':'Não',
        'status'=>'Recebida'
    ]);

    flash('ok','Denúncia registrada. O mapa de Ourinhos foi atualizado com este novo registro.');
    redirect('mapa.php');
}

$includeMapAssets=false;
$pageTitle='Denúncia';
require __DIR__.'/includes/header.php';
$bairros=array_keys(ourinhos_neighborhoods());
?>
<section class="page-hero">
  <div class="container">
    <span class="eyebrow">Denúncia · Ourinhos</span>
    <h1>O que você viu merece ser registrado.</h1>
    <p>Informe o local, o bairro e o que aconteceu. Cada registro ajuda a mostrar onde a rede precisa estar mais atenta.</p>
  </div>
</section>
<section class="section">
  <div class="container form-shell">
    <div style="margin-bottom:24px"><span class="eyebrow">Leva poucos minutos</span><h2>Registrar uma ocorrência</h2><p>O bairro é usado para atualizar o mapa de denúncias de Ourinhos. Se a chave do Gemini estiver configurada, a IA também analisa o texto do local para tentar confirmar o bairro.</p></div>
    <form method="post">
      <input type="hidden" name="csrf" value="<?=csrf()?>">
      <div class="form-grid">
        <div class="field"><label>Seu nome</label><input name="nome" placeholder="Pode deixar em branco"></div>
        <div class="field"><label>E-mail</label><input type="email" name="email"></div>
        <div class="field"><label>Telefone</label><input name="telefone"></div>
        <div class="field"><label>Espécie</label><select name="especie"><option>Cão</option><option>Gato</option><option>Outro</option><option>Não sei informar</option></select></div>
        <div class="field"><label>Urgência</label><select name="urgencia"><option>Baixa</option><option>Média</option><option>Alta</option><option>Emergência</option></select></div>
        <div class="field"><label>Cidade</label><input value="Ourinhos - SP" readonly></div>
        <div class="field full"><label>Bairro da ocorrência</label><select name="bairro" required><option value="">Selecione o bairro</option><?php foreach($bairros as $bairro): ?><option value="<?=e($bairro)?>"><?=e($bairro)?></option><?php endforeach; ?></select></div>
        <div class="field full"><label>Local exato ou referência</label><input name="local" placeholder="Rua, número, esquina, ponto de referência..." required></div>
        <div class="field full"><label>O que aconteceu?</label><textarea name="descricao" required placeholder="Conte o que você viu, desde quando e se o animal está ferido ou preso."></textarea></div>
      </div>
      <label class="check"><input type="checkbox" name="identificacao"> Quero me identificar para facilitar o retorno da equipe.</label>
      <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center"><button class="btn btn-dark">Enviar denúncia</button><a class="btn btn-outline" href="<?=base_url('mapa.php')?>">Ver mapa de Ourinhos</a></div>
    </form>
  </div>
</section>
<?php require __DIR__.'/includes/footer.php'; ?>
