<?php

require_once("config/db.php");
require_once("classes/Login.php");
$login = new Login();
if ($login->isUserLoggedIn() == true) {

    require_once("classes/StoreData.php");

    $store_data = new StoreData();
    $dataObj = $store_data->checkStoreData();
    // $dataObj2 = $store_data->initTestEmployees();
    // echo '<pre>';
    //  print_r($dataObj);
     
    $mesActual = count($dataObj);
    $store_id = $dataObj[0]['store_id'];
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
    // echo $semanaActual;
    // echo $mesActual;
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
<script type="text/javascript">
$(document).ready(function() {
     $('#canjearForm').submit(function(ev){
          // $(".overlay").fadeOut();
          parametros = $('#canjearForm').serialize();
          // alert(parametros);
            ev.preventDefault();
            $.ajax({
                data:  parametros,
                url:   'canjear.php',
                type:  'post',
                 // dataType: 'json',
                beforeSend: function () {
                        $(".acumulados").html("Procesando tu pedido...");
                },
                success:  function (response) {
                    // alert(response.indexOf('error'));
                    if(  response.indexOf('error') == -1){
                        $(".overlay_anuncios").fadeIn();
                    } else {
                         $(".acumulados").html("Selecciona un regalo");
                    } 
                }
                });        
     });
    $('#entryForm').submit(function(ev){
          // $(".overlay").fadeOut();
            ev.preventDefault();
          // alert($('#employeeNum').val());
         
          parametros = $('#entryForm').serialize();
        // alert(parametros);
          $.ajax({
                data:  parametros,
                url:   'checkId.php',
                type:  'post',
                 dataType: 'json',
                beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        

                        // alert(JSON.stringify(response));
                        // console.log(response);
                        var points = response.points;
                        var employeeId = response.employeeId;
                        var email = response.email;
                        var errorMsg = response.errorMsg;
                        var verify = response.verify;

                        if( errorMsg == null)   {
                            $('#employeeIdNum').val(employeeId);
                            $('.etiqueta p').html('$'+(points*400));
                            // $("#chatTickets input:radio").attr('disabled',true);
                            j=0;    

                            if(verify != 1){
                                // 
                                for (i = 1; i <= points; i++) { 
                                   
                                    $('.column'+i).removeClass('disabled');
                                    $('.column'+i).find('.aGift').each(function(){
                                        j++;
                                        var acheckbox = $('<input>').attr({
                                            type: 'radio', name: 'regalo', value: j
                                        });
                                        // var acheckbox = '<input type="radio" name="regalo" value="'+(j)+'">';
                                         $( this ).append(acheckbox);

                                    });
                                }
                            } else {
                                // PROCESANDO PEDIDO
                                $('.acumulados').html('<span style="color:#f00">Estamos procesando tu premio</span>');
                                // $('.canjear').hide();
                            }
                            $(".overlay").fadeOut(); 
                            
                            if(email == ''){
                                // alert('employeeId');
                                $("#employeeEmailId").attr('value', employeeId);
                                $(".overlay_email").fadeIn();
                            }
                            if(points==null){
                                $('.canjear').hide();
                            }
                        } else {
                            // $("#resultado").html("err");
                            $("#resultado").html(errorMsg);
                            
                        }

           }
        });
   });      
$('#confirmEmailForm').submit(function(ev){
          // $(".overlay").fadeOut();
      
          // alert($('#employeeNum').val());
         ev.preventDefault();
          parametros = $('#confirmEmailForm').serialize();
          // alert(parametros);
     
          $.ajax({
                data:  parametros,
                url:   'confirmEmail.php',
                type:  'post',
                dataType: 'json',
                beforeSend: function () {
                        $("#resultado2").html("Procesando, espere por favor...");
                },
                complete:  function (response) {
                    
                    console.log(response);
                     // alert($.param(response));
                        
            
                        var ok = response.responseText;
                        var errorMsg = response.errorMsg;

                        if( errorMsg == null && ok == 'ok')   {
                            
                            // $("#resultado").html("paso3");
                            $(".overlay_email").fadeOut();
                   
                        } else {
                            $("#resultado2").html(errorMsg);
                            
                        }

           }
        });
   });      

});
</script>
</head>
<body>
<div class="wrapper">
<div class="fondo">
    <div class="superSlide">
         <img src="images/fondo.jpg">
    </div>
