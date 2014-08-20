<?php

require_once("config/db.php");
require_once("classes/Login.php");
$nombresPremios = array(
    1=>'Bocina Bluetooth',
    2=>'Audifonos MDR',
    3=>'Tarjeta de regalo $400 pesos',
    4=>'DVD SONY DVP',
    5=>'Ipod Shuffle 2GB gris',
    6=>'Tarjeta de regalo $800 pesos',
    7=>'Audífonos',
    8=>'Cargador Solar',
    9=>'Tarjeta de regalo $1200 pesos');
$login = new Login();
echo $login->isUserLoggedIn();
 print_r($_POST);
if ($login->isUserLoggedIn() == 1) {
            if(isset($_POST['regalo'])){
                
                    $regalo = $_POST['regalo'];
                    $employeeId = $_POST['employeeId'];
                    if($regalo<=3) $points = 1;
                    if($regalo>3 && $regalo<=6) $points = 2;
                    if($regalo>6 && $regalo<=9) $points = 3;

                    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    // $query = $this->db_connection->prepare('insert into store_data values(?,null,?,null,null,null,null,null)');
                    // $sql1 = "INSERT INTO store_data (store_id,month) values('$store_id','$month')";
                    // $user_data_query = $this->db_connection->query($sql1) or die('Query failed: ' . mysqli_error($user_data_query)); 
                    // points = points - $points,
                    $stmt = $db_connection->query("UPDATE employees SET  premio = $regalo, verify = 1 WHERE emp_id = '$employeeId'") or die('Query failed: ' . mysqli_error());            
                     if ($db_connection->affected_rows == 1) {
                        echo 'Regalo asignado'; 


                            $to = $_POST['email'];
                            $subject = "Tu recompensa está siendo procesada";
                            $body = "
Tu solicitud de canje ha sido enviada con éxito y está en proceso.
Muy pronto recibirás un correo de confirmación 
con los datos de entrega del artículo seleccionado.

Gracias por ser parte de Starbucks Cup Award.

“Arriesga más de lo que otros creen seguro.
Sueña más de los que otros creen útil.”
-Howard Schultz.";
                            $header = "From: Starbucks Cup Award <no-reply@starbuckscupaward.com>";
                            mail($to, $subject, $body, $header);


                     } else {
                        echo 'error';
                     }
                    // $to = "elias@dupla.mx";
                    // $subject = "Empleado $employeeId de starbucks canjeo un regalo";
                    // $body = " El empleado $employeeId escogio un ".$nombresPremios[$regalo];
                    //  if (mail($to, $subject, $body)) {   
                    //     echo("<p>Email successfully sent!</p>");  
                    // } else {   
                    //     echo("<p>Email delivery failed…</p>");  
                    // }
            // echo $mesActual;
            } else {
                echo 'error';
            }
        }
?>