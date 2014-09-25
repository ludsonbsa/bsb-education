 <?php
		$tres = date('m/Y',strtotime('-3months'));
		$tresEx = explode('/',$tres);
		$readTres = read('up_views',"WHERE mes = '$tresEx[0]' AND ano = '$tresEx[1]'");
		if($readTres){
			foreach($readTres as $rTres);
			$usersT = $rTres['visitantes'];
			$viewsT = $rTres['visitas'];
			$pagesT = substr($rTres['pageviews'] / $rTres['visitas'],0,5);
		}else{
			$usersT = '0';
			$viewsT = '0';
			$pagesT = '0';
		}
		
		$dois = date('m/Y',strtotime('-2months'));
		$doisEx = explode('/',$dois);
		$readdois = read('up_views',"WHERE mes = '$doisEx[0]' AND ano = '$doisEx[1]'");
		if($readdois){
			foreach($readdois as $rdois);
			$usersD = $rdois['visitantes'];
			$viewsD = $rdois['visitas'];
			$pagesD = substr($rdois['pageviews'] / $rdois['visitas'],0,5);
		}else{
			$usersD = '0';
			$viewsD = '0';
			$pagesD = '0';
		}
		
		$um = date('m/Y',strtotime('-1months'));
		$umEx = explode('/',$um);
		$readum = read('up_views',"WHERE mes = '$umEx[0]' AND ano = '$umEx[1]'");
		if($readum){
			foreach($readum as $rum);
			$usersU = $rum['visitantes'];
			$viewsU = $rum['visitas'];
			$pagesU = substr($rum['pageviews'] / $rum['visitas'],0,5);
		}else{
			$usersU = '0';
			$viewsU = '0';
			$pagesU = '0';
		}
		
		$atual = date('m/Y');
		$atualEx = explode('/',$atual);
		$readatual = read('up_views',"WHERE mes = '$atualEx[0]' AND ano = '$atualEx[1]'");
		if($readatual){
			foreach($readatual as $ratual);
			$users = $ratual['visitantes'];
			$views = $ratual['visitas'];
			$pages = substr($ratual['pageviews'] / $ratual['visitas'],0,5);
		}else{
			$users = '0';
			$views = '0';
			$pages = '0';
		}
	?>
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Year');
		data.addColumn('number', 'Usuários');
        data.addColumn('number', 'Visitas');
		data.addColumn('number', 'Visualizações de Páginas');
        
        data.addRows([
          ['<?php echo $tres;?>', <?php echo $usersT;?>, <?php echo $viewsT;?>, <?php echo $pagesT;?>],
          ['<?php echo $dois;?>', <?php echo $usersD;?>, <?php echo $viewsD;?>, <?php echo $pagesD;?>],
          ['<?php echo $um;?>', <?php echo $usersU;?>, <?php echo $viewsU;?>, <?php echo $pagesU;?>],
          ['<?php echo $atual;?>', <?php echo $users;?>, <?php echo $views;?>, <?php echo $pages;?>]
        ]);

        var options = {
          width: 950,
          height: 260,
          title: 'Estatisticas:',
          hAxis: {title: 'Relátorio de 3 meses', titleTextStyle: {color: 'red'}},
          pointSize: 8,
          focusTarget: 'category'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_divDois'));
        chart.draw(data, options);
      }
    </script>
    <div id="chart_divDois" style="width:1200px; height:300px; margin:0 auto;"></div>