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
				<h1>Novo Curso</h1>
				<h2>Cadastrar novo curso</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=cursos/cursos" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
		<?php
		if(isset($_POST['sendForm'])){
			$f['titulo'] 			= strip_tags(trim(mysql_real_escape_string($_POST['titulo'])));
			$f['descricao'] 	    = strip_tags(trim(mysql_real_escape_string($_POST['descricao'])));

			if(in_array('',$f)){
				echo '<div class="red">
						<p>Você deixou algum campo em branco, por favor informe todos os campos!</p>
					</div>';
			}
			else{
				
					if(!empty($_FILES['thumb']['tmp_name'])){
						$imagem = $_FILES['thumb'];
						$pasta	= '../uploads/cursos/';
						$tmp	= $imagem['tmp_name'];
						$ext 	= substr($imagem['name'],-3);
						$nome	= md5(time()).'.'.$ext;	
						$f['thumb'] = $nome;				
						uploadImage($tmp, $nome, '451', $pasta);
					}


					//Auditoria
					$a['usuario']	= $_SESSION['autUser']['nome'];
					$a['acao'] 		= 'Criou o curso '.$f['titulo'];
					$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
					$a['data'] 		= formDate($a['date']); 
					unset($a['date']);
					create('up_auditoria',$a);
					//Fim Auditoria

					create('up_cursos',$f);
					
					$idlast = mysql_insert_id();
					$_SESSION['cadastro'] = '<div class="green">
						<p>Curso cadastrado com sucesso.</p>
					</div>';
					header('Location: index2.php?exe=cursos/cursos-edit&editid='.$idlast);
				}
			
		}
	?>

		<div class="content">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<div class="field-wrap">
					<input type="text" name="titulo" value="<?php if(isset($f['titulo'])) echo $f['titulo'];?>" />
				</div>

				<div class="field-wrap">
					<textarea name="descricao"><?php if(isset($f['descricao'])) echo $f['descricao'];?></textarea>
				</div>
				
				<div class="field-wrap">
					<input type="file" class="fileinput" name="thumb" size="60" style="cursor:pointer; background:#FFF;" />
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