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
				<h1>Usuários</h1>
				<h2>Membros Registrados</h2>
			</hgroup>
        	<aside>
				<a href="index2.php?exe=usuarios/usuarios-create" style="color:#fff"><button class="green">Novo Usuário</button></a>
			</aside>
		</header>
		<?php
		if(!empty($_GET['deluser'])){
			$delUserId = $_GET['deluser'];
			$readDelUser = read('up_users',"WHERE id = '$delUserId'");
			if(!$readDelUser){
				echo '<div class="orange">	
							<p>Usuário não existe.</p>
					  </div>';
			}else{
				foreach($readDelUser as $delUser);
				if($delUser['id'] == $userId){
					echo '<div class="orange">	
								<p>Você não pode remover seu perfil.</p>
						  </div>';	
				}elseif($delUser['nivel'] == '1'){
					echo '<div class="orange">	
								<p>Você não pode remover um administrador.</p>
						  </div>';	
				}else{
					echo '<div class="orange">	
								<p>Atenção, tem certeza que deseja excluir o usuário '.strtoupper($delUser['nome']).'
								[ <a href="index2.php?exe=usuarios/usuarios" title="Não">Não</a> ] - 
						  [ <a href="index2.php?exe=usuarios/usuarios&delusertrue='.$delUser['id'].'" title="Sim">Sim</a> ]
						  </p></div>
						';		
				}
			}
		}
		if(!empty($_GET['delusertrue'])){
			$delUserTrue = $_GET['delusertrue'];
			$readDelAvatar = read('up_users',"WHERE id = '$delUserTrue'");
			foreach($readDelAvatar as $delAvatar);
			$pasta	= '../uploads/avatars/';
			if(file_exists($pasta.$delAvatar['avatar']) && !is_dir($pasta.$delAvatar['avatar'])){
				unlink($pasta.$delAvatar['avatar']);
			}
			
			//Auditoria
			$a['usuario']	= $_SESSION['autUser']['nome'];
			$a['acao'] 		= 'Removeu o usuário #'.$delUserTrue;
			$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
			$a['data'] 		= formDate($a['date']); 
			unset($a['date']);
			create('up_auditoria',$a);
			//Fim Auditoria

			delete('up_users',"id = '$delUserTrue'");
			header('Location: index2.php?exe=usuarios/usuarios');
		}
	
		$pag = (empty($_GET['pag']) ? '1' : $_GET['pag']);
		$maximo = 10;
		$inicio = ($pag * $maximo) - $maximo;
		$readUser = read('up_users',"WHERE id != '$userId' {$_SESSION[where]} ORDER BY nivel ASC, nome ASC LIMIT $inicio,$maximo");
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
						<th class="avatar">Imagem</th>
						<th>Nome</th>
						<th>E-mail</th>
						<th>Nível</th>
						<th>Data</th>
						<th colspan="3">Ações</th>
					</tr>
				</thead>
					<tbody>
						<?php
							foreach($readUser as $user):
							$nivel = ($user['nivel'] == '1' ? 'Admin' : ($user['nivel'] == '2' ? 'Editor' : ($user['nivel'] == '3' ? 'Premium' : 'Leitor')));
							echo '<tr>';
								echo '<td align="center"><div class="profile-img"><img width="80" height="80" src="../uploads/avatars/'.$user['avatar'].'"></img></div></td>';
								echo '<td>'.$user['nome'].'</td>';
								echo '<td>'.$user['email'].'</td>';
								echo '<td>'.$nivel.'</td>';
								echo '<td>'.date('d/m/Y H:i',strtotime($user['cadData'])).'</td>';
								echo '<td><a href="index2.php?exe=usuarios/usuarios-edit&userid='.$user['id'].'" title="editar"><img src="ico/edit.png" alt="Editar" title="Editar Usuário" /></a></td>';
								echo '<td><a href="index2.php?exe=usuarios/usuarios&deluser='.$user['id'].'" title="Excluir"><img src="ico/no.png" alt="Excluir" title="Excluir" /></a></td>';
							echo '</tr>';
							endforeach;
							echo '</tbody>';
							echo '</table>';
							$link = 'index2.php?exe=usuarios/usuarios&pag=';
							readPaginator('up_users',"WHERE id != '$userId' {$_SESSION[where]} ORDER BY nivel ASC, nome ASC",$maximo, $link, $pag);
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