<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="../js/jokatzen.js"></script>
  <script src="../js/erantzunaBalioztatu.js"></script>
  <script src="../js/like.js"></script>
  <style type="text/css">
	.erantzunBotoia{
		border: 1px solid;
		background-color: white; color: black;
		height: 50px; width: 200px;
	}
	
	.erantzunBotoia:hover{
		background-color:lightblue;
	}
	
	.checked {
		color: orange;
	}
	
	#like:hover, #dislike:hover{
		color: blue;
	}
	
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<?php include '../php/Menus.php' ?>
	<section class="main" id="play" style="overflow-y: scroll">
    <div id="playDiv">
		<form id="jolastera" name="jolastera" action="" method="post"> 
			<h1>Jolastera!</h1><br/>
			<?php
			include "DbConfig.php";
			$sqlkonexioa = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

			if($sqlkonexioa->connect_errno) {
				die( "Huts egin du konexioak MySQL-ra: (".$sqlkonexioa-> connect_errno . ") " .$sqlkonexioa-> connect_error );
			}
		
			$sql="SELECT DISTINCT(gaia) FROM questions"; //Gai desberdin guztiak lortu
			if (!$sqlkonexioa->query($sql)) {
				echo "<p>Errore bat gertatu da. " .$sqlkonexioa->error. "</p>";
			}else{
				$gai_jokatu_gabe = 0;
				echo "<select id='gaiak' name='gaiak'>"; //Select bat prestatu
				$gaiak = mysqli_query($sqlkonexioa, $sql);
                while($gaia = mysqli_fetch_assoc($gaiak)){ //Gaiak korritu
					$g = $gaia['gaia'];
					
					if (!isset($_SESSION[$g])){ //Gaiaren izen bera duen SESSION aldagai bat ez badago, sortu eta osatu
						$sql2 = "SELECT galderaID FROM questions WHERE gaia = '".$g."' ORDER BY RAND()"; //Gaiko galderak ausaz lortu
						if (!$sqlkonexioa->query($sql2)) {
							echo "<p>Errore bat gertatu da. " .$sqlkonexioa->error. "</p>";
						}else{
							$array = array();
							$galderakID = mysqli_query($sqlkonexioa, $sql2);
							while($galderaID = mysqli_fetch_array($galderakID)){//Galderen IDak array batean gorde
								$array[] = $galderaID[0];
							}
							$_SESSION[$g] = $array; //SESSION aldagaia sortu, gaiaren izenarekin, eta arraya bertan gorde
						}
					}
					if(isset($_SESSION[$g]) && count($_SESSION[$g])!=0){ //Gai horren izenarekin aldagaia badago eta honek galderak baditu gaia SELECT-ean jarri
						echo '<option value="'.$g.'">' .$g. '</option>';
						$gai_jokatu_gabe++;
					}
					$zuzenKopAldagai = $g."ZuzenKop";
					$okerKopAldagai = $g."OkerKop";
					if(!isset($_SESSION[$zuzenKopAldagai])){
						$_SESSION[$zuzenKopAldagai] = 0;
					}
					if (!isset($_SESSION[$okerKopAldagai])){
						$_SESSION[$okerKopAldagai] = 0;
					}
				}
				echo "</select>";
				if(!isset($_SESSION['zuzenKop'])){
					$_SESSION['zuzenKop'] = 0;
				}
				if (!isset($_SESSION['gaizkiKop'])){
					$_SESSION['gaizkiKop'] = 0;
				}
				if($gai_jokatu_gabe==0){
					echo "<h3>ZORIONAK! Gai guztien galderak erantzun dituzu!</h3>";
				}else{
					echo '<input type="button" value="HASI" onclick="jolastu()"><br/><br/>';
					echo '<h5>Aukeratu gaia eta jolastera!<br/> Jolasean zure ustetan aukera zuzena denean klikatzearekin nahiko izango duzu.</h5>';
				}
			}
			$sqlkonexioa->close();
			?>
		</form>
    </div>
	</section>
	<?php include '../html/Footer.html' ?>
</body>
</html>