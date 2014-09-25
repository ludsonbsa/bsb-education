<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<section class="alert>
			<div class="orange">
				<p>Desculpe, você não tem permissão para acessar esta página.</p>
			</div>
		  	</section>';
	}else{
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#59136;</span>
			<hgroup>
				<h1>Novo Usuário</h1>
				<h2>Cadastrar novo usuário</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=usuarios/usuarios" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
		<?php
		if(isset($_POST['sendForm'])){
			$f['nome'] 		= strip_tags(trim(mysql_real_escape_string($_POST['nome'])));
			$f['email'] 	= strip_tags(trim(mysql_real_escape_string($_POST['email'])));
			$f['code'] 		= strip_tags(trim(mysql_real_escape_string($_POST['senha'])));
			$f['senha']		= md5($f['code']);
			$f['nivel'] 	= strip_tags(trim(mysql_real_escape_string($_POST['nivel'])));
			$f['statusS'] 	= strip_tags(trim(mysql_real_escape_string($_POST['status'])));
			$f['status']	= ($f['statusS'] == '1' ? $f['statusS'] : '0');
			
			if(in_array('',$f)){
				echo '<div class="red">
						<p>Você deixou algum campo em branco, por favor informe todos os campos!</p>
					</div>';
			}
			elseif(!valMail($f['email'])){
				echo '<div class="red">
						<p>E-mail informado não tem um formato válido!</p>
					</div>';
			}
			elseif(strlen($f['code']) < 6 || strlen($f['code']) > 12){
				echo '
					<div class="red">
						<p>Senha deve conter entre 6 e 12 caracteres!</p>
					</div>';
			}else{
				$readUserMail = read('up_users',"WHERE email = '$f[email]'");
				if($readUserMail){
					echo '<div class="red">
						<p>Você não pode cadastrar 2 usuários com o mesmo e-mail.</p>
					</div>';
				}else{
					if(!empty($_FILES['avatar']['tmp_name'])){
						$imagem = $_FILES['avatar'];
						$pasta	= '../uploads/avatars/';
						$tmp	= $imagem['tmp_name'];
						$ext 	= substr($imagem['name'],-3);
						$nome	= md5(time()).'.'.$ext;	
						$f['avatar'] = $nome;				
						uploadImage($tmp, $nome, '200', $pasta);
					}
					unset($f['statusS']);


					//Auditoria
					$a['usuario']	= $_SESSION['autUser']['nome'];
					$a['acao'] 		= 'Criou o usuário '.$f['nome'];
					$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
					$a['data'] 		= formDate($a['date']); 
					unset($a['date']);
					create('up_auditoria',$a);
					//Fim Auditoria

					create('up_users',$f);
					$idlast = mysql_insert_id();
					$_SESSION['cadastro'] = '<div class="green">
						<p>Usuário cadastrado com sucesso.</p>
					</div>';
					header('Location: index2.php?exe=usuarios/usuarios-edit&userid='.$idlast);
				}
			}
		}
	?>

		<div class="content">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<div class="field-wrap">
					<input type="text" name="nome" value="<?php if(isset($f['nome'])) echo $f['nome'];?>" placeholder="Nome" />
				</div>
				<div class="field-wrap">
					<input type="text" name="email" value="<?php if(isset($f['email'])) echo $f['email'];?>" placeholder="E-mail" />
				</div>
				<div class="field-wrap">
					<input type="password" name="senha" value="<?php if(isset($f['senha'])) echo $f['senha'];?>" placeholder="Senha" />
				</div>
				<div class="field-wrap">
					<input type="file" class="fileinput" name="avatar" size="60" style="cursor:pointer; background:#FFF;" />
				</div>

				<div class="field-wrap">
					<select name="nivel">
		                <option value="">Selecione o nível deste usuário &nbsp;&nbsp;</option>
		                <option <?php if(isset($f['nivel']) && $f['nivel'] == '2') echo 'selected="selected"';?>  value="2">Editor &nbsp;&nbsp;</option>
		                <option <?php if(isset($f['nivel']) && $f['nivel'] == '1') echo 'selected="selected"';?>  value="1">Administrador &nbsp;&nbsp;</option>
		            </select>

		        <div class="field-wrap">
		        <select name="status">
	                <option value="">Selecione o status &nbsp;&nbsp;</option>
	                <option <?php if(isset($f['statusS']) && $f['statusS'] == '1') echo 'selected="selected"';?> value="1">Ativo &nbsp;&nbsp;</option>
	                <option <?php if(isset($f['statusS']) && $f['statusS'] == '-1') echo 'selected="selected"';?> value="0">Inativo &nbsp;&nbsp;</option>
            	</select>
		        </div>
				<button type="submit" name="sendForm" class="green">Cadastrar</button> <button type="reset" class="">Limpar</button>
			</form>
		</div>
	</section>

		</section>
<?php
	}
}else{
	header('Location: ../index2.php');
}
?>