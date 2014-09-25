<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<div class="orange">	
				<p>Você não tem permissão para acessar esta página.</p>
			  </div>';
	}else{
		$urledit  = $_GET['edit'];
		$readEdit = read('up_cat',"WHERE id = '$urledit'");
		if(!$readEdit){
			header('Location: index2.php?exe=posts/categorias');
		}else
			foreach($readEdit as $catedit);
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#59185;</span>
			<hgroup>
				<h1>Categoria: <strong><?php echo $catedit['nome'];?></strong></h1>
				<h2>Editar categoria</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=posts/categorias" style="color:#fff"><button class="blue">Voltar</button></a>
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
				$f['data'] = formDate($f['date']); unset($f['date']);
				if($catedit['nome'] != $f['nome']){
					$prefix = $_GET['uri'];
					if($prefix){
						$f['url']  = $prefix.'-'.setUri($f['nome']);
						$readCatUri = read('up_cat',"WHERE url LIKE '%$f[url]%' AND id_pai IS NOT null AND id != '$urledit'");
						if($readCatUri){
							$f['url']  = $f['url'].'-'.count($readCatUri);
							$readCatUri = read('up_cat',"WHERE url = '$f[url]' AND id_pai IS NOT null AND id != '$urledit'");
							if($readCatUri){
								$f['url']  = $f['url'].'_'.time();
							}
						}
					}else{
						$f['url']  = setUri($f['nome']);
						$readCatUri = read('up_cat',"WHERE url LIKE '%$f[url]%' AND id_pai IS null AND id != '$urledit'");
						if($readCatUri){
							$f['url']  = $f['url'].'-'.count($readCatUri);
							$readCatUri = read('up_cat',"WHERE url = '$f[url]' AND id_pai IS null AND id != '$urledit'");
							if($readCatUri){
								$f['url']  = $f['url'].'_'.time();
							}
						}
					}
				}else{
					$f['url']  = $catedit['url'];
				}

				update('up_cat',$f,"id = '$urledit'");
				
				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Editou a categoria '.$f['nome'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria


				$_SESSION['return'] = '
					  <div class="green">	
						<p>Categoria atualizada com sucesso.</p>
					  </div>';
				if($prefix){
					header('Location: index2.php?exe=posts/categorias-edit&edit='.$urledit.'&uri='.$prefix);
				}else{
					header('Location: index2.php?exe=posts/categorias-edit&edit='.$urledit);
				}
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
            <input type="text" name="nome" value="<?php echo $catedit['nome'];?>" placeholder="<?php echo $catedit['nome'];?>" />
        </div>
        
        <div class="field-wrap">
            <textarea name="content" rows="3" placeholder="<?php echo $catedit['content'];?>"><?php echo $catedit['content'];?></textarea>
        </div>
        
        <div class="field-wrap">
            <input type="text" name="tags" value="<?php echo $catedit['tags'];?>" placeholder="<?php echo $catedit['tags'];?>" />
        </div>
        
        <div class="field-wrap">
            <input type="text" class="formDate" name="data" value="<?php echo date('d/m/Y H:i:s',strtotime($catedit['data']));?>" />
        </div>

        <div style="margin-top:20px;">
			<button type="submit" name="sendForm" class="green">Editar</button> <button type="reset" class="">Limpar</button>
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