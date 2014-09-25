<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<div class="orange">	
				<p>Você não tem permissão para acessar esta página.</p>
			  </div>';
	}else{
		$urledit  = $_GET['editid'];
		$readEdit = read('up_professores');
		if(!$readEdit){
			header('Location: index2.php?exe=professores/professores');
		}else
			foreach($readEdit as $postedit);
?>
<section class="content">
	<section class="widget" style="height: 400px; min-height:300px">
		<header>
			<span class="icon">&#128196;</span>
			<hgroup>
				<h1>Professores</h1>
				<h2>Editar professor <strong><?php echo $postedit['nome'];?></strong></h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=professores/professores" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
<?php
    if(isset($_POST['sendForm'])){
        $f['nome'] 		    	= strip_tags(trim(mysql_real_escape_string($_POST['nome'])));
        $f['funcao']    	    = strip_tags(trim(mysql_real_escape_string($_POST['funcao'])));
        $f['descricao'] 	    = strip_tags(trim(mysql_real_escape_string($_POST['descricao'])));
        $f['tecnica_um']    	= strip_tags(trim(mysql_real_escape_string($_POST['tecnica_um'])));
        $f['tecnica_dois']      = strip_tags(trim(mysql_real_escape_string($_POST['tecnica_dois'])));
        $f['tecnica_tres']    	= strip_tags(trim(mysql_real_escape_string($_POST['tecnica_tres'])));
        $f['pos_desc']    	    = strip_tags(trim(mysql_real_escape_string($_POST['pos_desc'])));


        if(in_array('',$f)){
			echo '<div class="orange">	
						<p>Preencha todos os campos.</p>
					  </div>';
		}else{

			if(!empty($_FILES['thumb']['tmp_name'])){
				$imagem = $_FILES['thumb'];
				$pasta	= '../uploads/professores/';
				$tmp	= $imagem['tmp_name'];
				$ext 	= substr($imagem['name'],-3);
				$nome	= md5(time()).'.'.$ext;	
				$f['thumb'] = $nome;				
				uploadImage($tmp, $nome, '643', $pasta);
			}
				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Editou o professor '.$f['nome'];
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim auditoria
			

			update('up_professores',$f,"id = '$urledit'");
				

			$_SESSION['return']  = '
									<div class="green">
										<p>Página atualizada com sucesso.
									</div>
								';
			
			header('Location: index2.php?exe=professores/professores-edit&editid='.$urledit);
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
                    <input type="text" name="funcao" value="<?php echo $postedit['funcao'];?>"/>
                </div>

                <div class="field-wrap">
                    <textarea name="descricao"><?php echo $postedit['descricao'];?></textarea>
                </div>

                <div class="field-wrap">
                    <input type="text" name="tecnica_um" value="<?php echo $postedit['tecnica_um'];?>" />
                </div>

                <div class="field-wrap">
                    <input type="text" name="tecnica_dois" value="<?php echo $postedit['tecnica_dois'];?>" />
                </div>

                <div class="field-wrap">
                    <input type="text" name="tecnica_tres" value="<?php echo $postedit['tecnica_tres'];?>" />
                </div>

                <div class="field-wrap">
                    <textarea name="pos_desc"><?php echo $postedit['pos_desc'];?></textarea>
                </div>

                <?php
                if($postedit['thumb']){
                    echo '<a href="../uploads/professores/'.$postedit['thumb'].'" title="Ver avatar" rel="ShadowBox">';
                    echo '<img src="../tim.php?src=../uploads/professores/'.$postedit['thumb'].'&w=50&h=50&zc=1&q=100" title="Avatar do usuário" alt="Avatar do usuario" />';
                    echo '</a>';
                }else{
                    echo 'Avatar:';
                }
                ?>

                <div class="field-wrap">
                    <input type="file" class="fileinput" name="thumb" size="60" style="cursor:pointer; background:#FFF;" />
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