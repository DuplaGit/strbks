<?php

/**
 * Class StoreData
 * handles the user's login and logout process
 */
class StoreData
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {

    }

     /**+++++++++++++++++++++++++++++++++
     * checkStoreData for Admin
     * @return all
     */
    public function initAllStores()
    {
        if (isset($_SESSION['user_id'])) {
            // return true;
            // echo 'loggedIn';
            $user_id = $_SESSION['user_id'];
             $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
              $sql = "SELECT * FROM stores ORDER BY id ASC";
                $store_data = $this->db_connection->query($sql) or die('Query failed: ' . mysqli_error());
                 $datarow = $store_data->fetch_array();
                 // echo '<pre>';
                 // print ($store_data->num_rows);
                foreach($store_data as $data){
                   // print '<pre>';
                         // print_r($data);
                         $id = $data['code'];
           
                         // for($i=1;$i<=3;$i++){

                            $query = $this->db_connection->prepare('insert into store_data values(?,null,?,null,null,null,null,null)');
                            $sql2 = "INSERT INTO store_data (store_id,month,referenceValue,week1,week2,week3,week4,week5) values('$id','1','10000','0','0','0','0','0')";
                            $user_data_query = $this->db_connection->query($sql2) or die('Query failed: ' . mysqli_error($user_data_query)); 
                        // return $sql1.' - '.$user_data_query ;
                            // echo $sql2;
                          // }
                }   
                 
        }
        // default return
        return false;
    } 


    /**
     * checkStoreData for Admin
     * @return all
     */
    public function checkStoreData()
    {
        if (isset($_SESSION['user_id'])) {
            // return true;
            // echo 'loggedIn';
            $user_id = $_SESSION['user_id'];
            // echo $user_id;
             $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
              $sql = "SELECT * FROM store_data, stores WHERE store_data.store_id = $user_id AND stores.code = $user_id AND month = 1";//." ORDER BY id DESC LIMIT 1";
                $store_data = $this->db_connection->query($sql) or die('Query failed: ' . mysqli_error());
                   // $datarow = $store_data->fetch_array(MYSQLI_ASSOC);
                 $data_array = array();
                 while($row = $store_data->fetch_array(MYSQLI_ASSOC))
                    {
                    // echo '<pre>';
                    // var_dump($row);
                     $data_array[] = $row;
                    }

                // }   
                    return $data_array;
        }
        // default return
        return false;
    }   

     /**
     * checkStoreData for Admin
     * @return all
     */
    public function initTestEmployees()
    {
        if (isset($_SESSION['user_id'])) {
            // return true;
            // echo 'loggedIn';
            $user_id = $_SESSION['user_id'];
            // echo $user_id;
             $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
              $sql = "SELECT * FROM  stores ORDER BY id ASC";
                $store_data = $this->db_connection->query($sql) or die('Query failed: ' . mysqli_error());
                   // $datarow = $store_data->fetch_array(MYSQLI_ASSOC);
                // $data_array = array();
                 $i = 0;
                  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                   

                 while($row = $store_data->fetch_array(MYSQLI_ASSOC)){
                    $store_id = $row['code'];
                    for($b=1;$b<3;$b++){
                        $i++;
                            $randomString = '';
                            for ($c = 0; $c < 5; $c++) {
                                $randomString .= $characters[rand(0, strlen($characters) - 1)];
                            }
                            $verify = $randomString;
                       
                        $sql1 = "INSERT INTO employees (email,store_id,points,verify) values('empolyee$i','$store_id','0','$verify')";
                        $user_data_query = $this->db_connection->query($sql1) or die('Query failed: ' . mysqli_error($user_data_query)); 
                       
                    // echo '<pre>';
                    // var_dump($row);
                    // $data_array[] = $row;
                     }
                    }

                // }   
                    // return $data_array;
        }
        // default return
        return false;
     
 
}  
     /**
     * deleteMonth for Admin
     * @return all
     */
    public function deleteMonth($thisId)
    {
        if (isset($_SESSION['user_id']) && isset($thisId)) {
            // return true;
            // echo 'loggedIn';
            $user_id = $_SESSION['user_id'];
             $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
              $sql = "DELETE FROM store_data WHERE id = $thisId";
              $store_data = $this->db_connection->query($sql) or die('Query failed: ' . mysqli_error());
               
                 
        }
        // default return
        return false;
    }   

    /**
     * checkPercentData for Admin
     * @return all
     */
    // public function checkPercentData()
    // {
    //     if (isset($_SESSION['user_id'])) {
    //         // return true;
    //         // echo 'loggedIn';
    //         $user_id = $_SESSION['user_id'];
    //          $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    //           $sql = "SELECT * FROM store_data WHERE store_id = 3  order by week desc limit 1;";//    . $user_id;
    //             $store_data = $this->db_connection->query($sql) or die('Query failed: ' . mysqli_error());
    //             foreach($store_data as $data){
    //              // print '<pre>';
    //              return '3 - '.$data['percent'].' = '. (3-$data['percent']);
    //              // print '<br>';
    //             }    
    //             // return $store_data;
    //     }
    //     // default return
    //     // return false;
    // }

    /**
     * Edit Store Data
     * @return form
     */
    public function editStoreData()
    {
        if (isset($_SESSION['user_id'])) {
            // return true;
            echo 'loggedIn';
            $user_id = $_SESSION['user_id'];
             $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
              $sql = "SELECT * FROM store_data WHERE store_id = " . $user_id;
                $store_data = $this->db_connection->query($sql) or die('Query failed: ' . mysqli_error());
              
                foreach($store_data as $data){ ?>
               
                <!-- <form class="aStore" method="POST"> -->
                    <input name="storeId" type="hidden" value="<?php echo $data['storeId']; ?>"></input>
                        <div class="float_left">
                            Semana <?php echo $data['week']; ?>:<br> <br> 
                        </div>
                        <div class="float_left">
                            Porcentaje:<br> 
                            <input name="percent" value="<?php echo $data['percent']; ?>" class="percentInput"></input><br><br>
                        </div>
                        <!-- <input class="modificar_btn" type="submit"  name="cambiar" value="Modificar" /> -->
                <!-- </form> -->
                <hr>
                <?php } ?>

                <?php
                // return $store_data;
        }
        // default return
        return false;
    }


    /**
     * Edit All Stores Data
     * @return form
     */
    public function editAllStoresData()
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
            // return true; ?>

            <div class="firstRow">
                 <div class="aWeek">Tiendas:</div>
            <?php
            

            // for($i = 1; $i<10; $i++){
            ?>
            <!-- <div class="aWeek">Semana <?php echo "string"; $i; ?></div> -->
            <?php
            // } ?>
            <hr>
         </div>
            <?php
            $user_id = $_SESSION['user_id'];
             $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
             $this->db_connection->set_charset("utf8");
              $sql1 = "SELECT * FROM stores";
                $store_data_query = $this->db_connection->query($sql1) or die('Query failed: ' . mysqli_error()); 
                setlocale(LC_ALL,"es_ES");
               foreach($store_data_query as $store_data){ 
                $code = $store_data['code'];
               ?>
                   <div class="aRow">
                 
                  <div class="storeName"> <?php echo  $store_data['name']; ?> - <?php echo  $store_data['code']; ?></div>
                   
                   <?php  $sql2 = "SELECT * FROM store_data WHERE store_id = ".$store_data['code'];
                    $store_data = $this->db_connection->query($sql2) or die('Query failed: ' . mysqli_error());
                    $num_rows = $store_data->num_rows;  
                    $i = 0;
                    foreach($store_data as $data){ 
                      $i++;
                      $status = $data['status'];
                      
                         ?>
                  <form name="aMonth"  class="aWeek <?php echo $succes; ?>" method="post">
             
                        
                            <!-- <div> -->
                              <div class="monthName">
                                <?php 
                                
                                // $monthName = $dateObj->format('F'); // March
                                echo 'mes'. $data['month'];//date("F",mktime(0,0,0,$data['month'],1,2011));  ?> Referencia del año pasado: $<?php echo number_format($data['referenceValue']); ?> Modificar:<input name="referenceValue" value="<?php echo $data['referenceValue']; ?>" class="referenceValue">
                            </div>
                                <input name="percent1" value="<?php echo $data['week1']; ?>" class="percentInput"></input>+
                                <input name="percent2" value="<?php echo $data['week2']; ?>" class="percentInput"></input>+
                                <input name="percent3" value="<?php echo $data['week3']; ?>" class="percentInput"></input>+
                                <input name="percent4" value="<?php echo $data['week4']; ?>" class="percentInput"></input>+
                                <input name="percent5" value="<?php echo $data['week5']; ?>" class="percentInput"></input>
                            <!-- </div> -->
                           
                            = <?php echo number_format ($data['week1']+$data['week2']+$data['week3']+$data['week4']+$data['week5']); ?> /  <?php $goal = $data['referenceValue']+($data['referenceValue']*0.03); 
                            echo number_format($goal); ?>  X 100</input>    = 
                            <?php  $porcentaje = round((($data['week1']+$data['week2']+$data['week3']+$data['week4']+$data['week5'])/ $goal*100),2); ?>
                            <?php echo $succes  = ($status == 1) ? '<span class="success">' : ''; ?>
                            <?php echo $porcentaje; ?>%  (meta = <?php echo $porcentaje*0.03; ?>%)    
                            <?php echo $succes  = ($status == 1) ? '</span>' : ''; ?>
                            <input type="hidden" name="store_id" value="<?php echo $data['store_id']; ?>">
                            <input type="hidden" name="month" value="<?php echo $data['month']; ?>">
                            <input type="hidden" name="action" value="editVal">
                            <input class="modificar_btn"  type="submit"  name="Submit" value="Modificar" />
                           <?php if($i > 1 && $i == $num_rows) { ?> <input type="button"  name="borrar" value="Borrrar" class="deleteBot" data-id="<?php echo $data['id']; ?>" /> <?php } 
                           ?>
                    </form>    
                    
                 <?php
                 $lastMonth = $data['month'];
                  } ?>
                   <?php if($lastMonth<3){ ?>
               <form name="aStore">
                <input type="hidden" name="store_id" value="<?php echo $code ?>">
                <input type="hidden" name="lastmonth" value="<?php echo $lastMonth; ?>">
               
               
                  <input type="hidden" name="action" value="insertMonth">
                <input class="newMonthBot" type="submit" value="new month">
                </form>
                <?php } ?>
                <hr>
                </div>
                
                <?php } ?>

                <?php
                // return $store_data;
        }
        // default return
        return false;
    }
 /////////////////////////////////////////
    public  function addMonthStoreData()
    {
            $store_id = $_POST['store_id'];
            if($_POST['lastmonth']!= 0){
                $month = $_POST['lastmonth']+1;
            }else{
                 $month =date('n');
            }
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            // $query = $this->db_connection->prepare('insert into store_data values(?,null,?,null,null,null,null,null)');
            $sql1 = "INSERT INTO store_data (store_id,month) values('$store_id','$month')";
            $user_data_query = $this->db_connection->query($sql1) or die('Query failed: ' . mysqli_error($user_data_query)); 
            return $sql1.' - '.$user_data_query ;

    }
 /////////////////////////////////////////
    public  function saveNewMonth()
    {
          
            if($_POST['month'] && $_POST['store_id']){
            $store_id = $_POST['store_id'];
            $month = $_POST['month'];
            $week1 = $_POST['percent1'];
            $week2 = $_POST['percent2'];
            $week3 = $_POST['percent3'];
            $week4 = $_POST['percent4'];
            $week5 = $_POST['percent5'];
            $referenceValue = $_POST['referenceValue'];
                $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                // $query = $this->db_connection->prepare('insert into store_data values(?,null,?,null,null,null,null,null)');
                $sql1 = "INSERT INTO store_data (store_id,month,referenceValue,week1,week2,week3,week4,week5) values('$store_id','$month','$referenceValue','$week1','$week2','$week3','$week4','$week5')";
                $user_data_query = $this->db_connection->query($sql1) or die('Query failed: ' . mysqli_error($user_data_query)); 
                return $sql1.' - '.$user_data_query ;
            }

    }

