<?php
function conectaDB() 
{ 
  	$host = 'localhost'; 
	$user = 'id21339672_useradmin1';  //nombre de Usuario que proporciona 000webhost
	$pass = 'establecer_contraseña';

   if (!( $link = @mysqli_connect($host,$user,$pass)) )
   {
      echo "Error al realizar la conexión a la base de datos.";
      exit();
   }

   if (!mysqli_select_db($link,"id21339672_miempresa")) //nombre dela BD que proporciona 000webhost
   { 
      echo "Error al seleccionar la base de datos."; 
      exit(); 
   }    
   return $link; 
} 
?>
