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
    } else {
        // echo 'Cambios masivos<br>';
        echo '<form method="POST" action="procMass.php">';
        echo '<input type="submit" value="Set"><br><br>';
        echo '
            <input type="radio" name="mes" value="1" required>Agosto<br>
            <input type="radio" name="mes" value="2">Septiembre<br>
            <input type="radio" name="mes" value="3">Octubre<br>
            <br>
            <input type="radio" name="semana" value="referenceValue" required>Referente Total Cuotas<br>
            <input type="radio" name="semana" value="week1">semana 1<br>
            <input type="radio" name="semana" value="week2">semana 2<br>
            <input type="radio" name="semana" value="week3">semana 3<br>
            <input type="radio" name="semana" value="week4">semana 4<br>
            <input type="radio" name="semana" value="week5">semana 5<br>';
        echo '<br>id tienda,valor (ej: 38101;1,245,000)<br>';
        echo '<textarea rows="40" cols="50" name="data" required></textarea><br>';

        echo '</form>';
    }

}