/////////////////////////////////////////
    public  function editVal()
    {
            $store_id = $_POST['store_id'];
            $percent1 = $_POST['percent1'];
            $percent2 =  $_POST['percent2'];
            $percent3 =  $_POST['percent3'];
            $percent4 =  $_POST['percent4'];
            $percent5 =  $_POST['percent5'];
            $referenceValue = $_POST['referenceValue'];
            $referenceValue2 = str_replace( ',', '', $referenceValue );

            if( is_numeric( $referenceValue2 ) ) {
                $referenceValue = $referenceValue2;
            }


            $month =  $_POST['month'] ;

            // if($_POST['lastmonth']!= 0){
            //     $month = $_POST['lastmonth']+1;
            // }else{
            //      $month =date('n');
            // }
            // print_r($_POST);
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            // $query = $this->db_connection->prepare('insert into store_data values(?,null,?,null,null,null,null,null)');
            // $sql1 = "INSERT INTO store_data (store_id,month) values('$store_id','$month')";
            // $user_data_query = $this->db_connection->query($sql1) or die('Query failed: ' . mysqli_error($user_data_query)); 

            $stmt = $this->db_connection->query("UPDATE store_data SET week1 ='$percent1', week2 ='$percent2', week3 = '$percent3', week4 = '$percent4', week5 = '$percent5', referenceValue = '$referenceValue' WHERE store_id = '$store_id' AND month ='$month'");
           
           $totalVal = $percent1 + $percent2 + $percent3 + $percent4 + $percent5;
           $goal  = $referenceValue+($referenceValue*0.03); 
           if($totalVal >= $goal){
            $stmt = $this->db_connection->query("UPDATE store_data SET status = '1' WHERE store_id = '$store_id' AND month ='$month'");
            $stmt = $this->db_connection->query("UPDATE employees SET points = points + 1 WHERE store_id = '$store_id'");         
           } else {
            $stmt = $this->db_connection->query("UPDATE store_data SET status = '0' WHERE store_id = '$store_id' AND month ='$month'");
            $stmt = $this->db_connection->query("UPDATE employees SET points = points - 1 WHERE store_id = '$store_id'");          
           }

           if($stmt){
                return 'Success! record updated'; 
            }else{
                return 'Error : ('. $this->db_connection->errno .') '. $this->db_connection->error;
            }

            // return $sql1.' - '.$user_data_query ;

    }

}
