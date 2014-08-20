<?php

require_once("config/db.php");
require_once("classes/Login.php");
 
$login = new Login();
if ($login->isUserLoggedIn() == true) {
    // print_r($_POST);
    $store_id = $_POST['store_id'];
    $employeeNum = $_POST['employeeNum'];
    $employeeEmail = $_POST['employeeEmail'];

    if($employeeNum != '' && is_numeric($employeeNum) && $employeeEmail != '' && filter_var($employeeEmail, FILTER_VALIDATE_EMAIL)){
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $stmt = $db_connection->query("UPDATE employees SET email ='$employeeEmail' WHERE emp_id = '$employeeNum'") or die('Query failed: ' . mysqli_error());

 
       if ($db_connection->affected_rows == 1) {
             // print_r($result_row);
             // echo json_encode(array('ok'=>'ok'));
             echo "ok";

        } else {
         echo json_encode(array('errorMsg'=> 'Lo sentimos, hubo un error.'));
        }
 
    }else{
       echo json_encode(array('errorMsg'=> 'Ingresa una dirección de email'));
    }

   }

?>