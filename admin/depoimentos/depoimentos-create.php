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
				<h1>Novo Depoimento</h1>
				<h2>Cadastrar novo depoimento</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=depoimentos/depoimentos" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
		<?php
		if(isset($_POST['sendForm'])){
			$f['nome'] 		= strip_tags(trim(mysql_real_escape_string($_POST['nome'])));
			$f['depoimento'] 	= strip_tags(trim(mysql_real_escape_string($_POST['depoimento'])));
			$f['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
			$f['data'] 		= formDate($f['date']); 
			unset($f['date']);
			
			if(in_array('',$f)){
				echo '<div class="red">
						<p>Você deixou algum campo em branco, por favor informe todos os campos!</p>
					</div>';
			}
			else{
				

					//Auditoria
					$a['usuario']	= $_SESSION['autUser']['nome'];
					$a['acao'] 		= 'Criou o depoimento de'.$f['nome'];
					$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
					$a['data'] 		= formDate($a['date']); 
					unset($a['date']);
					create('up_auditoria',$a);
					//Fim Auditoria

					create('up_depoimento',$f);
					
					$idlast = mysql_insert_id();
					$_SESSION['cadastro'] = '<div class="green">
						<p>Depoimento cadastrado com sucesso.</p>
					</div>';
					header('Location: index2.php?exe=depoimentos/depoimentos-edit&depid='.$idlast);
				}
			
		}
	?>

		<div class="content">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<div class="field-wrap">
					<input type="text" name="nome" value="<?php if(isset($f['nome'])) echo $f['nome'];?>" placeholder="Nome" />
				</div>

				<div class="field-wrap">
					<textarea name="depoimento" placeholder="Depoimento"></textarea>
				</div>
				
				<div class="field-wrap">
					<input type="text" name="data" value="<?php if(isset($f['date'])) echo $f['date']; else echo date('d/m/Y H:i:s');?>" placeholder="data" />
				</div>

				<button type="submit" name="sendForm" class="green">Cadastrar</button> <button type="reset" class="">Limpar</button>
			</form>
		</div>
	</section>
<?php
	}
}else{
	header('Location: ../index2.php');
}
?>