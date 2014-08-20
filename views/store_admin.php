<?php require_once("classes/StoreData.php"); ?>
<?php $store_data = new StoreData();
if(isset($_POST['action']) && $_POST['action']=='insertMonth'){
  // print_r($_POST);
  if(isset($_POST['store_id']) && isset($_POST['lastmonth'])){
    $store_data->addMonthStoreData() ;
    echo "insertMonth";
  }
} if(isset($_POST['action']) && $_POST['action']=='newMonth'){
    // print_r($_POST);
  if(isset($_POST['store_id']) && isset($_POST['month'])){
    $store_data->saveNewMonth() ;
    echo "insertMonth";
  }
} 

if(isset($_POST['action']) && $_POST['action']=='editVal'){
     // print_r($_POST);
  if(isset($_POST['store_id']) && isset($_POST['month'])){
    $store_data->editVal() ;
    echo "edit Value";
  }
} 
?>
<!-- <img src="sirena.png" class="sirena"> -->
<!-- <script src="jquery.jeditable.js" type="text/javascript" charset="utf-8"></script> -->
<script type="text/javascript">
$(document).ready(function(){
   $('form[name="aStore"]').submit(function(evento){
      evento.preventDefault();
     var thisRow = $(this);
       // alert("thisRow: "+thisRow);
     
      var datastring = $(this).serialize();
      $.ajax({
            type: "POST",
            url: "addMonth.php",
            data: datastring,
            success: function(data) {
                 // alert('Data send');
                 thisRow.before(data);
            }
        });

   });

//  $(document).ready(function() {
//      $('.percentInput').editable('editVal.php', {
//    submitdata : {month: $(this).data("month"),week: $(this).data("week"),storeid: $(this).data("storeid")}
// });
  $('.deleteBot').click(function(){
    thisId = $(this).data('id');
    confirm('Borrar mes?');
     $.post("deleteMonth.php", {thisId: thisId}, function(data){
         // alert("Fila eliminada: "+data);
         location.reload();
      });
  });

  $('#box').keyup(function(){
   var valThis = $(this).val().toLowerCase();
    $('.aRow').each(function(){
     var text = $(this).find('.storeName').text().toLowerCase();
     // console.log(text +' + '+text.indexOf(valThis));
        (text.indexOf(valThis) >= 0) ? $(this).show() : $(this).hide();            
     });
  });


  /// END JS
 });
</script>
<a href="dashboard">Dashboard</a>
<span style="clear:both;"></span>
<div class="aTable">
 <?php  $store_data->editAllStoresData(); 
 //$store_data->initAllStores();?>
</div>
<div id="destino"></div>
<input class="log-out" placeholder="Search Me" id="box" type="text" /> <a class="log-out" href="index.php?logout">Logout</a>
