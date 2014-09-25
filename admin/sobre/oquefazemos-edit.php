<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<div class="orange">	
				<p>Você não tem permissão para acessar esta página.</p>
			  </div>';
	}else{

		$readEdit = read('up_oquefazemos');
		if(!$readEdit){
			header('Location: index2.php?exe=sobre/sobre');
		}else
			foreach($readEdit as $postedit);
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>Sobre - O que fazemos</h1>
				<h2>Editar Sobre - <strong><?php echo $postedit['titulo'];?></strong></h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=sobre/sobre" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
<?php
    if(isset($_POST['sendForm'])){
		$f['titulo'] 		= htmlspecialchars(mysql_real_escape_string($_POST['titulo']));
		$f['descricao'] 	= htmlspecialchars(mysql_real_escape_string($_POST['descricao']));
		$f['texto'] 		= mysql_real_escape_string($_POST['texto']);
        $f['thumb']         = $_FILES['thumb'];
		
		
		
		if(in_array('',$f)){
			echo '<div class="orange">	
						<p>Preencha todos os campos.</p>
					  </div>';

        }else{
            if(!empty($_FILES['thumb']['tmp_name'])){
                $imagem = $_FILES['thumb'];
                $pasta	= '../uploads/paginas/';
                $tmp	= $imagem['tmp_name'];
                $ext 	= substr($imagem['name'],-3);
                $nome	= md5(time()).'.'.$ext;
                $f['thumb'] = $nome;
                uploadImage($tmp, $nome, '532', $pasta);
            }else{
                $f['thumb'] = $postedit['thumb'];
            }

            update('up_oquefazemos',$f,"id = '1'");
				

			$_SESSION['return']  = '
									<div class="green">
										<p>Página atualizada com sucesso.
									</div>
									';
			
			header('Location: index2.php?exe=sobre/oquefazemos-edit');
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
				<input type="text" name="titulo" value="<?php echo $postedit['titulo'];?>" />
			</div>

			<div class="field-wrap">
				<input type="text" name="descricao" value="<?php echo $postedit['descricao'];?>" />
			</div>

			<textarea name="texto" class="editor" rows="15"><?php echo htmlspecialchars($postedit['texto']);?>
			</textarea>
            <br><br>
            <?php
            if($postedit['thumb']){
                echo '<a href="../uploads/paginas/'.$postedit['thumb'].'" title="Ver thumb" rel="ShadowBox">';
                echo '<img src="../tim.php?src=../uploads/paginas/'.$postedit['thumb'].'&w=50&h=45&zc=1&q=100" title="" alt="" />';
                echo '</a>';
            }else{
                echo 'Imagem:';
            }
            ?>

            <div class="field-wrap">
                <input type="file" class="fileinput" name="thumb" size="60" style="cursor:pointer; background:#FFF;" />
            </div>
		
			<div style="margin-top:20px;">
				<button type="submit" name="sendForm" class="green">Atualizar Sessão</button> 
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