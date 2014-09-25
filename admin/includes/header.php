<div class="testing">
<header class="main">
	<h1><strong><?php echo SITENAME;?></strong> Dashboard</h1>
</header>
<section class="user">
	<div class="profile-img">
	
		<p><img src="<?php echo '../uploads/avatars/'.$autUser['avatar'];?>" alt="" height="40" width="40" /> Seja bem-vindo <strong><?php echo $autUser['nome'];?></strong></p>
	</div>
	<div class="buttons">
		<span class="button dropdown">
			<a href="index2.php?exe=auditoria/auditoria">Auditoria </a>
				<span class="pip"><?php 
				$query = mysql_query('SELECT * FROM up_auditoria');
				$row = mysql_num_rows($query);
				if($row >= 101){
					echo '100+';
				}else{
					echo $row;
				}
				?></span>

			<ul class="notice">
				<?php 

					$ler = read('up_auditoria',"ORDER BY id DESC LIMIT 5");
					if($ler){
					foreach($ler as $auditor):
				?>
				<li>
					<hgroup>
						<h1><?php echo $auditor['usuario'];?></h1>
						<h2><?php echo $auditor['acao'];?></h2> 
					</hgroup>
					<p><span><?php echo date('d/m/Y H:i',strtotime($auditor['data']));?></span></p>
				</li>
				<?php 
					endforeach;
				}else{
					echo
					'
					<li>
						<hgroup>
							<h1><Nenhuma ação registrada.</h1>
							<h2></h2> 
						</hgroup>
						<p><span>'.date('d/m/Y H:i').'</span></p>
					</li>
					';
				}
				?>
			</ul>
		</span> 

		<a href="../" target="_blank"><span class="button">Ver site</span></a>
		<!--<a href=""><span class="button">Suporte</span></a>-->
		<a href="logoff.php"><span class="button blue">Logout</a></span>
	</div>
</section>
</div>