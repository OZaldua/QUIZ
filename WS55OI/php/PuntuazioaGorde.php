<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
   <style>
	div{color: black}
  </style>
</head>

<body>
<?php include '../php/Menus.php';?>
<section><div>
<?php
	if(isset($_SESSION['eposta'])){
		$email = $_SESSION['eposta'];
	}else if (isset($_POST["vip_korreoa"])){
		$email = $_POST["vip_korreoa"];
	}else{
		echo "<script language='JavaScript'>alert('Errore bat gertatu da');</script>";
		header("location: Play.php");
	}
	$data = array(
		'id' => $email,
		'p' => $_POST["puntuazioa"]
	);
	$fields = (is_array($data)) ? http_build_query($data) : $data;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://sw.ikasten.io/~ozaldua006/REST/VipUsers/");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($fields)));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	echo $output;
	curl_close($ch);
?>
</div></section>
<?php include '../html/Footer.html' ?>
</body>
</html>