<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<div class="orange">	
				<p>Você não tem permissão para acessar esta página.</p>
			  </div>';
	}else{

		$readEdit = read('up_cursodesc');
		if(!$readEdit){
			header('Location: index2.php?exe=cursos/cursos');
		}else
			foreach($readEdit as $postedit);
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>Cursos</h1>
				<h2>Editar descrição curso <strong><?php echo $postedit['titulo'];?></strong></h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=cursos/cursos" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
<?php
    if(isset($_POST['sendForm'])){
			$f['titulo'] 		= strip_tags(trim(mysql_real_escape_string($_POST['titulo'])));
			$f['descricao'] 	= strip_tags(trim(mysql_real_escape_string($_POST['descricao'])));

		if(in_array('',$f)){
			echo '<div class="orange">	
						<p>Preencha todos os campos.</p>
					  </div>';
		}else{

				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Editou descrição de cursos '.$f['titulo'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim auditoria
			

			update('up_cursodesc',$f,"id = '1'");
				 

			$_SESSION['return']  = '
									<div class="green">
										<p>Página atualizada com sucesso.
									</div>
								';
			
			header('Location: index2.php?exe=cursos/cursosdesc');
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
				<input type="text" name="titulo" value="<?php echo $postedit['titulo'];?>" />
			</div>

			<div class="field-wrap">
				<textarea name="descricao" rows="15"><?php echo $postedit['descricao'];?>
				</textarea>
			</div>

		
			<div style="margin-top:20px;">
				<button type="submit" name="sendForm" class="green">Atualizar</button> 
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