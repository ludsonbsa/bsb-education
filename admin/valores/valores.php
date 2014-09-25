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
		
		delete('up_valores',"id = '$delId'");

		//Auditoria
		$a['usuario']	= $_SESSION['autUser']['nome'];
		$a['acao'] 		= 'Removeu a página #'.$delId;
		$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
		$a['data'] 		= formDate($a['date']); 
		unset($a['date']);
		create('up_auditoria',$a);
		//Fim Auditoria
	}
	
?>
<section class="content">
		<section class="widget">
		<header>
			<span class="icon">&#128188;</span>
			<hgroup>
				<h1>Institucional</h1>
				<h2>Editar textos institucionais</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=valores/valores-create" style="color:#fff"><button class="green">Criar Valor</button></a>
			</aside>
		</header>
    <?php
    $readArt = read('up_valores');
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
						<th>Link</th>
						<th>Data</th>
						<th colspan="2">Ações</th>
					</tr>
				</thead>
				<tbody>
      <?php
	  	foreach($readArt as $art):
			$stIco = ($art['tags'] == '' ? 'alert.png' : 'ok.png');
			echo '<tr>';
			echo '<td>'.lmWord($art['titulo'],20).'</td>';
			echo '<td>'.lmWord($art['link'],30).'</td>';
			echo '<td>'.date('d/m/Y H:i',strtotime($art['data'])).'</td>';

			echo '<td><a href="index2.php?exe=valores/valores-edit&editid='.$art['id'].'" title="editar">';
				echo '<img src="ico/edit.png" alt="editar" title="editar" /></a></td>';
			echo '<td><a href="index2.php?exe=valores/valores&pag='.$pag.'&delid='.$art['id'].'"';
				echo 'title="excluir"><img src="ico/no.png" alt="excluir" title="excluir" /></a></td>';
			echo '</tr>';
		endforeach;
		echo '</tbody>';
		echo '</table>';
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