<?php
$search = mysql_real_escape_string($url[1]);
$search = str_replace('-',' ',$search);
?>

<?php setArq('tpl/header'); ?>
<!-- Page Title -->
<div id="page-title">
    <h1 class="container">Pesquisa por: <?php echo strtoupper($search);?>
    	<?php
			$readPequisa = read('up_posts',"WHERE tipo = 'pagina' AND status = '1' AND (titulo LIKE '%$search%' OR content LIKE '%$search%' OR tags  LIKE '%$search%') ORDER BY data DESC");
			echo '<span class="sub-title">Sua pesquisa retornou <strong>';
			echo count($readPequisa);
			echo '</strong> resultados!</span></h1>';
		?>
</div>

<!-- End of page title -->
 <div class="container">
      <hr class="sep40" />
    	<?php
			if(count($readPequisa) <= 0){
				echo '<br /><h2>Desculpe, sua pesquisa não retornou resultados.</h2>';
				echo '<p>Você pode tentar outros termos, ou navegar em nosso menu! Talvez você queira resumir sua pesquisa. 
				Pesquisas com muitas palavras as vezes não retornam resultados!</p>';
				echo '<hr class="sep40" />';
			}else{
					$pag = (empty($url[3]) ? '1' : $url[3]);
					$maximo = 7;
					$inicio = ($pag * $maximo) - $maximo;
					$readSearch = read('up_posts',"WHERE tipo = 'pagina' AND status = '1' AND (titulo LIKE '%$search%' OR content LIKE '%$search%' OR tags LIKE '%$search%') ORDER BY data DESC LIMIT $inicio, $maximo");
					foreach($readSearch as $pesquisa):
						echo '<div class="one-fourth"><hr class="sep10" />';
							echo '<div class="metro-box blue-gradient fullwidth">';
							echo '<div class="metro-box-icon"><i class="icon-ok"></i></div>';
							
							echo '<div class="metro-box-title"><h5>'.$pesquisa['tags'].'</h5></div>';
							
							echo '</div>';
						echo '</div>';

						echo '<div class="three-fourth last-in-row">';
							echo '<h1>'.$pesquisa['titulo'].'</h1>';
							echo '<p class="intro">'.lmWord($pesquisa['subtitulo'],40).'</p>';
						echo '<a href="'.BASE.'/sessao/'.$pesquisa['url'].'" title="Ver mais de '.$pesquisa['titulo'].'">Acessar</a>';
						echo '</div>';

						echo '<hr class="sep40" />';
					endforeach;		
							
			
				$link = BASE.'/pesquisa/'.str_replace(' ','-',$search).'/pagina/';
				readPaginator('up_posts',"WHERE tipo = 'pagina' AND status = '1' AND (titulo LIKE '%$search%' OR content LIKE '%$search%' OR tags  LIKE '%$search%') ORDER BY data DESC", $maximo, $link, $pag, '540px');
			}
		?> 
          </div><!-- container -->
   