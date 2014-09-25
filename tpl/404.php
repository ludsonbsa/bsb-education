<!-- Meta -->
	<meta charset="utf-8">
	<meta name="keywords" content="<?php echo SITETAGS; ?> - 404" />
	<meta name="description" content="<?php echo SITEDESC; ?> - 404">
	<meta name="author" content="BSB-TI Services - 404">
	<meta name="robots" content="all" />
    <meta name="rating" content="general" /> 
    <meta name="googlebot" content="noodp" />
    <meta name="expires" content="never" /> 
    <meta name="publisher" content="BSB-TI Services - 404" />
    <meta name="copyright" content="Astralis Desenvolvimento de Sistemas Web" />
    <meta name="language" content="pt-br" /> 
	<meta name="robots" content="INDEX,FOLLOW" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>BSB-TI | Services - 404</title>
</head>
<body>

<?php setArq('tpl/header'); ?>
<!-- Page Title -->
<div id="page-title">
    <h1 class="container">404
    <span class="sub-title">Página não encontrada</span>
    </h1>
</div>
<!-- End of page title -->
<!-- Content -->
<div id="content" class="clearfix">
    
  <div class="container">
      <hr class="sep80" />
        <!-- 404 -->
        <div class="three-fifth">
          <span class="sign-404">404 <i class="icon-file"></i> </span>
          <span class="info-404">A página que você está tentando acessar não existe...</span>
        </div>
        <!-- End of 404 -->
        <!-- Navigation list -->
        <div class="two-fifth last-in-row">
          <h3><strong>Ou</strong> tente:</h3>
          <ul class="nav-list">
            <li><a href="<?php echo setHome();?>">Home</a></li>
            <li><a href="<?php echo setHome().'/sessao/sobre'?>">Sobre</a></li>
            <li><a href="<?php echo setHome().'/sessao/parceiros'?>">Parceiros</a></li>
            <li><a href="<?php echo setHome().'/pagina/contato'?>">Contato</a></li>
          </ul>
        </div>
        <!-- End of navigation list --> 
      <hr class="sep80" />
    </div>
</div>
<!-- End of content -->