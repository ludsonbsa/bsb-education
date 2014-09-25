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
				<h1>Redes Sociais</h1>
				<h2>Links para Redes Sociais</h2>
			</hgroup>
        	<aside>   		
		        <a href="index2.php" title="voltar"><button class="blue">Voltar</button></a>
			</aside>
		</header>
    
    <?php
		if(isset($_POST['sendForm'])){
			$f['facebook'] 		= $_POST['facebook'];
			$f['twitter'] 		= $_POST['twitter'];
			$f['linkedin'] 		= $_POST['linkedin'];
			$f['google'] 		= $_POST['google'];

			if(in_array('',$f)){
				echo '<div class="red">
						<p>Verifique os campos preenchidos.</p>
					</div>';
			}else{
				echo '<div class="green">
						<p>Dados atualizados com sucesso.</p>
					</div>';
				$update = update('up_social',$f,"id = 1");	
				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Alterou as redes sociais do sistema.';
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria				
			}
			
		}

		$ler = read('up_social');
		foreach($ler as $config);
	?>
    <div class="content">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<div class="field-wrap">
					Facebook:
					<input type="text" name="facebook" value="<?php echo $config['facebook'];?>" placeholder="<?php echo $config['facebook'];?>" />
				</div>
					Twitter:
				<div class="field-wrap">
					<input type="text" name="twitter" value="<?php echo $config['twitter'];?>" placeholder="<?php echo $config['twitter'];?>" />
				</div>
					LinkedIn:
				<div class="field-wrap">
					<input type="text" name="linkedin" value="<?php echo $config['linkedin'];?>" placeholder="<?php echo $config['linkedin'];?>" />
				</div>

					Google+
				<div class="field-wrap">
					<input type="text" name="google" value="<?php echo $config['google'];?>" placeholder="<?php echo $config['google'];?>" />
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