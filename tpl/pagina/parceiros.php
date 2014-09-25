<!-- Meta -->
    <meta charset="utf-8">
    <meta name="keywords" content="<?php echo SITETAGS; ?>" />
    <meta name="description" content="<?php echo SITEDESC; ?>">
    <meta name="author" content="BSB-TI Services">
    <meta name="robots" content="all" />
    <meta name="rating" content="general" /> 
    <meta name="googlebot" content="noodp" />
    <meta name="expires" content="never" /> 
    <meta name="publisher" content="BSB-TI Services" />
    <meta name="copyright" content="Astralis Desenvolvimento de Sistemas Web" />
    <meta name="language" content="pt-br" /> 
    <meta name="robots" content="INDEX,FOLLOW" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BSB-TI | Services :: Parceiros</title>
</head>
<body>

<?php setArq('tpl/header'); ?>

<!-- Page Title -->
<div id="page-title">
    <h1 class="container">Parceiros
    <span class="sub-title">Afiliados e Parceiros.</span>
    
    </h1>
</div>
<!-- End of page title -->

  <div class="container">
      <hr class="sep40" />
      <!-- cliente -->
      <?php 
      $lerP = read('up_parceiros',"ORDER by id DESC");
      foreach($lerP as $p):
      ?>
      <!-- Serviço icon -->
      <div class="one-fourth">
        <hr class="sep10" />
        <a href="<?php echo $p['link'];?>" target="_blank" title="<?php echo $p['nome'];?>">
          <div class="metro-box blue-gradient fullwidth">
            <img src="<?php setHome(); echo '/uploads/parceiros/'.$p['thumb'];?>" width="240" height="170"  />
            <div class="metro-box-title"><h5><?php echo $p['nome'];?></h5></div>
        </div>
      </a>
      </div>
      <!-- End of icon -->
      <div class="three-fourth last-in-row">
        <!-- Intro -->
        <h1 class="intro-header"><?php echo $p['nome'];?></h1>
        <p class="intro"><?php echo $p['descricao'];?></p>
        <p><a href="<?php echo $p['link'];?>" target="_blank">Visitar site</a></p>
        <!-- End of intro -->        
      </div>
      <!-- cliente -->
      <hr class="sep40" />
    <?php endforeach;?>
     </div>
      <!-- end cliente -->

      <hr class="sep40" />
