<div id='page-wrap'>
<header class='main' id='h1'>
	<?php
		include 'DbConfig.php';
		if (!isset($_SESSION['eposta'])){
			echo '<span class="right"><a href="SignUp.php">Erregistratu </a></span>';
			echo '<span class="right"><a href="LogIn.php">Saioa hasi  </a></span>';
		} else{
			echo '<span class="right" ><a href="LogOut.php">Saioa itxi </a></span>';
			echo $_SESSION['eposta'];
			$ald = $_SESSION['eposta'];
			$niresqli = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);
			if (isset($_SESSION['argazkia']))
				echo '<img width="50px" src="data:image/jpeg;base64,'.base64_encode($_SESSION['argazkia']).'"/>';

		}
	?>
</header>

<nav class='main' id='n1' role='navigation'>
	<?php
		if(isset($_SESSION['eposta'])){
			$erab = $_SESSION['erabiltzaile'];
			echo "<span><a href='Layout.php'>Hasiera</a></span>";
			//echo "<span><a href='QuestionFormWithImage.php?aux=$user'>Galdera gehitu</a></span>";
			//echo "<span><a href='ShowQuestionsWithImage.php?aux=$user'>Galderak ikusi</a></span>";
			//echo "<span><a href='ShowXmlQuestions.php?aux=$user'>Ikusi xml galderak</a></span>";
			//echo "<span><a href='ShowJsonQuestions.php?aux=$user'>Ikusi json galderak</a></span>";
			if ($erab=="irakasle" || $erab=="ikasle"){
				echo "<span><a href='HandlingQuizesAjax.php'>Kudeatu galderak</a></span>";
			
				if($erab=="irakasle"){	
					echo "<span><a href='IsVip.php'>VIPa da?</a></span>";
					echo "<span><a href='AddVip.php'>Gehitu VIPa</a></span>";
					echo "<span><a href='DeleteVip.php'>Ezabatu VIPa</a></span>";
					echo "<span><a href='ShowVips.php'>Zerrendatu VIPak</a></span>";
				}
			}else if($erab=="admin"){
				echo "<span><a href='HandlingAccounts.php'>Kudeatu kontuak</a></span>";}		
			echo '<span><a href="Credits.php">Kredituak</a></span>';
		}else{
			echo '<span><a href="Layout.php">Hasiera</a></span>';
			echo '<span><a href="Credits.php">Kredituak</a></span>';
		}
		echo '<span><a href="Play.php">Jolastera!</a></span>';

	?>
	
</nav>