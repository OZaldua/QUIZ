<?php
session_start();
if (isset($_GET['code'])) {
	require_once 'ConfigGoogle.php';
	$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
	if(!isset($token['error'])){
		$client->setAccessToken($token['access_token']);
		$google_oauth = new Google_Service_Oauth2($client);
		$google_account_info = $google_oauth->userinfo->get();
		$email =  $google_account_info->email;
		$_SESSION['eposta']=$email;
		$_SESSION['erabiltzaile']="ikasle";
		$_SESSION["id"]= session_id();
		include 'IncreaseGlobalCounter.php'; //Erabiltzaile kautotu kopurua inkrementatzeko
		echo "<script>window.location='Layout.php' </script>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <style>
	.top10{margin: auto}
	table{margin: auto}
	th{background-color: #F2B3FF}
	tr.a1{background-color: gold}
	tr.a2{background-color: silver}
	tr.a3{background-color: #CD7F32}
  </style>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>

      <h2>Quiz: galderen jokoa</h2>
	  
    </div><br/><hr/><br/><br/><br/>
	<?php include 'top10.php' ?>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>