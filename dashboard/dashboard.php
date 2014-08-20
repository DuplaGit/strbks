<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');


$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$db_connection->set_charset("utf8");


$DM_Opt = array();
$DR_Opt = array();

$sql_f = "SELECT * FROM users";
// $DM_Opt[$val[3]] = $DM[0];
// $DR_Opt[$val[4]] = $DR[0]; 

$store_data_query = $db_connection->query($sql_f) or die('Query failed: ' . mysqli_error()); 
// setlocale(LC_ALL,"es_MX");
foreach($store_data_query as $store_data){ 
	if($store_data['usertype'] == 2) {
		$DM_Opt[$store_data['id']] = $store_data['name'];
	}
	if($store_data['usertype'] == 3) {
		$DR_Opt[$store_data['id']] = $store_data['name'];
	}
}

    
$DM_ID = '';
$DR_ID = '';
$tienda_ID = '';
$formas = "";

if($tipo == 1 || $tipo == 4 ) {
	if($tipo == 1){
    echo '<div class="tit">Dashboard Admin<div><a href="../?logout&dashboard">log out </a><a href="/">Admin Simple</a><a href="/admin">Admin Masivo</a> <a href="/confirmarPremios.php">Pedidos</a> </div></div>';
	} else 
    echo '<div class="tit">Dashboard Nacional<div><a href="../?logout&dashboard">log out</a></div></div>';
    if(isset($_GET['DM']) && $_GET['DM'] != 0) {
    	$DM_ID = $_GET['DM'];
		$sql1 = "SELECT * FROM stores WHERE DM = $DM_ID";
    } else if(isset($_GET['DR']) && $_GET['DR'] != 0) {
    	$DR_ID = $_GET['DR'];
		$sql1 = "SELECT * FROM stores WHERE DR = $DR_ID";
    } else if(isset($_GET['Tienda']) && $_GET['Tienda'] != 0) {
    	$tienda_ID = $_GET['Tienda'];
		$sql1 = "SELECT * FROM stores WHERE code = $tienda_ID";
    } else {
		$sql1 = "SELECT * FROM stores";
    }
} 
elseif($tipo == 3) {
    echo '<div class="tit">'.$userInfo->name.'<div><a href="../?logout&dashboard">log out</a></div></div>';
    if(isset($_GET['DM']) && $_GET['DM'] != 0) {
    	$DM_ID = $_GET['DM'];
		$sql1 = "SELECT * FROM stores WHERE DM = $DM_ID AND DR = $id";
    } else if(isset($_GET['Tienda']) && $_GET['Tienda'] != 0) {
    	$tienda_ID = $_GET['Tienda'];
		$sql1 = "SELECT * FROM stores WHERE code = $tienda_ID AND DR = $id";
    } else {
		$sql1 = "SELECT * FROM stores WHERE DR = $id";
    }
}
elseif($tipo == 2) {
    echo '<div class="tit">'.$userInfo->name.'<div><a href="../?logout&dashboard">log out</a></div></div>';
    if(isset($_GET['Tienda']) && $_GET['Tienda'] != 0) {
    	$tienda_ID = $_GET['Tienda'];
		$sql1 = "SELECT * FROM stores WHERE code = $tienda_ID AND DM = $id";
    } else {
		$sql1 = "SELECT * FROM stores WHERE DM = $id";
    }
}

if($DM_ID != '' || $DR_ID  != ''  || $tienda_ID  != '') echo '<a href="./">ver todos</a><br>';






$filas = array();
// print_r($filas);

