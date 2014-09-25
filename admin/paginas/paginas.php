<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<div class="red">	
					<p>Você não tem permissão para acessar esta página.</p>
			   </div>';
	}else{
?>
<?php
	//REMOVE O Páginas
	if(!empty($_GET['delid'])){
		$delId = $_GET['delid'];
		echo '';
		$pasta = '../uploads/';
		$readGbDel = read('up_posts_gb',"WHERE post_id = '$delId'");
		if($readGbDel){
			foreach($readGbDel as $gbDel):
				if(file_exists($pasta.$gbDel['img']) && !is_dir($pasta.$gbDel['img'])){
					unlink($pasta.$gbDel['img']);
				}
			endforeach;	
			delete('up_posts_gb',"post_id = '$delId'");
		}
		delete('up_posts',"id = '$delId'");

		//Auditoria
		$a['usuario']	= $_SESSION['autUser']['nome'];
		$a['acao'] 		= 'Removeu a página #'.$delId;
		$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
		$a['data'] 		= formDate($a['date']); 
		unset($a['date']);
		create('up_auditoria',$a);
		//Fim Auditoria
	}
	
	$pag = (empty($_GET['pag']) ? '1' : $_GET['pag']);
	$maximo = 10;
	$inicio = ($pag * $maximo) - $maximo;
	$readArt = read('up_posts',"WHERE tipo = 'pagina' {$_SESSION[where]} ORDER BY data DESC LIMIT $inicio,$maximo");
?>
<section class="content">
		<section class="widget">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>Páginas</h1>
				<h2>Editar Páginas</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=paginas/paginas-create" style="color:#fff"><button class="green">Criar Página</button></a>
			</aside>
		</header>
    <?php
	if(!$readArt){
		echo '
				<div class="orange">	
					<p>Ainda não existem registros nesta página.</p>
				</div>
			';
	}else{
		?>
	
		<div class="content">
			<table id="myTable" border="0" width="100">
				<thead>
					<tr>
						<th>Titulo</th>
						<th>Resumo</th>
						<th>Tags</th>
						<th>Criada</th>
						<th colspan="3">Ações</th>
					</tr>
				</thead>
				<tbody>
      <?php
	  	foreach($readArt as $art):
			$stIco = ($art['tags'] == '' ? 'alert.png' : 'ok.png');
			echo '<tr>';
			echo '<td><a href="'.BASE.'/sessao/'.$art['url'].'" title="'.$art['titulo'].'" target="_blank">'.lmWord($art['titulo'],20).'</a></td>';
			echo '<td>'.lmWord($art['content'],30).'</td>';
			echo '<td><img src="ico/'.$stIco.'" alt="'.$art['tags'].'" title="'.$art['tags'].'" /></a></td>';
			echo '<td>'.date('d/m/y H:i',strtotime($art['data'])).'</td>';
			echo '<td><a href="index2.php?exe=paginas/paginas-edit&editid='.$art['id'].'" title="editar">';
				echo '<img src="ico/edit.png" alt="editar" title="editar" /></a></td>';
			echo '<td><a href="index2.php?exe=paginas/gallery&postid='.$art['id'].'" title="postar galeria">';
				echo '<img src="ico/gb.png" alt="postar galeria" title="postar galeria" /></a></td>';
			echo '<td><a href="index2.php?exe=paginas/paginas&pag='.$pag.'&delid='.$art['id'].'"';
				echo 'title="excluir"><img src="ico/no.png" alt="excluir" title="excluir" /></a></td>';
			echo '</tr>';
		endforeach;
		echo '</tbody>';
		echo '</table>';

		$link = 'index2.php?exe=paginas/paginas&pag=';
		readPaginator('up_posts',"WHERE tipo = 'pagina' {$_SESSION[where]} ORDER BY data DESC", $maximo, $link, $pag);
	}
	?>

			</div>
		</section>
	</section>
<?php
	}
}else{
	header('Location: ../index2.php');
}
?>