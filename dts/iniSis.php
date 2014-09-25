<?php
//DEFINE BANCO DEDADOS
define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DBSA','bsbti01');

try{
    $banco = new PDO('mysql:host='.HOST.';dbname='.DBSA.';',USER,PASS);
}catch(PDOException $e){
    echo $e->getCode().': '.$e->getMessage();
}
$query = "SELECT * FROM up_config";
$stmt = $banco->prepare($query);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

foreach($retRows = $stmt->fetchAll() as $config);

//BASE DO SITE
define('BASE','http://localhost/bsb-education');
define('SITENAME','BSB-TI Education');
define('AUTOR','Astralis');
define('SITEDESC',$config['descricao']);
define('SITETAGS',$config['tags']);
//DEFINE O SERVIDOR DE E-MAIL

define('MAILUSER',$config['email']);
define('MAILPASS',$config['senha']);
define('MAILPORT',$config['mailport']);
define('MAILHOST',$config['smtp']);

//MEUS DADOS
define('ENDERECO',$config['endereco']);
define('TELEFONE',$config['telefone']);
?>