$store_data_query = $db_connection->query($sql1) or die('Query failed: ' . mysqli_error()); 
// setlocale(LC_ALL,"es_MX");
foreach($store_data_query as $store_data){ 
	// echo $store_data['DM'];
	$t = $store_data['code'];
	$filas[$store_data['code']] = array($store_data['code'], $store_data['name'], $store_data['city'], $store_data['DM'], $store_data['DR']);
	
	$sql1 = "SELECT * FROM store_data WHERE store_id = $t";
	$store_data_query = $db_connection->query($sql1) or die('Query failed: ' . mysqli_error()); 
	setlocale(LC_ALL,"es_MX");
	foreach($store_data_query as $store_data){ 
		if($store_data['month'] == 1) {
			$totalC = $store_data['referenceValue'] * 1.03;
			$cierre = $store_data['week1'] + $store_data['week2'] + $store_data['week3'];
			if($totalC > 0) {
				$perc = round(($cierre/$totalC)*3, 2);
				if($perc > 3) {
					// echo $t;  
                    $db_connection->query("UPDATE employees SET `points` = points+1, `other` = 1 WHERE store_id = '$t' AND other < 1") or die('Query failed: ' . mysqli_error());   
				}
			}
	    	$filas[$store_data['store_id']]['m1'] = array($store_data['week1'], $store_data['week2'], $store_data['week3'], $store_data['week4'], $cierre, $totalC, $perc.'%');
		}
		if($store_data['month'] == 2) {
			$totalC = $store_data['referenceValue'] * 1.03;
			$cierre = $store_data['week1'] + $store_data['week2'] + $store_data['week3'] + $store_data['week4'] + $store_data['week5'];
			if($totalC > 0) {
				$perc = round(($cierre/$totalC)*3, 2);
				if($perc > 3) {
					// echo $t;  
                    $db_connection->query("UPDATE employees SET points = points+1, other = 2 WHERE store_id = '$t' AND other < 2") or die('Query failed: ' . mysqli_error());   
				}
			}
	    	$filas[$store_data['store_id']]['m2'] = array($store_data['week1'], $store_data['week2'], $store_data['week3'], $store_data['week4'], $store_data['week5'], $cierre, $totalC, $perc.'%');
		}

		if($store_data['month'] == 3) {
			$totalC = $store_data['referenceValue'] * 1.03;
			$cierre = $store_data['week1'] + $store_data['week2'] + $store_data['week3'] + $store_data['week4'];
			if($totalC > 0) {
				$perc = round(($cierre/$totalC)*3, 2);
				if($perc > 3) {
                    $db_connection->query("UPDATE employees SET points = points+1, other = 3 WHERE store_id = '$t' AND other < 3") or die('Query failed: ' . mysqli_error());   
				}
			}
	    	$filas[$store_data['store_id']]['m3'] = array($store_data['week1'], $store_data['week2'], $store_data['week3'], $store_data['week4'], $cierre, $totalC, $perc.'%');
		}
	}

}

// print_r($filas);

$colsArr = array('No de Tienda', 'Tienda', 'Ciudad', 'DM', 'D Regional', 
			'Semana 32', 'Semana 33', 'Semana 34', 'Semana 35', 'Cierre Agosto', 'Total Cuotas', '% de Incremento', 
			'Semana 36', 'Semana 37', 'Semana 38', 'Semana 39', 'Semana 40', 'Cierre Sept', 'Total Cuotas', '% de Incremento',
			'Semana 41', 'Semana 42', 'Semana 43', 'Semana 44', 'Cierre Oct', 'Total Cuotas', '% de Incremento',
		);

