<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'2')){
		header('Location: index2.php');
	}else{
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#9998;</span>
			<hgroup>
				<h1>Artigos</h1>
				<h2>Criar novo artigo</h2>
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
		$f['nivel'] 		= '0'; //Artigo Livre
		$f['status']		= ($_POST['sendForm'] == 'Salvar' ? '0' : '1');
		$f['autor']			= $_SESSION['autUser']['id'];
		$f['tipo']			= 'post';
		
		if(in_array('',$f)){
			echo '
					<div class="orange">	
						<p>Informe todos os campos</p>
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
			
			if(!empty($_FILES['thumb']['tmp_name'])){
				$pasta 	= '../uploads/';
				$ano 	= date('Y');
				$mes 	= date('m');
				
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
				$a['acao'] 		= 'Criou um artigo chamado '.$f['titulo'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria

			create('up_posts',$f);
			$idlast = mysql_insert_id();
			if($f['status'] == '1'){
				$_SESSION['cadastro'] = '
					<div class="green">	
						<p>Artigo cadastrado com sucesso.</p>
					</div>';
			}else{
				$_SESSION['cadastro'] = '
					<div class="green">	
						<p>Artigo cadastrado com sucesso, pendente de ativação.</p>
					</div>';
			}
			header('Location: index2.php?exe=posts/posts-edit&editid='.$idlast);
		}
	}
	?>
    <div class="content">
	<form name="formulario" action="" method="post" enctype="multipart/form-data">
		<div class="field-wrap">
            <span class="data">Foto de exibição:</span>
            <input type="file" class="fileinput" name="thumb" size="60" style="cursor:pointer; background:#FFF;" />
        </div>
        
        <div class="field-wrap">
            <input type="text" name="titulo" value="<?php if(isset($f['titulo'])) echo $f['titulo'];?>" placeholder="Título" />
        </div>
        
        <div class="field-wrap">
            <input type="text" name="tags" value="<?php if(isset($f['tags'])) echo $f['tags'];?>" placeholder="Tags" />
        </div>

        <div class="field-wrap">
            <textarea name="content" class="editor" rows="15" placeholder="Conteúdo"><?php if(isset($f['content'])) echo htmlspecialchars($f['content']);?></textarea>
        </div>
        
        <div class="field-wrap">
            <input type="text" name="data" class="formDate" value="<?php if(isset($f['date'])) echo $f['date']; else echo date('d/m/Y H:i:s');?>" />
        </div>
               
        <div class="field-wrap">
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
									if($cat['id'] == $f['categoria']){
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
			<button type="submit" name="sendForm" value="Salvar" class="blue">Salvar</button>
			<button type="submit" name="sendForm" value="Salvar e Publicar" class="green">Salvar e Publicar</button>
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