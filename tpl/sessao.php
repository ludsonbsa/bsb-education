<?php
$artigoUrl  = mysql_real_escape_string($url[1]);
$readArtigo = read('up_posts',"WHERE url = '$artigoUrl' and tipo = 'pagina'");

if(!$readArtigo){
	header('Location: '.BASE.'/404');
}else
	foreach($readArtigo as $art);
	echo $art['url'];
	setViews($art['id']);
?>
<title><?php echo $art['titulo'].' | '.SITENAME;?></title>
<meta name="title" content="<?php echo $art['titulo'].' | '.SITENAME;?>" />
<meta name="description" content="<?php echo lmWord($art['content'],100);?>" />
<meta name="keywords" content="<?php echo $art['tags'];?>" />
<meta name="author" content="Studio UpInside" />   
<meta name="url" content="<?php echo BASE.'/artigo/'.$art['url'];?>" />  
<meta name="language" content="pt-br" /> 
<meta name="robots" content="INDEX,FOLLOW" /> 
</head>
<body>



<?php setArq('tpl/header'); ?>
<!-- Page Title -->
<div id="page-title">
    <h1 class="container"><?php echo $art['titulo'];?>
    <span class="sub-title"><?php echo $art['subtitulo'];?></span>
    </h1>
</div>
<!-- Fim de page title -->

<div id="content" class="clearfix">
    
  <div class="container">
	<hr class="sep40"></hr>
   	<?php echo $art['content'];?>
      
      	<?php
			$readArtGb = read('up_posts_gb',"WHERE post_id = '$art[id]'");
			if($readArtGb){
			echo '<ul class="gallery">';
				foreach($readArtGb as $gb):
					$gbnum++;
					echo '<li';
					if($gbnum%5==0) echo ' class="last" ';
					echo '>';
					getThumb($gb['img'], $art['titulo'].' ( imagem '.$gbnum.')', $art['titulo'], '100', '65', $art['id'], '', '', 't');
					echo '</li>';
				endforeach;
			echo '</ul><!-- //gallery -->';
			}
		?>    
 <!-- Fim de one half column -->
 	<hr class="sep40"></hr>
    </div>
</div>
<!-- Fim de content -->