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
    header("Location:../?admin");
} else {
    $userInfo = $login->userInfo();
    $tipo = $userInfo->usertype;
    $id = $userInfo->id;
    if($tipo != 1){
        header("Location:../");
    } 

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta content-type="text/html" charset="utf8">
<meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="../superslide.js"></script>

<link href='http://fonts.googleapis.com/css?family=Cantata+One' rel='stylesheet' type='text/css'>
<!-- <link rel="stylesheet" type="text/css" href="../style.css"> -->

</head>
<style type="text/css">
body {
    background: #eee;
    font-family: 'Helvetica', 'Arial', Sans-serif;
    padding-bottom: 30px;
}
.tit {
    padding: 10px 0;
    /*float: left;*/
    position: fixed;
    top: 0;
    background: #fff;
    width: 100%;
    left: 0;
    border-bottom: 1px solid;
}
.content {
    /*margin-top: 70px;*/
}
form {
    /*text-align: right;*/
}
a {
    text-decoration: none;
    color: #666;
    float: right;
}  
input {
    -webkit-border-radius : ;
}

</style>
<body>
    <div class="wrapper">
        <a href="/dashboard">Dasboard</a>
<!-- <div class="fondo">
    <div class="superSlide">
    <img src="../images/fondo.jpg">
    </div>
  </div> -->
        <div class="content">

<?php
if ($login->isUserLoggedIn() == true) {
    if($tipo = 1) {
        include 'massive.php';
    }     
}
?>


        </div>
    </div>
<div class="loader"></div>



</body>
</html>