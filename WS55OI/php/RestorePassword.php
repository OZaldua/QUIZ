<?php
	session_start();
	if(!isset($_SESSION['epostaAhaztua']) || !isset($_SESSION['kodea']))
		header("location: SendEmail.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pasahitza berrezarri</title>
    <script src="../js/EgiaztatuPasahitzBerria.js"></script> 
    <?php include '../html/Head.html'?>
</head>

<body>
<?php include 'Menus.php' ?>
<section class="main" id="s1">
    <div style="text-align: left">
        <form id="restorePassword" name="restorePassword" action="RestorePassword.php" method="post" onsubmit="return egiaztatu();">
            Eposta: <input type="text" id="eposta" name="eposta" value="<?php echo $_SESSION['epostaAhaztua']; ?>" readonly="readonly"> <br/>
			Berreskuratze-kodea: <input type="text" id="berKodea" name="berKodea"> <br>
            Pasahitza berria: <input type="password" id="pasahitza" name="pasahitza"><br/>
            Pasahitza berria errepikatu: <input type="password" id="pasahitza2" name="pasahitza2"><br/>
            <input type="submit" value="Pasahitza berrezarri" id="bidali" name="bidali"><br>
        </form><br/>
		Kodea iristen minutu batzuk tarda dezake. Koderik jasotzen ez baduzu, <a href="SendEmail.php">berri bat eskatu</a>
    </div>

<?php
include 'DbConfig.php';
if(isset($_POST['eposta'])){
    if(!empty($_POST["berKodea"]) && !empty($_POST["pasahitza"]) && !empty($_POST["pasahitza2"]) && !ctype_space($_POST["pasahitza"]) && !ctype_space($_POST["pasahitza2"])){ //Eremu guztiak beteta dauden egiaztatu
		if($_POST["berKodea"]==$_SESSION['kodea']){ //Mezuan bidalitako berreskurapen kodea erabiltzaileak sartu duen kode bera bada, pasahitza berrezartzeko orrira eraman
			if(strlen($_POST["pasahitza"])>=8){ //Pasahitzaren luzera minimoa 8koa
				if($_POST["pasahitza"]==$_POST["pasahitza2"]){ //Bi pasahitzak berdinak direla ziurtatu
					try {
						$dsn = "mysql:host=$zerbitzaria;dbname=$db";
						$dbh = new PDO($dsn, $erabiltzailea, $gakoa);
						$stmt = $dbh->prepare("UPDATE signed SET pasahitza=? WHERE eposta=?"); //Pasahitza berria ezarri datu-basean epostari
						$eposta=$_SESSION['epostaAhaztua'];
						$pasahitzakripto=crypt($_POST['pasahitza'], 'Oi'); //Pasahitza enkriptatu
						$stmt->bindParam(1, $pasahitzakripto); 
						$stmt->bindParam(2, $eposta); 
						try{
							$stmt->execute();
							$row_count = $stmt->rowCount();
							if($row_count==0){
								echo "<p style='color:red; font-size: 25px;'>Errorea pasahitza aldatzerakoan!</p>";        
							}else{
								echo "<script>alert('Pasahitza zuzen berrezarri da! Orain horrekin kautotu zaitezke.');</script>";
								header("location: LogIn.php");
							}       
						} catch(Exception $e2){
							echo "Errorea exekutatzerakoan! ".$e2->getMessage();
						}
						$dbh = null;
					} catch (PDOException $e){
						echo "Errore bat gertatu da: ".$e->getMessage();
					}
				}else
					echo "<p style='color:red; font-size: 25px;'>Pasahitzak ez dira berdinak.</p>";
			}else
				echo "<p style='color:red; font-size: 25px;'>Pasahitzak gutxienez 8 karaktere izan behar ditu.</p>";
		} else
			echo "<p style='color:red; font-size: 25px;'>Kodea ez da zuzena!</p>";
    }else
        echo "<p style='color:red; font-size: 25px;'>Eremu guztiak bete behar dira.</p>";   
}
?>
</section>
<?php include '../html/Footer.html' ?>
</body>
</html>  