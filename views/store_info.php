<?php require_once("classes/StoreData.php"); ?>

<div class="logo_t_sirena"><img src="images/cup_aww.png"></div>
<div class="esq_sder">
	<!-- <div class="logo"></div> -->
  <?php 

$store_data = new StoreData();
$dataObj = $store_data->checkStoreData();
// $data = $dataObj->fetch_array();


  // print_r($dataObj); 

  
  // $mesActual = count($dataObj);
  $mesActual = 1;

    for($b=0;$b<count($dataObj);$b++){
      $semanaActual = 0;
      $semanaSum = 0;
      // echo 'mes:'.$dataObj[$b]['month'].'<br>';
      for ($i=1;$i<=5;$i++){
      $s = "week".$i;
      // echo $s.' : '.$dataObj[$b][$s].'<br>';
      if(isset($dataObj[$b][$s]) && $dataObj[$b][$s] > 0) {
        $semanaActual++;
        $semanaSum = $semanaSum + $dataObj[$b][$s];
      }
    }
  }
  $meta = ($dataObj[count($dataObj)-1]['referenceValue']*1.03);
  $semanaPerc = round(($semanaSum/$meta)*100, 2);

  $semanaTotp = ($semanaPerc < 100 ? $semanaPerc : 100); 

  $perc3 = round($semanaPerc * 0.03,2);

  if($perc3 >= 3) {
    $ley1 = "Llegaste a la meta";
    // $ley1_2 = "cumpliste la meta";
    $ley2 = "&#161;Incre&iacute;ble!";
    $ley3 = "Sigamos adelante";
  } else 
  if($perc3 > 2) {
    $ley1 = "Alcanzaste el";
    // $ley1_2 = "del %";
    $ley2 = "Est&aacute;s muy cerca";
    $ley3 = "sigue así";
  } else 
  if($perc3 > 1) {
    $ley1 = "TIENES";
    $ley2 = "&#161;Tu pasión te puede llevar aun m&aacute;s lejos!";
    $ley3 = "";
  } else 
  {
    $ley1 = "Tu porcentaje de incremento es";
    $ley2 = "&#161;Es hora de despegar!";
    $ley3 = "";
  }

  ?>  
	<div class="name">
    <!-- <a href="#" class="tooltip"> -->
    <?php echo $dataObj[0]['name']; ?> <span><?php print $userInfo->address;  ?></span>
  <!-- </a> -->
  </div>	
	<div class="date">
    MES<sub><?php print $mesActual;  ?></sub> SEMANA<sub><?php print $semanaActual;  ?></sub><br>
    <a href="index.php?logout" class="log_a">Logout</a>
  </div>	
	
</div>

<div class="content_cup">
	<div class="cup"><img src="images/cup.png"></div>
	<div class="content_percent">
		<div class="percent">  
    	</div>	

  		<div class="content_int_percent">
  			<div class="percent_info" style="bottom:<?php echo $semanaTotp ?>%">
  				<div class="p_1"><?php echo ($ley1) ?></div>
  				<div class="percent_orna">
  					<img src="images/porcentaje.png">
  					<p><?php echo $perc3 ?> %</p>
  				</div>
  				<div class="p_3"><?php echo ($ley2) ?></div>
  				<div class="p_4"><?php echo ($ley3) ?></div>	

  			</div>
  		</div>

	</div>

	<div class="meses">
		<div class="month">MES<?php print $mesActual;  ?><BR><span class="week">SEMANA <?php print $semanaActual;  ?></span></div>
	</div>
</div>

	<div class="consulta">
		<img src="images/consulta.png">
		<a href="recompensas.php"><div class="consulta_int">
			<h3>CONSULTA</h3>
			<p>LOS PREMIOS DISPONIBLES</p>
		</div></a>
	</div>

	



