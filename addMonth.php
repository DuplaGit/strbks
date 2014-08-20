<?php require_once("classes/StoreData.php"); ?>
<?php 
 // print_r($_POST); 
// if(isset($_POST['store_id']) && isset($_POST['lastmonth'])){ 
// addMonthStoreData($_POST['store_id'],$_POST['lastmonth']) ;
  $month = $_POST['lastmonth']+1; ?>
  
<form name="aWeek" method="post">
             
                        
                            <!-- <div> -->
                              <div class="monthName">Mes <?php  echo $month;  ?> Referencia del año pasado: <input name="referenceValue" value="10000" class="referenceValue"></div>
                                <input name="percent1" value="0" class="percentInput">+
                                <input name="percent2" value="0" class="percentInput">+
                                <input name="percent3" value="0" class="percentInput">+
                                <input name="percent4" value="0" class="percentInput">+
                                <input name="percent5" value="0" class="percentInput">
                            <!-- </div> -->
                            <input type="hidden" name="store_id" value="<?php echo $_POST['store_id']; ?>">
                            <input type="hidden" name="month" value="<?php echo $_POST['lastmonth']+1; ?>">
                            <input type="hidden" name="action" value="newMonth">
                            = 0 X 1000 / 100 = %
                            <input type="submit" name="cambiar" value="Modificar">
                           
                    </form>
<?PHP
// }
?>