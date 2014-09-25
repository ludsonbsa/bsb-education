<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<div class="orange">	
				<p>Você não tem permissão para acessar esta página.</p>
			  </div>';
	}else{
		$urledit  = $_GET['editid'];
		$readEdit = read('up_depoimento',"WHERE id = '$urledit'");
		if(!$readEdit){
			header('Location: index2.php?exe=depoimentos/depoimentos');
		}else
			foreach($readEdit as $postedit);
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>Depoimentos</h1>
				<h2>Editar depoimento <strong><?php echo $postedit['nome'];?></strong></h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=depoimentos/depoimentos" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
<?php
    if(isset($_POST['sendForm'])){
		$f['nome'] 		= htmlspecialchars(mysql_real_escape_string($_POST['nome']));
		$f['depoimento'] 	= htmlspecialchars(mysql_real_escape_string($_POST['depoimento']));
		$f['date'] 			= htmlspecialchars(mysql_real_escape_string($_POST['data']));
		
		
		if(in_array('',$f)){
			echo '<div class="orange">	
						<p>Preencha todos os campos.</p>
					  </div>';
		}else{
			$f['data'] = formDate($f['date']); unset($f['date']);


				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Editou o depoimento '.$f['nome'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim auditoria
			

			update('up_depoimento',$f,"id = '$urledit'");
				

			$_SESSION['return']  = '
									<div class="green">
										<p>Página atualizada com sucesso.
									</div>
								';
			
			header('Location: index2.php?exe=depoimentos/depoimentos-edit&editid='.$urledit);
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
			
				<input type="text" name="nome" value="<?php echo $postedit['nome'];?>" />
			</div>

			<div class="field-wrap">
				<input type="text" name="data" value="<?php if(isset($postedit['data'])) echo date('d/m/Y H:i:s', strtotime($postedit['data'])); else echo date('d/m/Y H:i:s');?>" class="formDate" placeholder="Data" />
			</div>


			<div class="field-wrap">
				<textarea name="depoimento" rows="15"><?php echo $postedit['depoimento'];?>
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