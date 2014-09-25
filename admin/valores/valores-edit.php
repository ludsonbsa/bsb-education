<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<div class="orange">	
				<p>Você não tem permissão para acessar esta página.</p>
			  </div>';
	}else{
		$urledit  = $_GET['editid'];
		$readEdit = read('up_valores',"WHERE id = '$urledit'");
		if(!$readEdit){
			header('Location: index2.php?exe=valores/valores');
		}else
			foreach($readEdit as $postedit);
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>Valores</h1>
				<h2>Editar Valores <strong><?php echo $postedit['titulo'];?></strong></h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=valores/valores" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
<?php
    if(isset($_POST['sendForm'])){
		$f['titulo'] 		= htmlspecialchars(mysql_real_escape_string($_POST['titulo']));
		$f['descricao'] 	= htmlspecialchars(mysql_real_escape_string($_POST['descricao']));
		$f['date'] 			= htmlspecialchars(mysql_real_escape_string($_POST['data']));
		$f['link'] 			= htmlspecialchars(mysql_real_escape_string($_POST['link']));
		
		if(in_array('',$f)){
			echo '<div class="orange">	
						<p>Preencha todos os campos.</p>
					  </div>';
		}else{
			$f['data'] = formDate($f['date']); unset($f['date']);
			
				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Editou a página '.$f['titulo'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim auditoria
			

			update('up_valores',$f,"id = '$urledit'");
				

			$_SESSION['return']  = '
										<div class="green">
											<p>Página atualizada com sucesso.
										</div>
									';
			
			header('Location: index2.php?exe=valores/valores-edit&editid='.$urledit);
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
				<input type="text" name="data" value="<?php if(isset($postedit['data'])) echo date('d/m/Y H:i:s', strtotime($postedit['data'])); else echo date('d/m/Y H:i:s');?>" class="formDate" placeholder="Data" />
			</div>

			<div class="field-wrap">
				<input type="text" name="link" value="<?php if(isset($postedit['link'])) echo $postedit['link']; ?>" />
			</div>

			<div class="field-wrap">
				<textarea name="descricao" rows="15"><?php echo $postedit['descricao'];?>
				</textarea>
			</div>

		
			<div style="margin-top:20px;">
				<button type="submit" name="sendForm" class="green">Atualizar Valores</button> 
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