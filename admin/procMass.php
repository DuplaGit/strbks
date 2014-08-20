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

// print_r($query);
$sem = $_POST['semana'];
$mes = $_POST['mes'];
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($login->isUserLoggedIn() == false) {
    header("Location:../?admin");
} else {
    $userInfo = $login->userInfo();
    $tipo = $userInfo->usertype;
    $id = $userInfo->id;
    if($tipo != 1){
        header("Location:../");
    } else {
        // print_r($_POST);
        $query = array();
        $queryU = array();

        $data = explode(PHP_EOL, $_POST['data']);
        // print_r($data);
        foreach ($data as $k => $val) {
            $v = explode(';', $val);
            $sql = "SELECT store_id FROM store_data WHERE store_id = '$val' AND month = '$mes'";
            $user_data_query = $db_connection->query($sql) or die('die'); 
            if($user_data_query) {
                // echo $v[0];
                // print_r($user_data_query);
                if($user_data_query->num_rows == 1) {
                    // echo 'find'.PHP_EOL;
                    $queryU[$v[0]] = $v[1]; 
                } else {
                    // echo 'not'.PHP_EOL;
                    $query[$v[0]] = $v[1]; 
                }
            } 
            // echo $user_data_query;
            # code...
        }
    }

    // echo $query;
    // 
    $done = "";
    if(count($query) > 0) { 
        $sql1 = "INSERT INTO `store_data` (`store_id`,`month`,`$sem`) VALUES ";
        $i = 0;
        foreach ($query as $k => $val) {
            $val = preg_replace('/,/', '', $val);
            $sql1 .= "('$k', '$mes', '$val')";
            $i++;
            if(count($query) > $i) {
                $sql1 .= ",";
            } else { 
                $sql1 .= ";";
            }
            // echo 'set'.PHP_EOL;
            # code...
        }

        // echo $sql1;
        $user_data_query = $db_connection->query($sql1) or die('Query failed: ' . mysqli_error($user_data_query)); 
        $done .= "set ";
    }

    if(count($queryU) > 0) { 
        foreach ($queryU as $k => $val) {

            $sql1 = "UPDATE store_data SET $sem = ";
            $val = preg_replace('/,/', '', $val);
            $sql1 .= "'$val' ";
            $sql1 .= "WHERE store_id = '$k' AND month = '$mes'";
            $user_data_query = $db_connection->query($sql1) or die('Query failed: ' . mysqli_error($user_data_query)); 
            // echo 'update'.PHP_EOL;
            $done .= "update ";
            # code...
        }
    }



header('Location: /dashboard?proc=done');

}

