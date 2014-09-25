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
			header('Location: index2.php?exe=usuarios/usuarios');
		}else{
			unset($_SESSION['where']);
			header('Location: index2.php?exe=usuarios/usuarios');
		}
	}
?>
<section class="content">
	<section class="widget">
		<header>
			<span class="icon">&#128100;</span>
			<hgroup>
				<h1>Auditoria</h1>
				<h2>Ações do sistema</h2>
			</hgroup>
		</header>
		<?php
		
	
		$pag = (empty($_GET['pag']) ? '1' : $_GET['pag']);
		$maximo = 18;
		$inicio = ($pag * $maximo) - $maximo;
		$readUser = read('up_auditoria',"WHERE id != '$userId' {$_SESSION[where]} ORDER BY id ASC, data ASC LIMIT $inicio,$maximo");
		if(!$readUser){
			echo '<div class="orange">	
					<p>Ainda não existem usuários cadastrados.</p>
				 </div>';
		}else{
		?>
		<div class="content">
			<table id="myTable" border="0" width="100">
				<thead>
					<tr>
						<th>ID</th>
						<th>Usuário</th>
						<th>Ação</th>
						<th>Data</th>
					</tr>
				</thead>
					<tbody>
						<?php
							foreach($readUser as $user):
							echo '<tr>';
								echo '<td>#'.$user['id'].'</td>';
								echo '<td>'.$user['usuario'].'</td>';
								echo '<td>'.$user['acao'].'</td>';
								echo '<td>'.date('d/m/Y H:i:s',strtotime($user['data'])).'</td>';
							echo '</tr>';
							endforeach;
							echo '</tbody>';
							echo '</table>';
							$link = 'index2.php?exe=auditoria/auditoria&pag=';
							readPaginator('up_auditoria',"WHERE id != '$userId' {$_SESSION[where]} ORDER BY id ASC, data ASC",$maximo, $link, $pag);
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