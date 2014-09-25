<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'2')){
		header('Location: index2.php');
	}else{
		
	if(isset($_POST['sendFiltro'])){
		$search = $_POST['search'];
		if(!empty($search) && $search != 'Titulo:'){
			$_SESSION['where'] = "AND titulo LIKE '%$search%'";
			header('Location: index2.php?exe=posts/posts');
		}else{
			unset($_SESSION['where']);
			header('Location: index2.php?exe=posts/posts');
		}
	}
?>
<section class="content">
		<section class="widget">
		<header>
			<span class="icon">&#9998;</span>
			<hgroup>
				<h1>Artigos</h1>
				<h2>Listar Artigos</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=posts/posts-create" style="color:#fff"><button class="green">Criar Artigo</button></a>
			</aside>
		</header>
    <?php
	
	
	//REMOVE O POST
	if(!empty($_GET['delid'])){
		$delId = $_GET['delid'];
		$thumb = $_GET['thumb'];
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
		
		
		if(file_exists($pasta.$thumb) && !is_dir($pasta.$thumb)){
			unlink($pasta.$thumb);
		}
			delete('up_posts',"id = '$delId'");
			
			//Auditoria
			$a['usuario']	= $_SESSION['autUser']['nome'];
			$a['acao'] 		= 'Removeu o artigo #'.$delId;
			$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
			$a['data'] 		= formDate($a['date']); 
			unset($a['date']);
			create('up_auditoria',$a);
			//Fim Auditoria
	}
	
	
	$pag = (empty($_GET['pag']) ? '1' : $_GET['pag']);
	$maximo = 10;
	$inicio = ($pag * $maximo) - $maximo;
	$readArt = read('up_posts',"WHERE tipo = 'post' {$_SESSION[where]} ORDER BY data DESC LIMIT $inicio,$maximo");
	if(!$readArt){
		echo '<div class="orange">	
				<p>Ainda não existem registros nesta página.</p>
			</div>';
	}else{
		?>
		<div class="content">
			<table id="myTable" border="0" width="100">
				<thead>
					<tr>
						<th>Titulo</th>
						<th>Data</th>
						<th>Categoria</th>
						<th>Visitas</th>
						<th colspan="4">Ações</th>
					</tr>
				</thead>
				<tbody>
      <?php
	  	foreach($readArt as $art):
			$views = ($art['visitas'] != '' ? $art['visitas'] : '0');
			$stIco = ($art['status'] == '0' ? 'alert.png' : 'ok.png');
			$stSta = ($art['status'] == '0' ? 'Ativar Artigo' : 'Desativar Artigo');
			echo '<tr>';
				echo '<td><a href="'.BASE.'/artigo/'.$art['url'].'" title="'.$art['titulo'].'" target="_blank">'.lmWord($art['titulo'],30).'</a></td>';
				echo '<td>'.date('d/m/y H:i',strtotime($art['data'])).'</td>';
				echo '<td><a target="_blank" href="'.BASE.'/categoria/'.getCat($art['categoria'],'url').'" ';
				echo 'title="'.getCat($art['categoria'],'url').'">'.getCat($art['categoria'],'nome').'</a></td>';
				echo '<td>'.$views.'</td>';
				echo '<td><a href="index2.php?exe=posts/posts-edit&editid='.$art['id'].'" title="Editar">';
					echo '<img src="ico/edit.png" alt="Editar" title="Editar" /></a></td>';
				echo '<td><a href="index2.php?exe=posts/gallery&postid='.$art['id'].'" title="Postar Galeria">';
					echo '<img src="ico/gb.png" alt="postar galeria" title="Postar Galeria" /></a></td>';
				echo '<td><a href="index2.php?exe=posts/posts&pag='.$pag.'&sts='.$art['status'].'&id='.$art['id'].'" ';
					echo 'title="'.$stSta.'"><img src="ico/'.$stIco.'" alt="'.$stSta.'" title="'.$stSta.'" /></a></td>';
				echo '<td><a href="index2.php?exe=posts/posts&pag='.$pag.'&delid='.$art['id'].'&thumb='.$art['thumb'].'"';
					echo 'title="excluir"><img src="ico/no.png" alt="Excluir" title="Excluir" /></a></td>';
			echo '</tr>';
		endforeach;
		echo '<tbody>';
		echo '</table>';
		$link = 'index2.php?exe=posts/posts&pag=';
		readPaginator('up_posts',"WHERE tipo = 'post' {$_SESSION[where]} ORDER BY data DESC", $maximo, $link, $pag);
	}


	//ALTERA STATUS DO POST
	if(isset($_GET['sts'])){
		$status = $_GET['sts'];
		$topicoid = $_GET['id'];
		if($status == '0'){
			$datas = array('status' => '1');

			update('up_posts',$datas,"id = '$topicoid'");

				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Ativou o artigo '.$art['titulo'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria
				header('Refresh: 0;url='.BASE.'/admin/index2.php?exe=posts/posts');

		}else{
			$datas = array('status' => '0');
			update('up_posts',$datas,"id = '$topicoid'");	

				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Desativou o artigo '.$art['titulo'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria		
				header('Refresh: 0;url='.BASE.'/admin/index2.php?exe=posts/posts');
		}
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