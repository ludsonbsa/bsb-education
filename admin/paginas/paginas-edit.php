<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<div class="orange">	
				<p>Você não tem permissão para acessar esta página.</p>
			  </div>';
	}else{
		$urledit  = $_GET['editid'];
		$readEdit = read('up_posts',"WHERE id = '$urledit'");
		if(!$readEdit){
			header('Location: index2.php?exe=posts/post');
		}else
			foreach($readEdit as $postedit);
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>Páginas</h1>
				<h2>Editar Página <strong><?php echo $postedit['titulo'];?></strong></h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=paginas/paginas" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
<?php
    if(isset($_POST['sendForm'])){
		$f['titulo'] 		= htmlspecialchars(mysql_real_escape_string($_POST['titulo']));
		$f['subtitulo'] 	= htmlspecialchars(mysql_real_escape_string($_POST['subtitulo']));
		$f['tags'] 			= htmlspecialchars(mysql_real_escape_string($_POST['tags']));
		$f['content'] 		= mysql_real_escape_string($_POST['content']);
		$f['date'] 			= htmlspecialchars(mysql_real_escape_string($_POST['data']));
		$f['categoria'] 	= '0';
		$f['cat_pai'] 		= '0';
		$f['nivel'] 		= '0';
		$f['status']		= '1';
		$f['autor']			= $_SESSION['autUser']['id'];
		$f['tipo']			= 'pagina';
		
		if(in_array('',$f)){
			echo '<div class="orange">	
						<p>Preencha todos os campos.</p>
					  </div>';
		}else{
			$f['data'] = formDate($f['date']); unset($f['date']);
			if($postedit['titulo'] != $f['titulo']){
				$f['url']  = setUri($f['titulo']);
				$readPostUri = read('up_posts',"WHERE url LIKE '%$f[url]%' AND id != '$urledit'");
				if($readPostUri){
					$f['url']  = $f['url'].'-'.count($readPostUri);
					$readPostUri = read('up_posts',"WHERE url = '$f[url]' AND id != '$urledit'");
					if($readPostUri){
						$f['url']  = $f['url'].'_'.time();
					}
				}
			}else{
				$f['url']  = $postedit['url'];
			}
				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Editou a página '.$f['titulo'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim auditoria
			

			update('up_posts',$f,"id = '$urledit'");
				

			$_SESSION['return']  = '
										<div class="green">
											<p>Página atualizada com sucesso. Para visualizar clique <a href="'.BASE.'/sessao/'.$f['url'].'" target="_blank" title="Ver página">aqui</a>!</span>
										</div>
									';
			
			header('Location: index2.php?exe=paginas/paginas-edit&editid='.$urledit);
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

			<div class="field-wrap">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<input type="text" name="titulo" value="<?php echo $postedit['titulo'];?>" placeholder="Título da Página" />
			</div>

			<div class="field-wrap">
				<input type="text" name="subtitulo" value="<?php echo $postedit['subtitulo'];?>" placeholder="Sub-Título da Página" />
			</div>

			<div class="field-wrap">
				<input type="text" name="data" value="<?php if(isset($postedit['data'])) echo date('d/m/Y H:i:s', strtotime($postedit['data'])); else echo date('d/m/Y H:i:s');?>" class="formDate" placeholder="Data" />
			</div>
			<div class="field-wrap">
				<input type="text" name="tags" placeholder="Tags" value="<?php echo $postedit['tags'];?>" />
			</div>

			<textarea name="content" class="editor" rows="15"><?php echo htmlspecialchars($postedit['content']);?>
			</textarea>
		
			<div style="margin-top:20px;">
				<button type="submit" name="sendForm" class="green">Atualizar Página</button> 
				<a href="<?php echo BASE.'/sessao/'.$postedit['url'];?>" class="button" style="color:#fff" target="_blank">Visualizar</a>
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