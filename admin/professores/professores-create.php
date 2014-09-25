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
				<h1>Novo Professor</h1>
				<h2>Cadastrar novo professor</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=professores/professores" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
		<?php
		if(isset($_POST['sendForm'])){
			$f['nome'] 		    	= strip_tags(trim(mysql_real_escape_string($_POST['nome'])));
			$f['funcao']    	    = strip_tags(trim(mysql_real_escape_string($_POST['funcao'])));
            $f['descricao'] 	    = strip_tags(trim(mysql_real_escape_string($_POST['descricao'])));
            $f['tecnica_um']    	= strip_tags(trim(mysql_real_escape_string($_POST['tecnica_um'])));
            $f['tecnica_dois']      = strip_tags(trim(mysql_real_escape_string($_POST['tecnica_dois'])));
            $f['tecnica_tres']    	= strip_tags(trim(mysql_real_escape_string($_POST['tecnica_tres'])));
            $f['pos_desc']    	    = strip_tags(trim(mysql_real_escape_string($_POST['pos_desc'])));


			if(in_array('',$f)){
				echo '<div class="red">
						<p>Você deixou algum campo em branco, por favor informe todos os campos!</p>
					</div>';
			}
			else{
				
					if(!empty($_FILES['thumb']['tmp_name'])){
						$imagem = $_FILES['thumb'];
						$pasta	= '../uploads/professores/';
						$tmp	= $imagem['tmp_name'];
						$ext 	= substr($imagem['name'],-3);
						$nome	= md5(time()).'.'.$ext;	
						$f['thumb'] = $nome;				
						uploadImage($tmp, $nome, '651', $pasta);
					}


					//Auditoria
					$a['usuario']	= $_SESSION['autUser']['nome'];
					$a['acao'] 		= 'Criou o professor '.$f['titulo'];
					$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
					$a['data'] 		= formDate($a['date']); 
					unset($a['date']);
					create('up_auditoria',$a);
					//Fim Auditoria

					create('up_professores',$f);
					
					$idlast = mysql_insert_id();
					$_SESSION['cadastro'] = '<div class="green">
						<p>Curso cadastrado com sucesso.</p>
					</div>';
					header('Location: index2.php?exe=professores/professores-edit&editid='.$idlast);
				}
			
		}
	?>

		<div class="content">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<div class="field-wrap">
					<input type="text" name="nome" value="<?php if(isset($f['nome'])) echo $f['nome'];?>" placeholder="Nome" />
				</div>

                <div class="field-wrap">
                    <input type="text" name="funcao" value="<?php if(isset($f['funcao'])) echo $f['funcao'];?>" placeholder="Função" />
                </div>

				<div class="field-wrap">
					<textarea name="descricao" placeholder="Descrição"><?php if(isset($f['descricao'])) echo $f['descricao'];?></textarea>
				</div>

                <div class="field-wrap">
                    <input type="text" name="tecnica_um" value="<?php if(isset($f['tecnica_um'])) echo $f['tecnica_um'];?>" placeholder="Técnica 1 em %" />
                </div>

                <div class="field-wrap">
                    <input type="text" name="tecnica_dois" value="<?php if(isset($f['tecnica_dois'])) echo $f['tecnica_dois'];?>" placeholder="Técnica 2 em %" />
                </div>

                <div class="field-wrap">
                    <input type="text" name="tecnica_tres" value="<?php if(isset($f['tecnica_tres'])) echo $f['tecnica_tres'];?>" placeholder="Técnica 3 em %" />
                </div>

                <div class="field-wrap">
                    <textarea name="pos_desc" placeholder="Pós-Descrição"><?php if(isset($f['pos_desc'])) echo $f['pos_desc'];?></textarea>
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