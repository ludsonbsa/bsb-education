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
				<h1>Páginas</h1>
				<h2>Criar nova página</h2>
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
			echo '
					<div class="red">	
						<p>Por favor preencha todos os campos.</p>
						
					</div>
					';
		}else{
			$f['data'] = formDate($f['date']); unset($f['date']);
			$f['url']  = setUri($f['titulo']);
			$readPostUri = read('up_posts',"WHERE url LIKE '%$f[url]%'");
			if($readPostUri){
				$f['url']  = $f['url'].'-'.count($readPostUri);
				$readPostUri = read('up_posts',"WHERE url = '$f[url]'");
				if($readPostUri){
					$f['url']  = $f['url'].'_'.time();
				}
			}
			//Auditoria
			$a['usuario']	= $_SESSION['autUser']['nome'];
			$a['acao'] 		= 'Criou uma página chamada '.$f['titulo'];
			$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
			$a['data'] 		= formDate($a['date']); 
			unset($a['date']);
			create('up_auditoria',$a);
			//Fim Auditoria
			create('up_posts',$f);
			
			$idlast = mysql_insert_id();
			$_SESSION['cadastro'] = '
										<div class="green">	
											<p>Página cadastrada com sucesso. Para visualizar <a href="'.BASE.'/sessao/'.$f['url'].'" target="_blank" title="Ver página">aqui</a>! Ou continuar para atualiza-la.</p>
											
										</div>
									';
			header('Location: index2.php?exe=paginas/paginas-edit&editid='.$idlast);
		}
	}
	?>

		<div class="content">

			<div class="field-wrap">
			<form name="formulario" action="" method="post" enctype="multipart/form-data">
				<input type="text" name="titulo" value="<?php if(isset($f['titulo'])) echo $f['titulo'];?>" placeholder="Título da Página" />
			</div>

			<div class="field-wrap">
				<input type="text" name="subtitulo" value="<?php if(isset($f['subtitulo'])) echo $f['subtitulo'];?>" placeholder="Sub-título da Página" />
			</div>

			<div class="field-wrap">
				<input type="text" name="data" value="<?php if(isset($f['date'])) echo $f['date']; else echo date('d/m/Y H:i:s');?>" class="formDate" placeholder="Data" />
			</div>
			<div class="field-wrap">
				<input type="text" name="tags" placeholder="Tags" value="<?php if(isset($f['tags'])) echo $f['tags'];?>" />
			</div>

			<textarea name="content" class="editor" rows="15"><?php if(isset($f['content'])) echo htmlspecialchars($f['content']);?>
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