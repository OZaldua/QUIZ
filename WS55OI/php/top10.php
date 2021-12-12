<div class="top10">
<h4>Top 10 quizers - Global Ranking</h4><br/><br/>
<?php	
	$curl = curl_init();
	$url = "https://sw.ikasten.io/~ozaldua006/REST/VipUsers/";
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$str = curl_exec($curl);
	
	$row = explode('<br>', $str);
	if(count($row)==0){
		echo "<p>Ez dago jokalaririk! Lehenengoa izan nahi?</p><br/>";
		echo '<button onclick="window.location.href=\'Play.php\'">Jolastera!</button>';
	}else{
		echo "<table border='1'>";
		echo "<tr><th>#</th><th>Jokalaria</th><th>Puntuazioa</th></tr>";
		$counter = 0;
		$vips_amount = sizeof($row);
		while(($quizer = $row[$counter]) && ($counter<10) && ($counter<$vips_amount-1)){
			$counter = $counter +1;
			$q = explode(",", $quizer);
			echo "<tr class='a".$counter."'><td>".$counter."</td><td>".$q[0]."</td><td>".$q[1]."</td></tr>";
		}
		echo "</table>";
	}
?>
</div>