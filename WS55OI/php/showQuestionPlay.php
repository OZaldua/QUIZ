<?php
	session_start();

	include "DbConfig.php";
	$sqlkonexioa = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

	if($sqlkonexioa->connect_errno) {
		die( "Huts egin du konexioak MySQL-ra: (".$sqlkonexioa-> connect_errno . ") " .$sqlkonexioa-> connect_error );
	}
	
	echo "<h3 id='gaia'>".$_GET['gaia']."</h3>";
	echo "<input type='hidden' id='gaiak' value='".$_GET['gaia']."'/>";
	echo "<hr/><br/><br/>";
	$galderenIDarray = $_SESSION[$_GET['gaia']]; //Gaiko galderen array-a eskuratu
	if(count($galderenIDarray)==0 ){ //Jada ez dira galderak erantzun gabe gelditzen
		echo "<h3>ZORIONAK! \"".$_GET['gaia']."\" GAIKO GALDERA GUZTIAK ERANTZUN DITUZU!</h3><br/>";
		$z = $_GET['gaia'].'ZuzenKop';
		$o = $_GET['gaia'].'OkerKop';
		echo "<h4>".$_SESSION[$z]." galdera zuzen eta ".$_SESSION[$o]." oker erantzun dituzu gaian!</h4><br/>";
		echo "<h4>".$_SESSION['zuzenKop']." zuzen eta ".$_SESSION['gaizkiKop']." oker guztira!</h4><br/>";
		echo '<button onclick="window.location.href=\'Play.php\'"> Gai berri bat aukeratu</button><br/><br/>'; //Play.php-ra joateko aukera
		
		echo '<form action="PuntuazioaGorde.php" method="post">'; //Bere puntuazioa inkrementatzeko aukera PuntuazioaGorde.php-ri formularioa bidaliz
		echo '<p>Gaian lortutako puntuazioa gorde nahi duzu?</p>';
		
		//Anonimoa bada
		if(!isset($_SESSION['eposta'])){
			echo '<p>VIPa bazara sartu zure korreoa!</p>';
			echo '<input type="text" id="vip_korreoa" name="vip_korreoa"/>';
		}
		echo '<input type="submit" id="gorde_puntuazioa" name="gorde_puntuazioa" value="Gorde!"/>';
		echo '<input type="hidden" id="puntuazioa" name="puntuazioa" value="'.$_SESSION[$z].'"/>'; //Puntuazioa gorde gero eskuratu ahal izateko
		echo '</form>';
		
	}else{
		//Galderaren ezaugarriak lortu
		$sql_galdera = "SELECT galdera, erZ, erO1, erO2, erO3, argazkia, zailtasuna, likes, dislikes FROM questions WHERE galderaID=".$galderenIDarray[0]."";
		if (!$sqlkonexioa->query($sql_galdera)) {
			echo "<p>Errore bat gertatu da. " .$sqlkonexioa->error. "</p>";
		}else{
			$galderak = mysqli_query($sqlkonexioa, $sql_galdera);
			$galdera = mysqli_fetch_assoc($galderak);
			echo "<h3>".$galdera['galdera']."</h3><br/>";
			$z = $galdera['zailtasuna'];
			//Hiru izar pantailaratu, galderaren zailtasuna adierazteko.
			$i=1;
			while($i<=$z){
				$i++;
				echo '<span class="fa fa-star checked"></span>';
			}
			while($i<=3){
				$i++;
				echo '<span class="fa fa-star"></span>';
			}
			echo '<br/><br/>';
			if ($galdera['argazkia']){
				echo '<img width="75px" src="data:image/jpeg;base64,'.base64_encode($galdera['argazkia']).'"/><br/>';
			}
			$erantzunak = array($galdera['erZ'], $galdera['erO1'], $galdera['erO2'], $galdera['erO3']);
			shuffle($erantzunak); //Lau erantzun posibleen arraya nahastu
			foreach($erantzunak as $er){ //Ernatzun bakoitzeko botoia egin
				echo '<button class="erantzunBotoia" id="'.$er.'" value="'.$er.'" onclick="erantzunaBalioztatu(\''.$galdera['erZ'].'\',\''.$er.'\')">'.$er.'</button><br/><br/>';
			}
			
?>
			<button value="next" id="next" onclick="jolastu()" disabled="true">Hurrengo galdera</button>
			<button value="leave" onclick="window.location.href='Play.php'">Utzi jolasteari</button><br/><br/>
				
			<h4 id="emaitza"></h4>
<?php		
			$like_kop = $galdera['likes'];
			$dislike_kop = $galdera['dislikes'];
			echo '<span class="fa fa-thumbs-up like-btn" id="like" name="like" onclick="like(\''.$galderenIDarray[0].'\')"></span><label id="like_kop" value="'.$like_kop.'"> '.$like_kop.' </label>';
			echo '<span class="fa fa-thumbs-down like-btn" id="dislike" name="dislike" onclick="dislike(\''.$galderenIDarray[0].'\')"></span><label id="dislike_kop"> '.$dislike_kop.' </label>';

		}
			
		$sqlkonexioa->close();
	}
?>