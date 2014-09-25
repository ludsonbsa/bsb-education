<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<div class="orange">	
				<p>Você não tem permissão para acessar esta página.</p>
			  </div>';
	}else{
		$urledit  = $_GET['editid'];
		$readEdit = read('up_slides',"WHERE id = '$urledit'");
		if(!$readEdit){
			header('Location: index2.php?exe=home/slides');
		}else
			foreach($readEdit as $postedit);
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>Slides</h1>
				<h2>Editar Slides <strong><?php echo $postedit['titulo'];?></strong></h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=home/slides" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
<?php
    if(isset($_POST['sendForm'])){
			$f['titulo'] 	= strip_tags(trim(mysql_real_escape_string($_POST['titulo'])));
			$f['descricao'] = strip_tags(trim(mysql_real_escape_string($_POST['descricao'])));
			$f['link']	 	= strip_tags(trim(mysql_real_escape_string($_POST['link'])));
			$f['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
			$f['data'] 		= formDate($f['date']); 
		
		if(in_array('',$f)){
			echo '<div class="orange">	
						<p>Preencha todos os campos.</p>
					  </div>';
		}else{
			$f['data'] = formDate($f['date']); unset($f['date']);
			if(!empty($_FILES['thumb']['tmp_name'])){
				$pasta 	= '../uploads/slides/';
				$ano 	= date('Y');
				$mes 	= date('m');
				if(file_exists($pasta.$postedit['thumb']) && !is_dir($pasta.$postedit['thumb'])){
					unlink($pasta.$postedit['thumb']);
				}
				
				if(!file_exists($pasta.$ano)){
					mkdir($pasta.$ano,0755);
				}
				if(!file_exists($pasta.$ano.'/'.$mes)){
					mkdir($pasta.$ano.'/'.$mes,0755);
				}
				
				$img = $_FILES['thumb'];
				$ext = substr($img['name'],-3);
				$f['thumb'] = $ano.'/'.$mes.'/'.$f['titulos'].'.'.$ext;
				uploadImage($img['tmp_name'], $f['titulos'].'.'.$ext, '1100', $pasta.$ano.'/'.$mes.'/');
			}


				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Editou o slide '.$f['titulo'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim auditoria
			

			update('up_slides',$f,"id = '$urledit'");
				

			$_SESSION['return']  = '
									<div class="green">
										<p>Página atualizada com sucesso.
									</div>
								';
			
			header('Location: index2.php?exe=home/slides-edit&editid='.$urledit);
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
				<?php echo '<img src="../uploads/slides/'.$postedit['thumb'].'" width="55" style="border:1px solid #e1e1e1; margin:10px 0;"></img>'; ?>
	            <br>*Tamanho de imagem recomendado: 1920x610<br>
	            <br><span class="data">Foto de exibição:</span>
	            <input type="file" class="fileinput" name="thumb" size="60" style="cursor:pointer; background:#FFF;" />
	        </div>

			<div class="field-wrap">
				<input type="text" name="titulo" value="<?php echo $postedit['titulo'];?>" />
			</div>

			<div class="field-wrap">
				<input type="text" name="descricao" value="<?php echo $postedit['descricao'];?>" />
			</div>
			<?php 
			switch($postedit['link']){
				case '#about':
					$nome = 'Sobre';
					break;
				case '#services':
					$nome = 'Cursos';
					break;
				case '#team':
					$nome = 'Professores';
					break;
				case '#testemonials':
					$nome = 'Depoimentos';
					break;
				case '#contact':
					$nome = 'Contato';
					break;			
			}
			?>
			<div class="field-wrap">
				<div class="field-wrap">
					Direcionar link para:
					<select name="link">
						<option value="<?php echo $postedit['link']?>"><?php echo $nome;?></option>
						<option value="">----------</option>
						<option value="#about">Sobre</option>
						<option value="#services">Cursos</option>
						<option value="#team">Professores</option>
						<option value="#testemonials">Depoimentos</option>
						<option value="#contact">Contato</option>
					</select>
				</div>
			</div>
				
			<div class="field-wrap">

				<input type="text" name="data" value="<?php if(isset($postedit['data'])) echo date('d/m/Y H:i:s', strtotime($postedit['data'])); else echo date('d/m/Y H:i:s');?>" class="formDate" placeholder="Data" />
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