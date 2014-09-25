<?php
if(function_exists(getUser)){
	if(!getUser($_SESSION['autUser']['id'],'1')){
		echo '<span class="ms al">Desculpe, Você não tem permissão para gerenciar as categorias!</span>';
	}else{
?>
<section class="content">
		<section class="widget">
		<header>
			<span class="icon">&#59214;</span>
			<hgroup>
				<h1>Categoria</h1>
				<h2>Listar categorias</h2>
			</hgroup>
			<aside>
				<a href="index2.php?exe=posts/categorias-create" style="color:#fff"><button class="green">Criar Categoria</button></a>
			</aside>
		</header>   
    <?php
		if(!empty($_GET['delcat'])){
			$idDel = mysql_real_escape_string($_GET['delcat']);
			$readDelCat = read('up_cat',"WHERE id_pai = '$idDel'");
			if(!$readDelCat){	
				$del = delete('up_cat',"id = '$idDel'");

				//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Removeu a categoria #'.$idDel;
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria

				echo '<div class="green">	
						<p>Categoria removida com sucesso.</p>
					  </div>';
			}else{
				echo '<div class="orange">	
						<p>Esta categoria possui subcategorias, é necessário exclui-las antes.</p>
					  </div>';	
			}
		}
		if(!empty($_GET['delsub'])){
			$idDel = mysql_real_escape_string($_GET['delsub']);	
			//Auditoria
				$a['usuario']	= $_SESSION['autUser']['nome'];
				$a['acao'] 		= 'Removeu a categoria #'.$idDel;
				$a['date'] 		= htmlspecialchars(mysql_real_escape_string(date('d/m/Y H:i:s')));
				$a['data'] 		= formDate($a['date']); 
				unset($a['date']);
				create('up_auditoria',$a);
				//Fim Auditoria
			$del = delete('up_cat',"id = '$idDel'");
			echo '<div class="green">	
					<p>Categoria removida com sucesso.</p>
				</div>';
		}
	
	
		$pag = (empty($_GET['pag']) ? '1' : $_GET['pag']);
		$maximo = 3;
		$inicio = ($pag * $maximo) - $maximo;
		$readCat = read('up_cat',"WHERE id_pai IS null LIMIT $inicio,$maximo");
		if(!$readCat){
			echo '<div class="orange">	
					<p>Não existem registros de categorias</p>
				</div>';
		}else{
			?>
			<div class="content">
			<table id="myTable" border="0" width="100">
				<thead>
					<tr>
						<th>Categoria</th>
						<th>Resumo</th>
						<th>Tags</th>
						<th>Criada</th>
						<th colspan="3">Ações</th>
					</tr>
				</thead>
				<tbody>
      <?php
	  	foreach($readCat as $cat):
			$catTags = ($cat['tags'] != '' ? 'ok.png' : 'no.png');
			echo '<tr>';
				echo '<td>'.$cat['nome'].'</td>';
				echo '<td>'.lmWord($cat['content'],'35').'</td>';
				echo '<td><img src="ico/'.$catTags.'" alt="Tags da Categoria" title="'.$cat['tags'].'" /></td>';
				echo '<td>'.date('d/m/Y H:i',strtotime($cat['data'])).'</td>';
				echo '<td><a href="index2.php?exe=posts/categorias-edit&edit='.$cat['id'].'" ';
					echo 'title="Editar Categoria '.$cat['nome'].'"><img src="ico/edit.png" alt="Editar Categoria '.$cat['nome'].'" ';
					echo 'title="Editar Categoria '.$cat['nome'].'" /></a></td>';
				echo '<td><a href="index2.php?exe=posts/categorias-subcreate&idpai='.$cat['id'].'&uri='.$cat['url'].'" ';
					echo 'title="Criar Sub-categoria"><img src="ico/new.png" alt="Criar sub categoria" ';
					echo 'title="Criar Sub-categoria" /></a></td>';
				echo '<td><a href="index2.php?exe=posts/categorias&delcat='.$cat['id'].'" ';
					echo 'title="Deletar Categoria '.$cat['nome'].'"><img src="ico/no.png" alt="Deletar Categoria '.$cat['nome'].'" ';
					echo 'title="Deletar Categoria '.$cat['nome'].'" /></a></td>';
			echo '</tr>';
		
		$readSubCat = read('up_cat',"WHERE id_pai = '$cat[id]'");
		if($readSubCat){
			foreach($readSubCat as $catSub):
			$catSubTags = ($catSub['tags'] != '' ? 'ok.png' : 'no.png');
			echo '<tr class="subcat">';
			echo '<td>&raquo;&raquo; '.$catSub['nome'].'</td>';
			echo '<td>'.lmWord($catSub['content'],'35').'</td>';
			echo '<td><img src="ico/'.$catSubTags.'" alt="Tags da categoria" title="'.$catSub['tags'].'" /></td>';
			echo '<td>'.date('d/m/Y H:i',strtotime($catSub['data'])).'</td>';
			echo '<td colspan="2"><a href="index2.php?exe=posts/categorias-edit&edit='.$catSub['id'].'&uri='.$cat['url'].'" ';
				echo 'title="Editar Categoria '.$catSub['nome'].'"><img src="ico/edit.png" alt="Editar categoria '.$catSub['nome'].'" ';
				echo 'title="Editar Categoria '.$catSub['nome'].'" /></a></td>';
			echo '<td><a href="index2.php?exe=posts/categorias&delsub='.$catSub['id'].'" ';
				echo 'title="Deletar Categoria '.$catSub['nome'].'"><img src="ico/no.png" alt="Deletar categoria '.$catSub['nome'].'" ';
				echo 'title="Deletar Categoria '.$catSub['nome'].'" /></a></td>';
			echo '</tr>';
			endforeach;
		}

	  	endforeach;
		echo '<tbody>';
		echo '</table>';
		$link = 'index2.php?exe=posts/categorias&pag=';
		readPaginator('up_cat',"WHERE id_pai IS null", $maximo, $link, $pag);
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