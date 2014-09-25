<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'2')){
		header('Location: index2.php');
	}else{
		$urledit  = $_GET['editid'];
		$readEdit = read('up_posts',"WHERE id = '$urledit'");
		if(!$readEdit){
			header('Location: index2.php?exe=posts/posts');
		}else
			foreach($readEdit as $postedit);
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#9998;</span>
			<hgroup>
				<h1><?php echo $postedit['titulo'];?></h1>
				<h2>Editar artigo</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=posts/posts" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>      
    <?php
    if(isset($_POST['sendForm'])){
		$f['titulo'] 		= htmlspecialchars(mysql_real_escape_string($_POST['titulo']));
		$f['tags'] 			= htmlspecialchars(mysql_real_escape_string($_POST['tags']));
		$f['content'] 		= mysql_real_escape_string($_POST['content']);
		$f['date'] 			= htmlspecialchars(mysql_real_escape_string($_POST['data']));
		$f['categoria'] 	= htmlspecialchars(mysql_real_escape_string($_POST['categoria']));
		$f['cat_pai']		= getCat($f['categoria'], 'id_pai');
		$f['nivel'] 		= 1;//htmlspecialchars(mysql_real_escape_string($_POST['nivel']));
		$f['status']		= $postedit['status'];
		$f['autor']			= $_SESSION['autUser']['id'];
		$f['tipo']			= 'post';
		
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
			
			if(!empty($_FILES['thumb']['tmp_name'])){
				$pasta 	= '../uploads/';
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
				$f['thumb'] = $ano.'/'.$mes.'/'.$f['url'].'.'.$ext;
				uploadImage($img['tmp_name'], $f['url'].'.'.$ext, '960', $pasta.$ano.'/'.$mes.'/');
			}

				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Editou o artigo '.$f['titulo'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);	
				//Fim Auditoria

			update('up_posts',$f,"id = '$urledit'");
			$_SESSION['return']  = '<div class="green">	
					<p>Seu artigo foi atualizado com succeso.</p>
				</div>';
			header('Location: index2.php?exe=posts/posts-edit&editid='.$urledit);
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
            <span class="data">Foto de exibição:</span>
            <input type="file" class="fileinput" name="thumb" size="60" style="cursor:pointer; background:#FFF;" />
        </div>
        
        <div class="field-wrap">
            <input type="text" name="titulo" value="<?php echo $postedit['titulo']; ?>" placeholder="<?php echo $postedit['titulo']; ?>" />
        </div>
        
        <div class="field-wrap">
            <input type="text" name="tags" value="<?php echo $postedit['tags']; ?>" placeholder="<?php echo $postedit['tags']; ?>" />
        </div>

        <div class="field-wrap">
            <input type="text" name="data" class="formDate" value="<?php echo date('d/m/Y H:i:s',strtotime($postedit['data']));?>" />
        </div>

        <div class="field-wrap">
            <textarea name="content" class="editor" rows="15" placeholder="Conteúdo"><?php echo htmlspecialchars($postedit['content']); ?></textarea>
        </div>
        
        
        <div class="field-wrap" style="margin-top:10px;">
            <select name="categoria">
            	<option value="">Selecione uma categoria &nbsp;&nbsp;</option>
            	<?php
					$readCategoriaPai = read('up_cat',"WHERE id_pai IS NULL");
					if(!$readCategoriaPai){
						echo '<option value="">Não encontramos categorias. &nbsp;&nbsp;</option>';
					}else{
						foreach($readCategoriaPai as $pai):
							echo '<option value="" disabled="disabled">'.$pai['nome'].'</option>';
							$readCategorias = read('up_cat',"WHERE id_pai = '$pai[id]'");
							if(!$readCategorias){
								echo '<option value="" disabled="disabled">&raquo;&raquo; Cadastre uma sub-categoria aqui!</option>';
							}else{
								foreach($readCategorias as $cat):
									echo '<option value="'.$cat['id'].'" ';
									if($cat['id'] == $postedit['categoria']){
										echo 'selected="selected"';	
									}
									echo '>&raquo;&raquo; '.$cat['nome'].'</option>';
								endforeach;
							}
						endforeach;
					}
				?>
            </select>
          </div> 
            <div style="margin-top:20px;">
				<button type="submit" name="sendForm" value="Salvar" class="green">Atualizar</button>
				<button type="reset" name="sendForm" class="">Limpar</button>
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