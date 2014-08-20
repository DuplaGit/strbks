<?php
require_once("config/db.php");
function deleteMonth($thisId)
    {

        if (isset($thisId)) {
           
		ECHO 'IN';
		$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
           try {
 			    // delete query
			    // $query = "DELETE FROM users WHERE id = ?";
           		$sql = "DELETE FROM store_data WHERE id = ?";
			    $stmt = $con->prepare($sql);
			    $stmt->bind_param('i', $thisId);
			     
			    if($result = $stmt->execute()){
			        // redirect to index page
			        echo ('action=deleted'+$thisId);
			    }else{
			        die('Unable to delete record.');
			    }
			}
			 
			// to handle error
			catch(PDOException $exception){
			    echo "Error: " . $exception->getMessage();
			}


           
             
 
               
                 
        }
        // default return
        return false;
    }   ?>
<?php // print_r($_POST); 
if(isset($_POST['thisId'])){
	deleteMonth($_POST['thisId']) ;

}
?>