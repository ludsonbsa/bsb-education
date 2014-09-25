<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'2')){
		header('Location: index2.php');
	}else{
		
?>
<section class="content">
	<section class="widget">
		<header>
			<span class="icon">&#128100;</span>
			<hgroup>
				<h1>Professores</h1>
				<h2>Descrição</h2>
			</hgroup>
        	<aside>   		
		        <a href="index2.php" title="voltar"><button class="blue">Voltar</button></a>
			</aside>
		</header>
    
    <?php
		if(isset($_POST['sendForm'])){
			$f['titulo'] 		= $_POST['titulo'];
			$f['descricao'] 	= $_POST['descricao'];

			if(in_array('',$f)){
				echo '<div class="red">
						<p>Verifique os campos preenchidos.</p>
					</div>';
			}else{
				echo '<div class="green">
						<p>Dados atualizados com sucesso.</p>
					</div>';
				$update = update('up_profdesc',$f,"id = 1");	
				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Alterou a descrição de professores.';
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria				
			}
			
		}

		$ler = read('up_profdesc');
		foreach($ler as $config);
	?>
    <div class="content">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<div class="field-wrap">
					Título:
					<input type="text" name="titulo" value="<?php echo $config['titulo'];?>" placeholder="<?php echo $config['titulo'];?>" />
				</div>
					Descrição:
				<div class="field-wrap">
					<input type="text" name="descricao" value="<?php echo $config['descricao'];?>" placeholder="<?php echo $config['descricao'];?>" />
				</div>
				
				<button type="submit" name="sendForm" class="green">Atualizar</button> 
			</form>
		</div>
	</section>
        
		</div>
	</section> 
</section> 
<?php
	}
}else{
	header('Location: ../index2.php');
}
?>