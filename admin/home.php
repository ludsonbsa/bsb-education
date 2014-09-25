<section class="content">
		<section class="widget">
			<header>
				<span class="icon">&#128200;</span>
				<hgroup>
					<h1>Estatisticas</h1>
					<h2>Dados infográficos</h2>
				</hgroup>
			</header>		
			<?php include 'includes/graph.php';?>
			</div>
		</section>
	
	<div class="widget-container">
		<section class="widget small">
			<header> 
				<span class="icon">&#128318;</span>
				<hgroup>
					<h1>Resumo de dados</h1>
					<h2>Estatistica do banco de dados</h2>
				</hgroup>
				
			</header>
			<div class="content">
				<section class="stats-wrapper">
					<div class="stats">
						<p><span><?php	$readUserCad = read('up_users');echo count($readUserCad);?></span></p>
						<p>Usuários Cadastrados</p>
					</div>
					<div class="stats">
						<p><span><?php $readPaginas = read('up_posts',"WHERE tipo = 'pagina'");echo count($readPaginas);?></span></p>
						<p>Páginas</p>
					</div>
				</section>
				
				<section class="stats-wrapper">
					<div class="stats">
						<p><span><?php  $readVisitantes = read('up_views_online');	
						if(count($readVisitantes) >= '1'){ 
							echo count($readVisitantes);
						}else{ 
							echo '0';
						}?>
					</span></p>
						<p>Visitantes On-line</p>
					</div>
					<div class="stats">
						<p><span>
                                <?php
                                echo '0';
                                ?>
                        </span></p>
						<p>Categorias</p>
					</div>
				</section>
			</div>
		</section>

		
		<section class="widget small">
			<header> 
				<span class="icon">&#128363;</span>
				<hgroup>
					<h1>Auditoria</h1>
					<h2>Atividades do sistema</h2>
				</hgroup>
				
			</header>
			<div class="content no-padding timeline">
				<?php 
					$ler = read('up_auditoria',"ORDER BY id DESC LIMIT 4");
					if($ler){
					foreach($ler as $audi):
					?>
				<div class="tl-post">
					<span class="icon">&#128206;</span>
					<p><a href="#"><?php echo $audi['usuario'];?></a> <?php echo $audi['acao'];?></p>
				</div>
					<?php endforeach; 
				}
				else{
					echo 
					'
					<div class="tl-post">
						<span class="icon">&#128206;</span>
						<p><a href="#">Não foi registrado nenhuma ação no sistema.</p>
					</div>
					';
				}
				?>
				<div class="pie graph-area"></div>
			</div>
		</section>
	</div>
</section>
