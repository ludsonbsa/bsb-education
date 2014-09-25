<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'2')){
		header('Location: index2.php');
	}else{
		$userEditId = $_GET['userid'];
		$readEditId = read('up_users',"WHERE id = '$userEditId'");
		if(!$readEditId){
			header('Location: index2.php?exe=usuarios/usuarios');
		}elseif($_SESSION['autUser']['nivel'] != '1'){
			foreach($readEditId as $user);
			if($_SESSION['autUser']['id'] != $user['id']){
				header('Location: index2.php?exe=usuarios/usuarios');
			}
		}else
			foreach($readEditId as $user);
			$status = ($user['status'] == '1' ? $user['status'] : '-1');
?>
<section class="content">
	<section class="widget">
		<header>
			<span class="icon">&#128100;</span>
			<hgroup>
				<h1><?php echo $user['nome'];?></h1>
				<h2>Editar usuário</h2>
			</hgroup>
        	<aside>
        		<?php if($_SESSION['autUser']['nivel'] == '1'){?>
		    	<a href="index2.php?exe=usuarios/usuarios" style="color:#fff"><button class="blue">Voltar</button></a>
		        <?php }else{?>
		        <a href="index2.php" title="voltar"><button class="blue">Voltar</button></a>
		        <?php }?>
			</aside>
		</header>
    
    <?php
		if(isset($_POST['sendForm'])){
			$f['nome'] 		= strip_tags(trim(mysql_real_escape_string($_POST['nome'])));
			$f['email'] 	= strip_tags(trim(mysql_real_escape_string($_POST['email'])));
			$f['email']     = ($f['email'] != '' ? $f['email'] : $user['email']);
			$f['code'] 		= strip_tags(trim(mysql_real_escape_string($_POST['senha'])));
			$f['senha']		= md5($f['code']);
			$f['nivel'] 	= strip_tags(trim(mysql_real_escape_string($_POST['nivel'])));
			$f['nivel']     = ($f['nivel'] != '' ? $f['nivel'] : $user['nivel']);
			$f['statusS'] 	= strip_tags(trim(mysql_real_escape_string($_POST['status'])));
			$f['statusS']   = ($f['statusS'] != '' ? $f['statusS'] : $user['status']);
			$f['status']	= ($f['statusS'] == '1' ? $f['statusS'] : '0');

			if(in_array('',$f)){
				echo '<div class="red">
						<p>Você deixou algum campo em branco, por favor informe todos os campos!</p>
					</div>';
			}
			elseif(!valMail($f['email'])){
				echo '<div class="orange">
						<p>Atenção! E-mail informado não é válido</p>
					</div>';
			}
			elseif(strlen($f['code']) < 6 || strlen($f['code']) > 12){
				echo '<div class="orange">
						<p>Senha deve conter entre 6 e 12 caracteres!</p>
					</div>';
			}else{
				if(!empty($_FILES['avatar']['tmp_name'])){
					$imagem = $_FILES['avatar'];
					$pasta	= '../uploads/avatars/';
					if(file_exists($pasta.$user['avatar']) && !is_dir($pasta.$user['avatar'])){
						unlink($pasta.$user['avatar']);
					}
					$tmp	= $imagem['tmp_name'];
					$ext 	= substr($imagem['name'],-3);
					$nome	= md5(time()).'.'.$ext;	
					$f['avatar'] = $nome;				
					uploadImage($tmp, $nome, '200', $pasta);
				}	
				unset($f['statusS']);

				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Editou o usuário '.$f['nome'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria

				update('up_users',$f,"id = '$userEditId'");
				$_SESSION['return'] = '<div class="green">
											<p>Usuário atualizado com sucesso.</span>
										</div>';
				header('Location: index2.php?exe=usuarios/usuarios-edit&userid='.$userEditId);
			}
		}elseif(!empty($_SESSION['return'])){
			echo $_SESSION['return'];
			unset($_SESSION['return']);
		}
		if(!empty($_SESSION['cadastro'])){
			echo $_SESSION['cadastro'];
			unset($_SESSION['cadastro']);
		}
	?>
    <div class="content">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<div class="field-wrap">
					<input type="text" name="nome" value="<?php echo $user['nome'];?>" placeholder="<?php echo $user['nome'];?>" />
				</div>
				<?php if($_SESSION['autUser']['nivel'] == '1'){?>
				<div class="field-wrap">
					<input type="text" name="email" value="<?php echo $user['email'];?>" placeholder="<?php echo $user['email'];?>" />
				</div>
				<?php }?>
				<div class="field-wrap">
					<input type="password" name="senha" value="<?php echo $user['code'];?>" placeholder="<?php echo $user['code'];?>" />
				</div>
				<?php
						if($user['avatar'] != '' && file_exists('../uploads/avatars/'.$user['avatar'])){
							echo '<a href="../uploads/avatars/'.$user['avatar'].'" title="Ver avatar" rel="ShadowBox">';
							echo '<img src="../tim.php?src=../uploads/avatars/'.$user['avatar'].'&w=50&h=50&zc=1&q=100" title="Avatar do usuário" alt="Avatar do usuario" />';
							echo '</a>';
						}else{
							echo 'Avatar:';
						}
					?>
				<div class="field-wrap">
					<input type="file" class="fileinput" name="avatar" size="60" style="cursor:pointer; background:#FFF;" />
				</div>

				<?php if($_SESSION['autUser']['nivel'] == '1'){?>
				<div class="field-wrap">
					<select name="nivel">
		            	<!--<option <?php if($user['nivel'] && $user['nivel'] == '4') echo 'selected="selected"';?>  value="4">Leitor &nbsp;&nbsp;</option>
		                <option <?php if($user['nivel'] && $user['nivel'] == '3') echo 'selected="selected"';?>  value="3">Premium &nbsp;&nbsp;</option>-->
		                <option <?php if($user['nivel'] && $user['nivel'] == '2') echo 'selected="selected"';?>  value="2">Editor &nbsp;&nbsp;</option>
		                <option <?php if($user['nivel'] && $user['nivel'] == '1') echo 'selected="selected"';?>  value="1">Administrador &nbsp;&nbsp;</option>
		            </select>

		        <div class="field-wrap">
		        <select name="status">
	                <option value="">Selecione o status &nbsp;&nbsp;</option>
	                <option <?php if($status && $status == '1') echo 'selected="selected"';?> value="1">Ativo &nbsp;&nbsp;</option>
	                <option <?php if($status && $status == '-1') echo 'selected="selected"';?> value="-1">Inativo &nbsp;&nbsp;</option>
	            </select>
		        </div>
		        <?php } ?>
				<button type="submit" name="sendForm" class="green">Atualizar</button> <button type="reset" class="">Limpar</button>
			</form>
		</div>
	</section>
 	</section>       
</div><!-- /bloco form -->
<?php
	}
}else{
	header('Location: ../index2.php');
}
?>