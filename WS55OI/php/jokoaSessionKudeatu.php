<?php
session_start();

if($_POST['zuzen'] == "true"){
	$_SESSION['zuzenKop'] = $_SESSION['zuzenKop'] + 1;
	$_SESSION[$_POST['gaia'].'ZuzenKop'] = $_SESSION[$_POST['gaia'].'ZuzenKop'] + 1;
	echo "OSO ONDO!";
}else {
	$_SESSION['gaizkiKop'] = $_SESSION['gaizkiKop'] + 1;
	$_SESSION[$_POST['gaia'].'OkerKop'] = $_SESSION[$_POST['gaia'].'OkerKop'] + 1;
	echo "GAIZKI!";
}
array_shift($_SESSION[$_POST['gaia']]);
?>