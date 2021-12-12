<!DOCTYPE html>
<?php
session_start();
$id=session_id();
if(!isset($_SESSION['eposta'])){
    header("location: LogIn.php");
}else if($_SESSION["id"]!=$id){
    header("location: Layout.php");
}else if($_SESSION['erabiltzaile']!='irakasle'){
    header("location: Layout.php");
}
?>
<html>
<head>
  <?php include '../html/Head.html'?>
</head>

<body>
<?php include '../php/Menus.php' ?>
<section class="main" id="s1">
    <div style="text-align: center">
        <form id="deleteVip" name="deleteVIP" action="DeleteVip.php" method="post">
           <fieldset>
             <legend align="center">VIP erabiltzailea ezabatzeko REST bezeroa:</legend>
                Email*: <input type="text" id="eposta" name="eposta">
                <input type="submit" value="VIPa ezabatu" id="vip" name="vip"><br>
            </fieldset>
        </form>
    </div>    
<?php
if(isset($_POST["eposta"])){
    if(!empty($_POST["eposta"])){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://sw.ikasten.io/~ozaldua006/REST/VipUsers/".$_POST["eposta"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $output = curl_exec($ch);
        echo $output;
        curl_close($ch);
    }else 
        echo "Bete hutsuneak";
}
?>
</section>
<?php include '../html/Footer.html' ?>
</body>
</html>