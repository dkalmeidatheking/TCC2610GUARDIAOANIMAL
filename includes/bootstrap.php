<?php
declare(strict_types=1);
session_start();
require __DIR__.'/data.php';
define('ROOT_PATH', dirname(__DIR__));
define('STORAGE_PATH', ROOT_PATH.'/storage');
if (!is_dir(STORAGE_PATH)) @mkdir(STORAGE_PATH, 0775, true);
function e(?string $v): string { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function base_url(string $path=''): string { static $base=null; if($base===null){$root=realpath(ROOT_PATH);$doc=realpath($_SERVER['DOCUMENT_ROOT']??'');$base='';if($root&&$doc&&str_starts_with(str_replace('\\','/',$root),str_replace('\\','/',$doc))){$base='/'.trim(str_replace('\\','/',substr($root,strlen($doc))),'/');}} return rtrim($base,'/').'/'.ltrim($path,'/'); }
function json_store(string $name): string { return STORAGE_PATH.'/'.$name.'.json'; }
function read_store(string $name): array { $file=json_store($name); if(!file_exists($file)) return []; $data=json_decode((string)file_get_contents($file),true); return is_array($data)?$data:[]; }
function add_store(string $name,array $row): void { $data=read_store($name); $row['id']=count($data)+1; $row['created_at']=date('Y-m-d H:i:s'); $data[]=$row; file_put_contents(json_store($name),json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)); }
function csrf(): string { if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(24)); return $_SESSION['csrf']; }
function check_csrf(): void { if(!hash_equals($_SESSION['csrf']??'',$_POST['csrf']??'')){http_response_code(419);exit('Formulário expirado. Atualize a página.');} }
function flash(string $type,string $msg): void { $_SESSION['flash']=['type'=>$type,'msg'=>$msg]; }
function take_flash(): ?array { $f=$_SESSION['flash']??null; unset($_SESSION['flash']); return $f; }
function redirect(string $to): never { header('Location: '.base_url($to)); exit; }
function is_admin(): bool { return !empty($_SESSION['admin']); }
function require_admin(): void { if(!is_admin()) redirect('admin/login.php'); }
function find_ong(int $id): ?array { global $ongs; return $ongs[$id]??null; }
function find_animal(int $id): ?array { global $animals; return $animals[$id]??null; }
