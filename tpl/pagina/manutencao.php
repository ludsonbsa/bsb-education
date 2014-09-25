<?php
ob_start();
session_start();
require('../dts/dbaSis.php');
require('../dts/outSis.php');

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITENAME;?> - Manutenção</title>

<meta name="title" content="Site em manutenção - <?php echo SITENAME;?>" />
<meta name="description" content="Manutenção - <?php echo SITENAME;?>" />
<meta name="keywords" content="Manutenção, <?php echo SITENAME;?>" />

<meta name="author" content="Ludson Almeida" />   
<meta name="url" content="http://www.astralis.com.br" />
   
<meta name="language" content="pt-br" /> 
<meta name="robots" content="NOINDEX,NOFOLLOW" /> 

<link rel="icon" type="image/png" href="ico/chave.png" />
<link rel="stylesheet" href="<?php setHome();?>/admin/css/style.css" media="all" />

</head>

<body class="login">

	<section>
	<img src="images/logo.png" width="295" height="125" alt="Manutenção" title="Manutenção | BSB-TI" />
	<hr style="margin-bottom:10px;"/>
	
</div><!-- //login -->

</body>
<?php ob_end_flush();?>
</html>