</div>

<div class="content">

<!-- empieza regalos -->

<div class="columna1">

<div class="regalo">
    <img src="images/regalos.png">
    <p>RECOMPENSAS</p>
</div>

<div class="recomp_tabla">
    <form method="POST" action="canjear.php" id="canjearForm">
        <input type="hidden" name="employeeId" id="employeeIdNum">
        <?php 
        // if(isset($dataObj[0]) && $dataObj[0]['status'] == 1){
        //     $disabled = '';

        // } else {
        //     $disabled = 'disabled';//onclick="return false"';
        // }
        ?>
        <div class="recomp_columna column1 disabled">
            <div class="recomp_cubo part1">
                <div class="titulos">
                    <div class="tit_m">Mes 1</div>
                    <div class="tit_c">$400</div>
                </div>
            </div>
            <div class="recomp_cubo aGift">
                <img src="images/regalo_01.png">
                <div class="tit_n">Bocina bluetooth <br><span></span></div>
                
            </div>

            <div class="recomp_cubo aGift">
                <img src="images/regalo_02.png">
                <div class="tit_n">Audífonos MDR<br><span>(SONY)</span></div>
                
            </div>
            <div class="recomp_cubo aGift">
                <img src="images/tarjetaderegalo.png">
                <div class="tit_n">Tarjeta de regalo<br><span>($400)</span></div>
            
            </div>
        </div>
        <?php 
        // if(isset($dataObj[1]) && $dataObj[1]['status'] == 1){
        //     $disabled = '';
        // } else {
        //     $disabled = 'disabled';//onclick="return false"';
        // }
        ?>
        <div class="recomp_columna column2 disabled">
            <div class="recomp_cubo part1">
                <div class="titulos">
                    <div class="tit_m">Mes 2</div>
                    <div class="tit_c">$800</div>
                </div>
            </div>
            <div class="recomp_cubo aGift">
                <img src="images/regalo_03.png">
                <div class="tit_n">DVD SONY DVP<br><span>(SONY)</span></div>
            </div>
            <div class="recomp_cubo aGift">
                <img src="images/regalo_04.png">
                <div class="tit_n">Ipod Shuffle 2GB gris<br><span>(APPLE)</span></div>
            </div>
            <div class="recomp_cubo aGift">
                <img src="images/tarjetaderegalo.png">
                <div class="tit_n">Tarjeta de regalo<br><span>($800)</span></div>
            </div>
        </div>
        <?php 
        // if(isset($dataObj[2]) && $dataObj[2]['status'] == 1){
        //     $disabled = '';
        // } else {
        //     $disabled = 'disabled';//onclick="return false"';
        // }
        ?>
        <div class="recomp_columna column3 disabled">
            <div class="recomp_cubo part1">
                <div class="titulos">
                    <div class="tit_m">Mes 3</div>
                    <div class="tit_c">$1200</div>
                </div>
            </div>
            <div class="recomp_cubo aGift">
                <img src="images/regalo_05.png">
                <div class="tit_n">Audífonos <br><span>(Skullcandy)</span></div>
                
            </div>

            <div class="recomp_cubo aGift">
                <img src="images/regalo_06.png">
                <div class="tit_n">Cargador solar<br><span></span></div>
               
            </div>
            <div class="recomp_cubo aGift">
                <img src="images/tarjetaderegalo.png">
                <div class="tit_n">Tarjeta de regalo<br><span>($1200)</span></div>
                
            </div>
        </div>
        <div class="clear"></div>

        <input type="submit" value="CANJEAR" class="canjear">
    </form>
</div>

</div>

