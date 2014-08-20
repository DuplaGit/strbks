<?php require_once("classes/StoreData.php"); ?>
<?php 

$store_data = new StoreData();
$dataObj = $store_data->checkStoreData();
$data= $dataObj->fetch_array();
$monthNum = $dataObj->num_rows;
$weekNum = 0;
for($i=0;$i<=5;$i++){
  if($data['week'.$i] != 0) $weekNum++;
}
?>

<div class="logo_t_sirena"><img src="images/cup_aww.png"></div>
<div class="esq_sder">
	<div class="logo"></div>
	<div class="name"><a href="#" class="tooltip"><?php print $userInfo->name; ?> <span><?php print $userInfo->address;  ?></span></a></div>	
	<div class="date">MES<?php print $monthNum;  ?>SEMANA <?php print $weekNum;  ?></div>	
	<a href="index.php?logout">Logout</a>
</div>

<div class="content_cup">
	<div class="cup"><img src="images/cup.png"></div>
	<div class="content_percent">
		<div class="percent">  
  <?php $goal = $data['referenceValue']+$data['referenceValue']*0.03; ?>
  Meta: $<?php echo money_format('%n',$goal); ?>

  Logrado: $<?php echo round($data['week1']+$data['week2']+$data['week3']+$data['week4']+$data['week5']); ?> <?php  $porcentaje = round((($data['week1']+$data['week2']+$data['week3']+$data['week4']+$data['week5'])/ $goal*100),2); ?><br>
  <?php echo $porcentaje; ?>%  (meta = <?php echo $porcentaje*0.03; ?>%)    </div>	
	</div>

	<div class="meses">
		<div class="month">MES<?php print $monthNum;  ?><BR><span class="week">SEMANA <?php print $weekNum;  ?></span></div>
	</div>
</div>

	

	



