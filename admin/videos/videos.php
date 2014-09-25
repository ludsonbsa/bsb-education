<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'2')){
		header('Location: index2.php');
	}else{
		
?>
<section class="content">
	<section class="widget">
		<header>
			<span class="icon">&#128187;</span>
			<hgroup>
				<h1>Video</h1>
				<h2>Institucional footer</h2>
			</hgroup>
        	<aside>   		
		        <a href="index2.php" title="voltar"><button class="blue">Voltar</button></a>
			</aside>
		</header>
    
    <?php
		if(isset($_POST['sendForm'])){
			$f['nome'] 			= $_POST['nome'];
			$f['descricao'] 	= htmlspecialchars(mysql_real_escape_string($_POST['descricao']));
			$muda 				= $_POST['link'];
			$video				= str_replace("www.youtube.com/watch?v=","www.youtube.com/embed/", $muda);
			$f['link'] 			= $video; 
			


			if(in_array('',$f)){
				echo '<div class="red">
						<p>Verifique os campos preenchidos.</p>
					</div>';
			}else{
				echo '<div class="green">
						<p>Dados atualizados com sucesso.</p>
					</div>';
				$update = update('up_videos',$f,"id = 1");	
				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Alterou o vídeo do sistema.';
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria				
			}
			
		}

		$ler = read('up_videos');
		foreach($ler as $config);
	?>
    <div class="content">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<div class="field-wrap">
					<input type="text" name="nome" value="<?php echo $config['nome'];?>" placeholder="<?php echo $config['nome'];?>" />
				</div>
				<div class="field-wrap">
					<input type="text" name="link" value="<?php echo $config['link'];?>" placeholder="<?php echo $config['link'];?>" />
				</div>	
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