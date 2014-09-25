<?php
error_reporting(0);
ob_start(); session_start();
require('../dts/dbaSis.php');
require('../dts/getSis.php');
require('../dts/setSis.php');
require('../dts/outSis.php');

if(!$_SESSION['autUser']){
	header('Location: index.php');
}else{
	$userId 	 = $_SESSION['autUser']['id'];
	$readAutUser = read('up_users',"WHERE id = '$userId'");	
	if($readAutUser){
		foreach($readAutUser as $autUser);
		if($autUser['nivel'] < '1' || $autUser['nivel'] > '2'){
			header('Location: '.BASE.'/pagina/perfil');	
		}
	}else{
		header('Location: index.php');	
	}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title><?php echo SITENAME;?> - Dashboard</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="noindex, nofollow" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	<link rel="stylesheet" href="css/style.css" media="all" />
	<!--[if IE]><link rel="stylesheet" href="css/ie.css" media="all" /><![endif]-->
	<!--[if IE 9]><link rel="stylesheet" href="css/ie9.css" media="all" /><![endif]-->
    <!--[if lt IE 9]><link rel="stylesheet" href="css/lt-ie-9.css" media="all" /><![endif]-->


</head>
<body>
    <?php require_once('includes/header.php');?>
    <?php require_once('includes/menu.php');?>   		
            
        <?php
            if(empty($_GET['exe'])){
                require('home.php');
            }elseif(file_exists($_GET['exe'].'.php')){
                require($_GET['exe'].'.php');
            }else{
               echo '<section class="alert">
               <div class="orange" style="color:#fff">
					<p>Desculpe, a página que você está tentando acessar é inválida.</p>
				</div>
				</section>';	

            }
        ?>

    
<div style="clear:both"></div> 
<footer>
	Desenvolvido por <a href="http://www.astralis.com.br" title="Sistema desenvolvido por Astralis">Astralis</a> &copy; Todos os direitos reservados - suporte@astralis.com.br
</footer>
</body>
    <?php  		
    		require_once('../js/jscSis.php');
			require_once('js/jsc.php');
			ob_end_flush();
	?>
</html>