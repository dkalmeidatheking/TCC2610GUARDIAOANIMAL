<?php
require __DIR__.'/includes/bootstrap.php';
global $animals;
if($_SERVER['REQUEST_METHOD']==='POST'){
    check_csrf();
    $id=(int)$_POST['animal_id'];
    $a=find_animal($id);
    if($a){
        add_store('apadrinhamentos',['animal_id'=>$id,'animal'=>$a['nome'],'nome'=>trim($_POST['nome']),'email'=>trim($_POST['email']),'valor'=>trim($_POST['valor']),'mensagem'=>trim($_POST['mensagem']),'status'=>'Em análise']);
        flash('ok','Seu interesse em apadrinhar '.$a['nome'].' foi registrado.');
        redirect('apadrinhar.php');
    }
}
$pageTitle='Apadrinhar';
require __DIR__.'/includes/header.php';
$listed=[]; foreach($animals as $id=>$a) if($a['status']==='Apadrinhamento') $listed[$id]=$a;
?>
<section class="page-hero"><div class="container"><span class="eyebrow">Apadrinhamento</span><h1>Alguns animais precisam de tempo antes de precisar de um lar.</h1><p>O apadrinhamento ajuda a bancar rotina, tratamento, ração e exames enquanto o animal ainda está em recuperação.</p></div></section>
<section class="section"><div class="container cards">
<?php foreach($listed as $id=>$a): ?>
<article class="animal-card"><div class="card-photo" style="background-image:url('<?=e($a['foto'])?>')"></div><div class="card-body"><span class="chip">Precisa de padrinho</span><h3><?=e($a['nome'])?></h3><div class="meta"><span><?=e($a['idade'])?></span><span>·</span><span><?=e($a['porte'])?></span></div><p><?=e($a['temperamento'])?></p><div class="card-bottom"><a class="text-link" href="animal.php?id=<?=$id?>">Ver história →</a><a class="btn btn-mint" href="#form">Apadrinhar</a></div></div></article>
<?php endforeach; ?>
</div></section>
<section class="section section-soft" id="form"><div class="container form-shell"><span class="eyebrow">Cadastro</span><h2>Quero apadrinhar</h2><form method="post"><input type="hidden" name="csrf" value="<?=csrf()?>"><div class="form-grid"><div class="field"><label>Animal</label><select name="animal_id" required><?php foreach($listed as $id=>$a):?><option value="<?=$id?>"><?=e($a['nome'])?></option><?php endforeach;?></select></div><div class="field"><label>Valor mensal</label><select name="valor"><option>R$ 30</option><option>R$ 50</option><option>R$ 80</option><option>Outro valor</option></select></div><div class="field"><label>Nome</label><input name="nome" required></div><div class="field"><label>E-mail</label><input type="email" name="email" required></div><div class="field full"><label>Mensagem</label><textarea name="mensagem" placeholder="Quer contar por que escolheu ajudar?"></textarea></div></div><button class="btn btn-dark">Enviar cadastro</button></form></div></section>
<?php require __DIR__.'/includes/footer.php'; ?>
