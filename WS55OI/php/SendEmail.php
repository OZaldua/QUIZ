<!DOCTYPE html>
<html>
<head>
    <title>Emaila bidali</title>
    <?php include '../html/Head.html'?>
</head>

<body>
<?php include 'Menus.php' ?>
<section class="main" id="s1">
    <div style="text-align: left">
        <h4>Pasahitza berrezartzeko kode bat bidaliko dizugu. Zein da zure korreoa?</h4><br/>
        <form id="sendEmail" name="sendEmail" action="SendEmail.php" method="post"> <!--Berreskurapen kodea eskuratzeko bidali behar den formularioa-->
            <label>Eposta sartu:</label>
            <input type="text" id="eposta" name="eposta"> <br/><br/>
            <input type="submit" value="Berreskurapen kodea eskatu" id="kodeEskatu" name="kodeEskatu"><br>
        </form>
    </div>

<?php
include 'DbConfig.php';
if(isset($_POST["eposta"])){
	if(!empty($_POST["eposta"])){
		session_start();
		try {
			$dsn = "mysql:host=$zerbitzaria;dbname=$db";
			$dbh = new PDO($dsn, $erabiltzailea, $gakoa);
			$stmt = $dbh->prepare("SELECT eposta FROM signed WHERE eposta=?");
			$eposta=$_POST['eposta'];
			$stmt->bindParam(1, $eposta);
			try{
				$stmt->execute();
				$row_count = $stmt->rowCount();
				if($row_count==1){
					$_SESSION['epostaAhaztua']=$_POST['eposta']; //Posta $_SESSION-n gordetzeko.
					$zenKar = '0123456789abcdefghijklmnopqrstuvwxyz';
					$kodea = substr(str_shuffle($zenKar), 0, 10); //Ausaz berreskurapen kodea sortzeko.
					$_SESSION['kodea']=$kodea; //Kodea $_SESSION['kodea']-n gordetzeko.
					
					//Bidaliko den mezua prestatzeko:
					$to = $_POST['eposta']; //Kodea formularion sartu den email-era bidali
					$subject = "Berreskurapen kodea pasahitza berrezartzeko"; //Email-aren gaia
					$message = "Berreskurapen kodea: ".$kodea; //Mezua (berreskurapen kodea)
					$headers = "From: ozaldua006@ikasle.ehu.es\r\n"; //Emailaren goiburua. Nork bidaltzen du emaila.
					$headers.= "X-Mailer: PHP/". phpversion();
					if(mail($to, $subject, $message, $headers)){ //Mezua bidali eta ondo bidaltzen bada
						echo "<script> alert('Mezua bidali da!'); window.location='RestorePassword.php' </script>";
					}else
						echo "<p style='color:red;font-size: 25px;'>Mezua ezin izan da bidali</p>";
				}else{
					echo "<p style='color:red;font-size: 25px;'>Ez zaude erregistratuta! <a href='SignUp.php'>HEMEN</a> erregistra zaiteke.</p>";}    
			} catch(Exception $e2){
				echo "Errore bat gertatu da! Saiatu berriro";
			}
			$dbh = null;
		} catch (PDOException $e){
			echo $e->getMessage();
		}  
	}else
		echo "<script>alert('Zure emaila sartu behar duzu!');</script>";
}
?>
</section>
<?php include '../html/Footer.html' ?>
</body>
</html>