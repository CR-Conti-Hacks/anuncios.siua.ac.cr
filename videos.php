<!DOCTYPE html>
<html lang="es" >

<head>
  <title>Anuncios SIUA</title>
  
  <meta charset="UTF-8">
  <meta name="description" content="Sistema de anuncios SIUA">
	<meta name="keywords" content="Anuncios, SIUA">
	<meta name="author" content="Gustavo Matamoros G.">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="stylesheet" href="css/videos.css">

	<?php 



				/*******************************************************/
				/**************** Dir: Videos   ************************/
				/*******************************************************/
				$directorio="admin/data/Group/public/home/videos";
				$dirint = dir($directorio);
				$contadorVideos = 0;

				while (($archivo = $dirint->read()) !== false){
					if(($archivo !='')&& ($archivo != null) && ($archivo !="..") && ($archivo !='.') && ($archivo != '.gitkeep')){
						$contadorVideos++;
						$lista_videos[] = $archivo;
					}
				}
				$dirint->close();
				
	?>
  
</head>

<body>
	<input type="hidden" value="<?=$contadorVideos?>" id="contadorVideos" name="contadorVideos">

  <video  preload autoplay  width="640" height="360" id="Player" src="<?=$directorio."/".$lista_videos[0]?>"></video>
  <script>

  	/***********************************************************************************/
		/************************    Crear lista de videos      ****************************/
		/***********************************************************************************/
  	//Cantidad de videos
  	var contadorVideos = <?=$contadorVideos?>;

  	//Si no hay videos mande aindex.php
  	if(contadorVideos==0){
  		location.href='index.php';

  	//Si hay videos
  	}else if(contadorVideos>0){
  		var lista_videos = <?php echo json_encode($lista_videos);?>; 
  		var elm = 0; 
  	//obtener reproductor
		var Player = document.getElementById('Player');

		//Al finalizar reproducir el siguiente video
		Player.onended = function(){
		    if(++elm < lista_videos.length){    
		    		//Verificamos si hay mas videos
		    		hayVideosNuevos()

		    		

		        //Al 
		    }else{
		    	location.href='index.php';
		    }
		}	
	 	
  	}
  	/***********************************************************************************/
		/*********************** FIN Crear lista de videos      ****************************/
		/***********************************************************************************/




  	/***********************************************************************************/
		/************************     Hay nuevos Videos         ****************************/
		/***********************************************************************************/
		
		function hayVideosNuevos(){
			// Definimos la URL que vamos a solicitar via Ajax
			var ajax_url = "webserviceVideos.php";

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
			        if(jsonObj.length != document.querySelector('#contadorVideos').value){
			        	
			        	//Reiniciar el reproductor
			        	Player.pause();
			        	Player.removeAttribute('src');

			        	//Volver a cargar
			        	window.location.href = "videos.php";
			        	

			        }else{

			        	//reproducir el siguiente video     
		        		Player.src = "<?=$directorio."/"?>"+lista_videos[elm]; Player.play();
			        	
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

