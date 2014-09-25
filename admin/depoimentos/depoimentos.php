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
		
		delete('up_depoimento',"id = '$delId'");

		//Auditoria
		$a['usuario']	= $_SESSION['autUser']['nome'];
		$a['acao'] 		= 'Removeu o depoimento #'.$delId;
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
			<span class="icon">&#59160;</span>
			<hgroup>
				<h1>Depoimentos</h1>
				<h2>Editar Depoimentos</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=depoimentos/depoimentos-create" style="color:#fff"><button class="green">Criar Depoimento</button></a>
			</aside>
		</header>
    <?php
    $readArt = read('up_depoimento');
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
						<th>Nome</th>
						<th>Depoimento</th>
						<th>Data</th>
						<th colspan="2">Ações</th>
					</tr>
				</thead>
				<tbody>
      <?php
	  	foreach($readArt as $art):
			$stIco = ($art['tags'] == '' ? 'alert.png' : 'ok.png');
			echo '<tr>';
			echo '<td>'.$art['nome'].'</td>';
			echo '<td>'.$art['depoimento'].'</td>';
			echo '<td>'.date('d/m/Y H:i:s',strtotime($art['data'])).'</td>';

			echo '<td><a href="index2.php?exe=depoimentos/depoimentos-edit&editid='.$art['id'].'" title="editar">';
				echo '<img src="ico/edit.png" alt="editar" title="editar" /></a></td>';
			echo '<td><a href="index2.php?exe=depoimentos/depoimentos&pag='.$pag.'&delid='.$art['id'].'"';
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