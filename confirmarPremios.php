<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(ALL);
require_once("config/db.php");
require_once("classes/Login.php"); 
 $login = new Login();
// echo 'user_login_status:'.$_SESSION['user_login_status'].'->'.$login->isUserLoggedIn();
if ($login->isUserLoggedIn() == true) {
    $userInfo = $login->userInfo();
    if($userInfo->usertype==1){
        //include("views/store_admin.php");
        $isadmin = true;
    }else {
         //  if($userInfo->usertype==0)
        // include("views/store_info.php");
        // echo 'No eres administrador';
        header('Location: ./');
    }
} else {
    // include("views/log_in.php");
    header('Location: index.php');
    die();
}



?>
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
        <a href="./dashboard">dashboard</a><br>
    <?php
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
 
     if(isset($_POST['action']) && $_POST['action']=='procesar'){
        echo '<br>Procesando pedidos:<br><br>';
        // echo $_POST['emp_id'];
        if(isset($_POST['empId']) && !$_SESSION['done']){
                 // print_r($_POST);
                   foreach($_POST['empId'] as $empId){
    
                     echo $_POST[$empId]; // EL ID DEL REGALO
               
                     if(isset($_POST[$empId])){
                            $regalo = $_POST[$empId];
                            if($regalo<=3) $points = 1;
                            if($regalo>3 && $regalo<=6) $points = 2;
                            if($regalo>6 && $regalo<=9) $points = 3;
                          
                          $employeeId = $empId;

                         $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                         $stmt = $db_connection->query("UPDATE employees SET points = points - $points,  premio = NULL, verify = NULL WHERE emp_id = '$employeeId' AND points > 0") or die('Query failed: ' . mysqli_error());            
                         if ($db_connection->affected_rows == 1) {
                            echo 'Premio enviado a id='.$employeeId.', '.$_POST['email'].'.<br>'; 

                            $to = $_POST['email'];
                            $subject = "Tu recompensa ha sido enviada";
                            $body = "
Tu solicitud ha sido aceptada.
Recompensa: ".$nombresPremios[$regalo]."
Forma de entrega de tu recompensa: En tienda.

Tu recompensa llegará por paquetería
en los próximos 20 días hábiles.

Gracias por ser parte de Starbucks Cup Award.

“Arriesga más de lo que otros creen seguro.
Sueña más de los que otros creen útil.”
-Howard Schultz. ";
                            $header = "From: Starbucks Cup Award <no-reply@starbuckscupaward.com>";
                             if (mail($to, $subject, $body, $header)) {   
                                echo("<p>Correo enviado al empleado</p>");  
                            } else {   
                                echo("<p>Envio de correo fallido…</p>");  
                            }

                            $_SESSION['done'] = true;



                         }
                     }
                    }
        
             }  
    } else {
        echo '<br>Selecciona los pedidos para procesar:';
    }
    ?>
    <hr>
    <!-- empieza regalos -->
    <form method="POST" action="" id="canjearForm">
    <input type="hidden" name="action" value="procesar">
    <?php
     // if($isadmin){

         $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         $sql1 = "SELECT * FROM employees WHERE verify > 0";//LIMIT 10";
         $user_data_query = $db_connection->query($sql1) or die('Query failed: ' . mysqli_error($user_data_query)); 

         // print_r($user_data_query);
         foreach($user_data_query as $user_data){ 
            // print_r($user_data);
            echo $user_data['email'];
            echo ' - id: #';
            echo $user_data['emp_id'];
            echo '<br>';
            echo $nombresPremios[$user_data['premio']];
 
            echo '<input type="checkbox" name="empId[]" value="'.$user_data['emp_id'].'">';
            // echo '<input type="hidden" name="emp_id" value="'.$user_data['emp_id'].'">';
            echo '<input type="hidden" name="'.$user_data['emp_id'].'" value="'.$user_data['premio'].'">';
            echo '<input type="hidden" name="email" value="'.$user_data['email'].'">';
            echo '<hr>';
         }
    // } else { 
    //     echo 'No eres admin';
    // }
    ?>
    <input type="submit">
    </form>


    <!-- termina regalos -->


    </div>
</div>




<div class="loader"></div>



</body>
</html>
<?php
// } else {
//     header("Location:index.php");
// }
?>