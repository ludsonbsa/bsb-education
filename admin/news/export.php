<?php
	include('../../dts/dbaSis.php');
	$sql = 'SELECT * FROM up_newsletter';  
	$rs = mysql_query($sql) or exit ('up_newsletter');  
	if($rs){
		header("Content-type: application/csv");   
		header("Content-Disposition: attachment; filename=file.csv");   
		header("Pragma: no-cache"); 
		while ($ret = mysql_fetch_assoc($rs))  
		{  
		    echo implode(';', $ret);  
		    echo "\n";  
		} 
	}else{
		?>
		<script>
			alert("Não existem registros a serem exportados");
		</script>
		<?php
	}
?>