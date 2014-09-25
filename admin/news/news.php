<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '
				<div class="red">	
					<p>Você não tem permissão para acessar esta página.</p>
				</div>
			 ';
	}else{
		
	$userId = $_SESSION['autUser']['id'];
		
	if(isset($_POST['sendFiltro'])){
		$search = $_POST['search'];
		if(!empty($search) && $search != 'Nome:'){
			$_SESSION['where'] = "AND nome LIKE '%$search%'";
			header('Location: index2.php?exe=news/news');
		}else{
			unset($_SESSION['where']);
			header('Location: index2.php?exe=news/news');
		}
	}
?>
<section class="content">
	<section class="widget">
		<header>
			<span class="icon">&#128100;</span>
			<hgroup>
				<h1>Newsletter</h1>
				<h2>E-mails cadastrados</h2>
			</hgroup>
		</header>
		<?php
		if(!empty($_GET['deluser'])){
			$delUserId = $_GET['deluser'];
			delete('up_newsletter',"id = '$delUserId'");
			echo '<div class="orange">
				  <p>
					Registro deletado.
				  </p>
				  </div>
					';	 
		}
	
		$pag = (empty($_GET['pag']) ? '1' : $_GET['pag']);
		$maximo = 18;
		$inicio = ($pag * $maximo) - $maximo;
		$readUser = read('up_newsletter',"WHERE id != '$userId' {$_SESSION[where]} ORDER BY id ASC, email ASC LIMIT $inicio,$maximo");
		if(!$readUser){
			echo '<div class="orange">	
					<p>Ainda não existem registros.</p>
				 </div>';
		}else{
		?>
		<div class="content">
			<table id="myTable" border="0" width="100">
				<thead>
					<tr>
						<th>ID</th>
						<th>IP</th>
						<th>E-mail</th>
						<th>Ações</th>
					</tr>
				</thead>
					<tbody>
						<?php
							foreach($readUser as $user):
							echo '<tr>';
								echo '<td>#'.$user['id'].'</td>';
								echo '<td>'.$user['nome'].'</td>';
								echo '<td>'.$user['email'].'</td>';
								echo '<td><a href="index2.php?exe=news/news&deluser='.$user['id'].'" title="Excluir"><img src="ico/no.png" alt="Excluir" title="Excluir" /></a></td>';
							echo '</tr>';
							endforeach;
							echo '</tbody>';
							echo '</table>';
							$link = 'index2.php?exe=news/news&pag=';
							readPaginator('up_newsletter',"WHERE id != '$userId' {$_SESSION[where]} ORDER BY id ASC, email ASC",$maximo, $link, $pag);
							}
						?>

		</div>

	</section>
	<span class="button blue"><a href="news/export.php" class="excel btn">Exportar para Excel</a></span>
</section>


<?php
	}
}else{
	header('Location: ../index2.php');
}
?>