$tablas = "";
$DM_Act = array();
$tienda_Act = array();
foreach ($filas as $val) {
	$DM_id = $val[3];
	$DR_id = $val[4];

    $DMq = "SELECT name FROM users WHERE id = $DM_id";
    $DMa = $db_connection->query($DMq);
    // print_r($DMa)
   	if($DMa) {
	    $DM = $DMa->fetch_array();
	}
	$DRq = "SELECT name FROM users WHERE id = $DR_id";
    $DRa = $db_connection->query($DRq);
    // print_r($DMa)
   	if($DRa) {
	    $DR = $DRa->fetch_array();
	}

	$DM_Act[$val[3]] = $DM[0];
	$tienda_Act[$val[0]] = $val[1];
 

	$tienda = '';
    $tienda .= '<tr class="head"><td>'.$colsArr[0]. '</td><td>' .$colsArr[1].'</td><td>' .$colsArr[2]. '</td><td>' .$colsArr[3]. '</td><td>'.$colsArr[4] .'</td></tr>';
    $tienda .= '<tr><td>'.$val[0]. '</td><td>' .$val[1].'</td><td>' .$val[2]. '</td><td>' .$DM[0]. '</td><td>'.$DR[0] .'</td></tr>';
    $desemp = '';
    if(isset($val['m1'])) {
    	$desemp .= '<tr class="mes"><td>Agosto</td></tr>
    				<tr class="semana"><td>'.$colsArr[5].'</td>
    					<td>'.$colsArr[6].'</td>
    					<td>'.$colsArr[7].'</td>
    					<td>'.$colsArr[8].'</td>
    					<td>'.$colsArr[9].'</td>
    					<td>'.$colsArr[10].'</td>
    					<td>'.$colsArr[11].'</td></tr>
    				<tr><td>'.number_format($val['m1'][0]). '</td>
    					<td>' .number_format($val['m1'][1]). '</td>
    					<td>' .number_format($val['m1'][2]).'</td>
    					<td>' .number_format($val['m1'][3]).'</td>
    					<td>' .number_format($val['m1'][4]).'</td>
    					<td>' .number_format($val['m1'][5]).'</td>
    					<td>' .$val['m1'][6].'</td></tr>';
    }

    if(isset($val['m2'])) {
    	$desemp .= '<tr class="mes"><td>Septiembre</td></tr>
    				<tr class="semana"><td>'.$colsArr[12].'</td>
    					<td>'.$colsArr[13].'</td>
    					<td>'.$colsArr[14].'</td>
    					<td>'.$colsArr[15].'</td>
    					<td>'.$colsArr[16].'</td>
    					<td>'.$colsArr[17].'</td>
    					<td>'.$colsArr[18].'</td>
    					<td>'.$colsArr[19].'</td></tr>
    				<tr><td>'.number_format($val['m2'][0]). '</td>
    					<td>' .number_format($val['m2'][1]). '</td>
    					<td>' .number_format($val['m2'][2]). '</td>
    					<td>' .number_format($val['m2'][3]). '</td>
    					<td>' .number_format($val['m2'][4]).'</td>
    					<td>' .number_format($val['m2'][5]).'</td>
    					<td>' .number_format($val['m2'][6]).'</td>
    					<td>' .$val['m2'][7].'</td></tr>';
    }

    if(isset($val['m3'])) {
    	$desemp .= '<tr class="mes"><td>Octubre</td></tr>
    				<tr class="semana"><td>'.$colsArr[20].'</td>
    					<td>'.$colsArr[21].'</td>
    					<td>'.$colsArr[22].'</td>
    					<td>'.$colsArr[23].'</td>
    					<td>'.$colsArr[24].'</td>
    					<td>'.$colsArr[25].'</td>
    					<td>'.$colsArr[26].'</td></tr>
    				<tr><td>'.number_format($val['m3'][0]).'</td>
    					<td>' .number_format($val['m3'][1]).'</td>
    					<td>' .number_format($val['m3'][2]).'</td>
    					<td>' .number_format($val['m3'][3]).'</td>
    					<td>' .number_format($val['m3'][4]).'</td>
    					<td>' .number_format($val['m3'][5]).'</td>
    					<td>' .$val['m3'][6].'</td></tr>';
    }


    $tablas .= '<table class="DM_'.$val[3].' DR_'.$val[4].'">';
    $tablas .=  $tienda;
    $tablas .=  $desemp;	
    $tablas .=  '</table>';
}

if($tipo == 1 || $tipo == 4 ) {
	$formas .= '<form><select name="DR">
			<option value="0">seleccionar DR</option>';
	foreach ($DR_Opt as $k => $name) {
		$formas .=  '<option value="'.$k.'"';
		if($DR_ID == $k) $formas .=  "selected";
		$formas .=  '>'.$name.'</option>';
	}
	$formas .=  '</select><input type="submit" value="buscar DR"></form>';
	// $formas .=  '<form><select name="DM">
	// 		<option value="0">seleccionar DM</option>';
	// foreach ($DM_Opt as $k => $name) {
	// 		$formas .=  '<option value="'.$k.'"';
	// 		if($DM_ID == $k) $formas .=  "selected";
	// 		$formas .=  '>'.$name.'</option>';
	// }
	// $formas .=  '</select><input type="submit" value="buscar DM"></form>';
}
// else // $tipo == 3
if((!isset($_GET['DM']) && !isset($_GET['Tienda']))) {
	$formas .=  '<form><select name="DM">
			<option value="0">seleccionar DM</option>';
	foreach ($DM_Act as $k => $name) {
			$formas .=  '<option value="'.$k.'"';
			// if($DM_ID == $k) $formas .=  "selected";
			$formas .=  '>'.$name.'</option>';
	}
	$formas .=  '</select><input type="submit" value="buscar DM"></form>';
}

if(!isset($_GET['Tienda']) || $_GET['Tienda'] == 0) {
	$formas .=  '<form><select name="Tienda">
			<option value="0">seleccionar Tienda</option>';
	foreach ($tienda_Act as $k => $name) {
			$formas .=  '<option value="'.$k.'"';
			if($tienda_ID == $k) $formas .=  "selected";
			$formas .=  '>'.$name.'</option>';
	}
	$formas .=  '</select><input type="submit" value="buscar T"></form>';
}

echo $formas;

echo $tablas;


$db_connection->close();