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
				<h1>Novo Parceiro</h1>
				<h2>Cadastrar novo parceiro</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=parceiros/parceiros" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
		<?php
		if(isset($_POST['sendForm'])){
			$f['nome'] 			= strip_tags(trim(mysql_real_escape_string($_POST['nome'])));
			$f['descricao'] 	= strip_tags(trim(mysql_real_escape_string($_POST['descricao'])));
			$f['link'] 			= strip_tags(trim(mysql_real_escape_string($_POST['link'])));
			$f['date'] 			= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
			$f['data'] 			= formDate($f['date']); 
			unset($f['date']);
			
			if(in_array('',$f)){
				echo '<div class="red">
						<p>Você deixou algum campo em branco, por favor informe todos os campos!</p>
					</div>';
			}
			else{
				
					if(!empty($_FILES['thumb']['tmp_name'])){
						$imagem = $_FILES['thumb'];
						$pasta	= '../uploads/parceiros/';
						
						$tmp	= $imagem['tmp_name'];
						$ext 	= substr($imagem['name'],-3);
						$nome	= md5(time()).'.'.$ext;	
						$f['thumb'] = $nome;				
						uploadImage($tmp, $nome, '241', $pasta);
					}


					//Auditoria
					$a['usuario']	= $_SESSION['autUser']['nome'];
					$a['acao'] 		= 'Criou o parceiro '.$f['nome'];
					$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
					$a['data'] 		= formDate($a['date']); 
					unset($a['date']);
					create('up_auditoria',$a);
					//Fim Auditoria

					create('up_parceiros',$f);
					
					$idlast = mysql_insert_id();
					$_SESSION['cadastro'] = '<div class="green">
						<p>Parceiro cadastrado com sucesso.</p>
					</div>';
					header('Location: index2.php?exe=parceiros/parceiros-edit&editid='.$idlast);
				}
			
		}
	?>

		<div class="content">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<div class="field-wrap">
					<input type="text" name="nome" value="<?php if(isset($f['nome'])) echo $f['nome'];?>" placeholder="Nome" />
				</div>

				<div class="field-wrap">
					<input type="text" name="link" value="<?php if(isset($f['link'])) echo $f['link'];?>" placeholder="Link" />
				</div>

				<div class="field-wrap">
					<textarea name="descricao" placeholder="Descrição"></textarea>
				</div>
				
				<div class="field-wrap">
					<input type="text" name="data" value="<?php if(isset($f['date'])) echo $f['date']; else echo date('d/m/Y H:i:s');?>" placeholder="data" />
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