<div class="columna2">
    <div class="part">
        <a href="index.php">
            <div class="logo_sirena"><img src="images/cup_aww.png"></div>
        </a>
        <div class="esq_sder">
            <!-- <div class="logo"></div> -->
            <div class="name"><?php print $dataObj[0]['name'] ?></div>    
            <div class="date">MES <?php print $mesActual;  ?> SEMANA <?php echo $semanaActual; ?></div>  
            <a href="../">< regresar</a> 
    
        </div>
    </div>
    <div class="part puntos">
        <p class="puntos_t">TIENES:</p>
        <div class="etiqueta"><img src="images/ornamenta_2.png"><p>$0</p></div>
        <p class="acumulados">ACUMULADOS</p>
    </div>

    <div class="part">
        <div class="text-right">
            Alcanza o rebasa la meta<br>
            (cuota del 3%) y gana $400 pesos <br>
            por mes (por partner), mismos que <br>
            puedes acumular o canjear <br>
            durante los 3 meses<br>
            de cup award  por premios.
        </div>
        <div class="text-right-mini">
            <p>
                *Premios sujetos a disponibilidad<br>
                *Tiempos de entrega variables por plaza,<br>
                se definirán con el usuario.
            </p>
        </div>    
    </div>

    <div class="part">
        <div class="marcas">
            <p>Tarjetas de regalo participantes</p>
            <div class="marca_img"><img src="images/logos/logo_03.png"></div>
            <div class="marca_img"><img src="images/logos/logo_02.png"></div>
            <div class="marca_img"><img src="images/logos/logo_01.png"></div>
            <div class="marca_img"><img src="images/logos/logo_06.png"></div>
            <div class="marca_img"><img src="images/logos/logo_05.png"></div>
            <div class="marca_img"><img src="images/logos/logo_04.png"></div>
            <div class="marca_img"><img src="images/logos/logo_09.png"></div>
            <div class="marca_img"><img src="images/logos/logo_08.png"></div>
            <div class="marca_img"><img src="images/logos/logo_07.png"></div>
            <div class="marca_img"><img src="images/logos/logo_11.png"></div>
            <div class="marca_img"><img src="images/logos/logo_10.png"></div>
            
            <div class="clear"></div>
        </div>
    </div>
    <div class="part">
        
    </div>
</div>


<!-- termina regalos -->


        </div>
    </div>

<div class="overlay_email">
    <div class="overlay_int">
        <form method="POST" id="confirmEmailForm">
            <div id="resultado2">Porfavor ingresa tu dirección de correo</div>
            <input type="email" name="employeeEmail" id="employeeEmail" required>
            <input type="hidden" name="store_id" value="<?php echo $store_id; ?>">
            <input type="hidden" name="employeeNum" id="employeeEmailId"  >
            
            <input class="btn2" type="submit" value="ingresar">
 
        </form>
    </div>
</div>

<div class="overlay">
    <div class="overlay_int">
        <form method="POST" id="entryForm">
            <div id="resultado">Ingresa tu número de empleado</div>
            <input type="text" name="employeeNum" id="employeeNum">
            <input type="hidden" name="store_id" value="<?php echo $store_id; ?>">
            
            <input class="btn" type="submit" value="ingresar">
            <p><a href="./">< regresar</a> </p>
        </form>
    </div>
</div>

<div class="overlay_anuncios">
    <div class="overlay_int2">
      <p>  Tu solicitud de canje ha sido enviada con éxito y está en proceso.
      Muy pronto recibirás un correo de confirmación 
      con los datos de entrega del artículo seleccionado.</p>

<p>Gracias por ser parte de Starbucks Cup Award.</p>

<quote>“Arriesga más de lo que otros creen seguro.
Sueña más de los que otros creen útil.”
-Howard Schultz.</quote>

       <p><a href="./">< regresar</a> </p>
    </div>
</div>
<div class="loader"></div>



</body>
</html>
<?php
} else {
    header("Location:./");
}
?>