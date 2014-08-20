<?php

/**
 * For more versions (one-file, advanced, framework-like) visit http://www.php-login.net
 * @author Panique
 * @link https://github.com/panique/php-login-minimal/
 * @license http://opensource.org/licenses/MIT MIT License
 */

if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("../libraries/password_compatibility_library.php");
}

require_once("../config/db.php");
require_once("../classes/Login.php");
$login = new Login();
if ($login->isUserLoggedIn() == false) {
    header("Location:../?dashboard");
} else {
    $userInfo = $login->userInfo();
    $tipo = $userInfo->usertype;
    $id = $userInfo->id;

    // if($tipo == 1) {
    //     header("Location:../");
    // }

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta content-type="text/html" charset="utf8">
<meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="../superslide.js"></script>

<link href='http://fonts.googleapis.com/css?family=Cantata+One' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="../style.css">

</head>
<style type="text/css">
body {
    background: #eee;
    font-family: 'Helvetica', 'Arial', Sans-serif;
    padding-bottom: 30px;
}
.tit {
padding: 10px 0;
position: fixed;
top: 0;
background: #F1EFEA;
width: 98%;
left: 0;
border-bottom: 1px solid;
padding-left: 1%;
padding-right: 1%;
}
.content {
    margin-top: 70px;
}
form {
    text-align: right;
}
a {
    text-decoration: none;
    color: #666;
    float: right;
    margin: 0 10px;
}
select {
width: 220px;
padding: 0px 10px;
margin: 10px;
height: 30px;
background: #F1EFEA;
border: 1px dotted #38212c;
}
input {
    width: 70px;
    height: 30px;
    margin: 0;
}

input[type="submit"]{
    width: 69px;
    color: #fff;
    height: 31px;
    background-image: url(../images/buscardr.png);
    background-repeat: no-repeat;
    background-color: transparent;
    border: none;
    padding-left: 2px;
}

table {
    /*border: 1px solid #fcfcfc;*/
    margin: 10px 0;
    /*background: #fcfcfc;*/
    width: 100%;
    margin-bottom: 40px;
}
td {
    padding: 5px;
    border: 1px solid #ccc;
    background: #fff;
    font-size: 1.2em;
}
.head td {
    background: #38212c;
    color: #fff;
}
.mes td {
    background: #38212c;
    color: #fff;
}

.semana td {
    background: transparent;
    color: #054d41;
    font-family: 'Cantata One', serif;

}

.cuptable{
    position: relative;
top: 0;
left: 0;
float: left;
clear: both;
height: 160px;
}

.cuptable img{}

</style>
<body>
    <div class="wrapper">
<div class="fondo">
    <div class="superSlide">
    <img src="../images/fondo.jpg">
    </div>
  </div>
        <div class="content">
<div class="cuptable"><img src="../images/cuptable.png"></div>
<?php
    if($_GET['proc'] == "done") {
        echo "<script>alert('update')</script>";
    }
    include 'dashboard.php'; 
?>


        </div>
    </div>
<div class="loader"></div>



</body>
</html>

<?
}