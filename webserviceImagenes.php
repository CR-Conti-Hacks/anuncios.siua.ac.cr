<?php
    if (isset($_SERVER['HTTP_ORIGIN'])) {  
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");  
        header('Access-Control-Allow-Credentials: true');  
        header('Access-Control-Max-Age: 86400');   
    }  
      
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {  
      
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))  
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  
      
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))  
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");  
    }  

$anuncios = array();

$directory="admin/data/Group/public/home/anuncios";
$dirint = dir($directory);
while (($archivo = $dirint->read()) !== false){
    if(($archivo !='')&& ($archivo != null) && ($archivo !="..") && ($archivo !='.') && ($archivo != '.gitkeep')){
        $anuncios[] = $archivo;
    }
}
$dirint->close();

//$data = array('nombre','blog');

//$json = array();
//$json= array("imagen"=>"a","imagen"=>"b");

//print(json_encode($json));
print(json_encode($anuncios));

//$imagenes = array("imagenes"=>array("imagen1","imagen2","image"));
//$imagenes = array("imagen1","imagen2","image");
//print(json_encode($imagenes));
 
 
 ?>
