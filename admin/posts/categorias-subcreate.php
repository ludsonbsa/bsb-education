<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<span class="ms al">Desculpe, Você não tem permissão para gerenciar as categorias!</span>';
	}else{
		$urlpai = $_GET['idpai'];
		$prefix = $_GET['uri'];
		$readPai = read('up_cat',"WHERE id = '$urlpai'");
		if(!$readPai){
			header('Location: index2.php?exe=posts/categorias');
		}else
			foreach($readPai as $catpai);
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#59185;</span>
			<hgroup>
				<h1>Categoria: <strong><?php echo $catpai['nome'];?></strong></h1>
				<h2>Criar nova sub-categoria</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=paginas/paginas" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
    <?php
		if(isset($_POST['sendForm'])){
			$f['nome'] 		= htmlspecialchars(mysql_real_escape_string($_POST['nome']));	
			$f['content'] 	= htmlspecialchars(mysql_real_escape_string($_POST['content']));
			$f['tags'] 		= htmlspecialchars(mysql_real_escape_string($_POST['tags']));
			$f['date'] 		= htmlspecialchars(mysql_real_escape_string($_POST['data']));

			if(in_array('',$f)){
				echo '<div class="orange">	
						<p>Preencha todos os campos.</p>
					  </div>';
			}else{
				$f['id_pai'] = $urlpai;
				$f['data'] = formDate($f['date']); unset($f['date']);
				$f['url']  = $prefix.'-'.setUri($f['nome']);
				$readCatUri = read('up_cat',"WHERE url LIKE '%$f[url]%'");
				if($readCatUri){
					$f['url']  = $f['url'].'-'.count($readCatUri);
					$readCatUri = read('up_cat',"WHERE url = '$f[url]'");
					if($readCatUri){
						$f['url']  = $f['url'].'_'.time();
					}
				}
				create('up_cat',$f);

				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Criou uma Sub-categoria chamada '.$f['nome'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria
				
				$idlast = mysql_insert_id();
				$_SESSION['cadastro'] = '<div class="green">	
											<p>Sub-Categoria criada com sucesso!</p>
										  </div>';
				header('Location: index2.php?exe=posts/categorias-edit&edit='.$idlast.'&uri='.$prefix);
			}
		}
	?>    
	<div class="content">
    <form name="formulario" action="" method="post" enctype="multipart/form-data">
        <div class="field-wrap">
            <input type="text" name="nome" value="<?php if(isset($f['nome'])) echo $f['nome'];?>" placeholder="Titulo da Sub-Categoria" />
        </div>
        
        <div class="field-wrap">
            <textarea name="content" rows="3" placeholder="Descrição"><?php if(isset($f['content'])) echo $f['content'];?></textarea>
        </div>
        
        <div class="field-wrap">
            <input type="text" name="tags" value="<?php if(isset($f['tags'])) echo $f['tags'];?>" placeholder="Tags" />
        </div>
        
        <div class="field-wrap">
            <input type="text" class="formDate" name="data" value="<?php if(isset($f['date'])){ echo $f['date']; }else{ echo date('d/m/Y H:i:s'); }?>" placeholder="<?php if(isset($f['date'])){ echo $f['date']; }else{ echo date('d/m/Y H:i:s'); }?>" />
        </div>

        <div style="margin-top:20px;">
			<button type="submit" name="sendForm" class="green">Criar</button> <button type="reset" class="">Limpar</button>
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