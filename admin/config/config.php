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
				<h1>Configurações</h1>
				<h2>Dados internos de sistema</h2>
			</hgroup>
        	<aside>   		
		        <a href="index2.php" title="voltar"><button class="blue">Voltar</button></a>
			</aside>
		</header>
    
    <?php
		if(isset($_POST['sendForm'])){
			$f['telefone'] 		= strip_tags(trim(mysql_real_escape_string($_POST['telefone'])));
			$f['email'] 		= strip_tags(trim(mysql_real_escape_string($_POST['email'])));
                        $f['senha'] 		= strip_tags(trim(mysql_real_escape_string($_POST['senha'])));
                        $f['tags'] 		= strip_tags(trim(mysql_real_escape_string($_POST['tags'])));
                        $f['descricao'] 	= strip_tags(trim(mysql_real_escape_string($_POST['descricao'])));
                        $f['smtp'] 		= strip_tags(trim(mysql_real_escape_string($_POST['smtp'])));
			$f['endereco'] 		= strip_tags(trim(mysql_real_escape_string($_POST['endereco'])));
                        $f['mailport'] 		= strip_tags(trim(mysql_real_escape_string($_POST['mailport'])));
                        $f['online']     	= strip_tags(trim(mysql_real_escape_string($_POST['online'])));

			if(in_array('',$f)){
				echo '<div class="red">
						<p>Verifique os campos de configuração.</p>
					</div>';
			}else{

				echo '<div class="green">
						<p>Configuração atualizada com sucesso.</p>
					</div>';
				$update = update('up_config',$f,"id = 1");	
				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Alterou as configurações do sistema.';
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria				
			}
			
		}

		$ler = read('up_config');
		foreach($ler as $config);
	?>
    <div class="content">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<div class="field-wrap">
                                    <input type="text" name="telefone" value="<?php echo $config['telefone'];?>" placeholder="<?php echo $config['telefone'];?>" />
				</div>
				<div class="field-wrap">
					<input type="text" name="email" value="<?php echo $config['email'];?>" placeholder="<?php echo $config['email'];?>" />
				</div>
                                <div class="field-wrap">
                                    <input type="password" name="senha" value="<?php echo $config['senha'];?>" placeholder="senha" />
				</div>
                            
                                <div class="field-wrap">
                                    <input type="text" name="smtp" value="<?php echo $config['smtp'];?>" placeholder="Endereço SMTP do Servidor" />
				</div>
                            
                                <div class="field-wrap">
                                    <input type="text" name="mailport" value="<?php echo $config['mailport'];?>" placeholder="Porta de E-mail(Padrão 587)" />
				</div>
                            
                                <div class="field-wrap">
                                    <input type="text" name="descricao" value="<?php echo $config['descricao'];?>" placeholder="Descrição do site" />
				</div>
                            
                                <div class="field-wrap">
                                    <input type="text" name="tags" value="<?php echo $config['tags'];?>" placeholder="Keywords" />
				</div>

				<div class="field-wrap">
					<input type="text" name="endereco" value="<?php echo $config['endereco'];?>" placeholder="<?php echo $config['endereco'];?>" />
				</div>

				<div class="field-wrap">
					<?php if($config['online'] == 1){?>
					<p>O sistema está <strong>On-line</strong>, deseja coloca-lo me manutenção?</p>
					<input type="radio" name="online" value="0" width="30"  />Sim
					<input type="radio" name="online" value="1" width="30" checked="checked" />Não
					<?php }else{?>
					<p>O sistema está <strong>em manutenção</strong>, deseja coloca-lo On-line?</p>
					<input type="radio" name="online" value="1" width="30"  />Sim
					<input type="radio" name="online" value="0" width="30" checked="checked" />Não
					<?php }?>
				</div>
				<hr style="margin:20px 0;">
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