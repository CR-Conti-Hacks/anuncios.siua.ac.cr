<!DOCTYPE html>

<html> 
<head> 
    
    <title>Anuncios - SIUA</title> 
  

    <meta charset="UTF-8">
	<meta name="description" content="Sistema de anuncios SIUA">
	<meta name="keywords" content="Anuncios, SIUA">
	<meta name="author" content="Gustavo Matamoros G.">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel='stylesheet' id='camera-css'  href='css/camera.css' type='text/css' media='all'> 
    <style>
		html,body {
			height: 100%;
			margin: 0;
			padding: 0;
			background-color: #3E5166;
		}

		#contenido {
			bottom: 0;
			height: 100%;
			left: 0;
			margin-bottom: 0!important;
			position: fixed;
			right: 0;
			top: 0;
		}

		.camera_overlayer {
			opacity: .1;
		}
	</style>

    <!--///////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //		Scripts
    //
    ///////////////////////////////////////////////////////////////////////////////////////////////////--> 
    
    <script type='text/javascript' src='scripts/jquery-3.6.0.min.js'></script>

    <script type='text/javascript' src='scripts/jquery.easing.1.3.js'></script> 
    <script type='text/javascript' src='scripts/camera.js'></script> 
    
    
 
</head>
<body >

    <div class="camera_wrap camera_black_skin"  id="contenido" >
			<?php


				/*******************************************************/
				/**************** Configuración de tiempos  ************/
				/*******************************************************/
				$tiempoXImagen=27000;
				$tiempoTransicion=1500;


				
				/*******************************************************/
				/**************** Dir: Anuncios ************************/
				/*******************************************************/
			    $directory="admin/data/Group/public/home/anuncios";
			  
			    $dirint = dir($directory);
			    $contadorImagenes = 0;
			    
			    while (($archivo = $dirint->read()) !== false)
			    {
			        if(($archivo !='')&& ($archivo != null) && ($archivo !="..") && ($archivo !='.') && ($archivo != '.gitkeep')){	    
				    	$contadorImagenes++;
			?>
				    
				<div data-src="admin/data/Group/public/home/anuncios/<?=$archivo?>" ></div>
			<?php
				
				   }
			    }
			    $dirint->close();

			    //Si no existen imagenes vaya a videos
			    if($contadorImagenes == 0){
			    	header("Location: videos.php");
					die();

			    }


			    /*******************************************************/
				/**************** Dir: Videos   ************************/
				/*******************************************************/
				$directory="admin/data/Group/public/home/videos";
			  
			    $dirint = dir($directory);
			    $contadorVideos = 0;

			    //Verificar si hay videos
			    while (($archivo = $dirint->read()) !== false)
			    {
			        if(($archivo !='')&& ($archivo != null) && ($archivo !="..") && ($archivo !='.') && ($archivo != '.gitkeep')){	    
			  			$contadorVideos++;
			  		}      	
			  	}
			  	$dirint->close();

			?>

    </div>
    <input type="hidden" value="<?=$contadorImagenes?>" id="contadorImagenes" name="contadorImagenes">
    <input type="hidden" value="<?=$contadorVideos?>" id="contadorVideos" name="contadorVideos">
	<script>

		/***********************************************************************************/
		/************************      Funcion de galeria       ****************************/
		/***********************************************************************************/
		jQuery(function(){
			
			jQuery('#contenido').camera({
				height: 'auto',
				pagination: false,
				thumbnails: false,
				hover: false,
				opacityOnGrid: false,
				loaderColor: '#2BA0AB', //color tiempo trancurrido ciculo
				loaderBgColor: '#0F2742', // Color fondo circulo tiempo transcurrido
				loaderOpacity: .8,
				navigation: false, //Ocultar navegación
				playPause: false,
				pauseOnClick: true,
				navigationHover: false,
				opacityOnGrid: false,
				time: <?=$tiempoXImagen?>, //Tiempo de la imagen
				transPeriod: <?= $tiempoTransicion?>, // Tiempo de la transisión
				imagePath: 'images/'
			});
			
		});
		/***********************************************************************************/
		/************************  FIN Funcion de galeria       ****************************/
		/***********************************************************************************/



		/***********************************************************************************/
		/************************      Si existen videos        ****************************/
		/***********************************************************************************/
		<?php
		//Si existen videos
		if($contadorVideos > 0){
		?>
			window.onload = function() {
			  redireccionar();
						  
			};
		<?php
		}
		?>
		/***********************************************************************************/
		/************************ FIN  Si existen videos        ****************************/
		/***********************************************************************************/





		/***********************************************************************************/
		/************************   Redireciconar a  videos     ****************************/
		/***********************************************************************************/
		function redireccionar() {
		    setTimeout("location.href='videos.php'", <?=($contadorImagenes * (($tiempoXImagen)+($tiempoTransicion)) )?>);
		}
		/***********************************************************************************/
		/*********************   FIN  Redireciconar a  videos      *************************/
		/***********************************************************************************/


		/***********************************************************************************/
		/************************     Hay nuevas Imagenes       ****************************/
		/***********************************************************************************/
		//ejecutar la función cada paso de imagen
		setInterval(hayImagenesNuevas, <?=($tiempoXImagen)+ ($tiempoTransicion-100)?>);

		function hayImagenesNuevas(){
			// Definimos la URL que vamos a solicitar via Ajax
			var ajax_url = "webserviceImagenes.php";

			// Definimos los parámetros que vamos a enviar
			var params = "";

			// Añadimos los parámetros a la URL
			ajax_url += '?' + params;

			// Creamos un nuevo objeto encargado de la comunicación
			var ajax_request = new XMLHttpRequest();


			// Definimos una función a ejecutar cuándo la solicitud Ajax tiene alguna información
			ajax_request.onreadystatechange = function() {

			    // readyState es 4
			    if (ajax_request.readyState == 4 ) {

			        // Analizaos el responseText que contendrá el JSON enviado desde el servidor
			        var jsonObj = JSON.parse( ajax_request.responseText );
			        
			        
			        //Preguntamos si la cantidad de imagenes es diferente recargamos la página
			        if(jsonObj.length != document.querySelector('#contadorImagenes').value){
			        	window.location.href = "index.php";
			        }
			    }
			}
			
			// Definimos como queremos realizar la comunicación
			ajax_request.open( "GET", ajax_url, true );

			//Enviamos la solicitud
			ajax_request.send();
		}

		/***********************************************************************************/
		/************************     Hay nuevas Imagenes       ****************************/
		/***********************************************************************************/
	</script>
    
</body> 
</html>
