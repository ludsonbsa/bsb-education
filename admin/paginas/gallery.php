
<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<section class="alert">
				<div class="orange">	
					<p>Você não tem permissão para acessar esta página.</p>
				</div>
			</section>';
	}else{
		$postid = $_GET['postid'];
		$readPost = read('up_posts',"WHERE id = '$postid'");
		if(!$readPost){
			header('Location: index2.php?exe=paginas/paginas');
		}else
		foreach($readPost as $post);
?>
<section class="content">
	<section class="widget">
		<header>
			<span class="icon">&#59153;</span>
			<hgroup>
				<h1>Postar fotos em <?php echo $post['titulo'];?></h1>
				<h2>Upload de galeria</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=paginas/paginas" style="color:#fff"><button class="blue">Voltar</button></a>
			</aside>
		</header>
		<div class="content">
			<div id="">
				<form action="" method="post">
			        <label>
			            <input id="file_upload" name="file_upload" type="file" class="file" />
			        </label>
			            <a href="javascript:$('#file_upload').uploadifyUpload();" class="btn upload">clique aqui para enviar!</a>
			    </form>
			</div>
			<br />
			<br /><br /><br />
			<?php
		if(!empty($_GET['delid'])){
			$imgid = $_GET['delid'];
			$imgIm = $_GET['img'];
			$pasta = '../uploads/';
				if(file_exists($pasta.$imgIm) && !is_dir($pasta.$imgIm)){
					unlink($pasta.$imgIm);
				}
				delete('up_posts_gb',"id = '$imgid'");
		}
		$readGb = read('up_posts_gb',"WHERE post_id = '$postid'");
		if(!$readGb){
			
		}else{
			echo '<ul class="gblist">';
			foreach($readGb as $gb):
			$i++;
    ?>
    <li<?php if($i%6==0){echo ' class="last"';}?>>
        <img src="../tim.php?src=../uploads/<?php echo $gb['img'];?>&w=85&h=65&q=100&zc=1" width="85" height="65" />
        <div class="action">
            <a href="../uploads/<?php echo $gb['img'];?>" rel="shadowbox" title="Imagem da galeria de: <?php echo $post['titulo'];?>"><img src="ico/view.png" title="Imagem da galeria de: <?php echo $post['titulo'];?>" alt="Imagem da galeria de: <?php echo $post['titulo'];?>" /></a>
            <a href="index2.php?exe=paginas/gallery&postid=<?php echo $post['id'];?>&delid=<?php echo $gb['id'];?>&img=<?php echo $gb['img'];?>" title="Exluir imagem <?php echo $i;?>">
            	<img src="ico/no.png" title="Exluir imagem <?php echo $i;?>" alt="Exluir imagem <?php echo $i;?>" />
            </a>
        </div><!-- /action -->
    </li>
	<?php 
			endforeach;
			echo '</ul>';
		}
    ?>
		</div>
	</section>
</section>
<?php
	}
}else{
	header('Location: ../index2.php');
}
?>