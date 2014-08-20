<?php

if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

require_once("config/db.php");
require_once("classes/Login.php");
$login = new Login();?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta content-type="text/html" charset="utf8">
<meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="superslide.js"></script>

<link href='http://fonts.googleapis.com/css?family=Cantata+One' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <div class="wrapper">
<div class="fondo">
    <div class="superSlide">
    <img src="images/fondo.jpg">
    </div>
  </div>
        <div class="content">

<?php
// echo 'user_login_status:'.$_SESSION['user_login_status'].'->'.$login->isUserLoggedIn();
if ($login->isUserLoggedIn() == true) {
    $userInfo = $login->userInfo();
    if($userInfo->usertype==1){
        include("views/store_admin.php");
    }else {
         //  if($userInfo->usertype==0)
        include("views/store_info.php");
    }
} else {
    include("views/log_in.php");
}
?>


        </div>
    </div>
<div class="loader"></div>



</body>
</html>