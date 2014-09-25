<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<section class="alert">
				<div class="orange">	
					<p>Você não tem permissão para acessar esta página.</p>			
				</div>
			</section>';
	}else{
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#59185;</span>
			<hgroup>
				<h1>Valores</h1>
				<h2>Criar novo valor</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=valores/valores" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
<?php
    if(isset($_POST['sendForm'])){
		$f['titulo'] 		= htmlspecialchars(mysql_real_escape_string($_POST['titulo']));
		$f['descricao'] 	= htmlspecialchars(mysql_real_escape_string($_POST['descricao']));
		$f['link'] 			= htmlspecialchars(mysql_real_escape_string($_POST['link']));
		$f['date'] 			= htmlspecialchars(mysql_real_escape_string($_POST['data']));
		
		if(in_array('',$f)){
			echo '
					<div class="red">	
						<p>Por favor preencha todos os campos.</p>		
					</div>
					';
		}else{
			$f['data'] = formDate($f['date']); unset($f['date']);
			
			//Auditoria
			$a['usuario']	= $_SESSION['autUser']['nome'];
			$a['acao'] 		= 'Criou uma página chamada '.$f['titulo'];
			$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
			$a['data'] 		= formDate($a['date']); 
			unset($a['date']);
			create('up_auditoria',$a);
			//Fim Auditoria

			create('up_valores',$f);
			
			$idlast = mysql_insert_id();
			$_SESSION['cadastro'] = '
										<div class="green">	
											<p>Valor cadastrado com sucesso.</p>			
										</div>
									';
			header('Location: index2.php?exe=valores/valores-edit&editid='.$idlast);
		}
	}
	?>

		<div class="content">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">

			<div class="field-wrap">
				<input type="text" name="titulo" value="<?php if(isset($f['titulo'])) echo $f['titulo'];?>" placeholder="Titulo" />
			</div>

			<div class="field-wrap">
				<input type="text" name="link" value="<?php if(isset($f['link'])) echo $f['link'];?>" placeholder="Link" />
			</div>

			<div class="field-wrap">
				<input type="text" name="data" value="<?php if(isset($f['date'])) echo $f['date']; else echo date('d/m/Y H:i:s');?>" class="formDate" placeholder="Data" />
			</div>

			<textarea name="descricao" rows="15"><?php if(isset($f['descricao'])) echo htmlspecialchars($f['descricao']);?>
			</textarea>
		
			<div style="margin-top:20px;">
				<button type="submit" name="sendForm" class="green">Publicar</button> <button type="submit" class="">Visualizar</button>
			</div>
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