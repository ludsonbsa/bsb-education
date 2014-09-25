<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<div class="orange">	
				<p>Você não tem permissão para acessar esta página.</p>
			  </div>';
	}else{

		$readEdit = read('up_sobre');
		if(!$readEdit){
			header('Location: index2.php?exe=sobre/sobre-edit');
		}else
			foreach($readEdit as $postedit);
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>Sobre</h1>
				<h2>Editar Sobre <strong><?php echo $postedit['titulo'];?></strong></h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=sobre/sobre-edit" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
<?php
    if(isset($_POST['sendForm'])){
		$f['titulo'] 		= htmlspecialchars(mysql_real_escape_string($_POST['titulo']));
		$f['descricao'] 	= htmlspecialchars(mysql_real_escape_string($_POST['descricao']));
		$f['content'] 		= mysql_real_escape_string($_POST['content']);
		
		
		
		if(in_array('',$f)){
			echo '<div class="orange">	
						<p>Preencha todos os campos.</p>
					  </div>';
		}else{

			update('up_sobre',$f,"id = '1'");
				

			$_SESSION['return']  = '
									<div class="green">
										<p>Página atualizada com sucesso.
									</div>
									';
			
			header('Location: index2.php?exe=sobre/sobre-edit');
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

			<div class="field-wrap">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<input type="text" name="titulo" value="<?php echo $postedit['titulo'];?>" />
			</div>

			<div class="field-wrap">
				<input type="text" name="descricao" value="<?php echo $postedit['descricao'];?>" />
			</div>

			<textarea name="content" class="editor" rows="15"><?php echo htmlspecialchars($postedit['content']);?>
			</textarea>
		
			<div style="margin-top:20px;">
				<button type="submit" name="sendForm" class="green">Atualizar Sessão</button> 
			</div>
		</div>
		</form>

	</section>  
	</section>   
<?php
	}
}else{
	header('Location: ../index2.php');
}
?>