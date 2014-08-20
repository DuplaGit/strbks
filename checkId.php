<?php

require_once("config/db.php");
require_once("classes/Login.php");
 
$login = new Login();
if ($login->isUserLoggedIn() == true) {
    // print_r($_POST);
    $store_id = $_POST['store_id'];
    $employeeNum = $_POST['employeeNum'];

    if($employeeNum != '' && is_numeric($employeeNum) ){
    $sql = "SELECT * FROM employees WHERE store_id = $store_id AND emp_id = $employeeNum";
    // echo $sql;
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $employee_data = $db_connection->query($sql) or die('Query failed: ' . mysqli_error());
      
 
       if ($employee_data->num_rows == 1) {
        $result_row = $employee_data->fetch_array(MYSQLI_ASSOC);

             // print_r($result_row);
             echo json_encode(array('points'=>$result_row['points'],'verify'=>$result_row['verify'],'employeeId'=>$employeeNum,'email'=>$result_row['email'] ));

        } else {
         echo json_encode(array('errorMsg'=> 'Lo sentimos, no fue correcto tu numero de empleado'));
        }
 
    }else{
       echo json_encode(array('errorMsg'=> 'Ingresa un número de empleado'));
    }
   }

?>