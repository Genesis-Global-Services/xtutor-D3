<?php

include("conexion/conexion.php");
//$pagina es var HTTP
if($pagina=="") $pagina="index.html";  //valor por defecto



function salir()
{

   $con=openDB();
   if(!$con)
   {
   	    echo "We can not open the database";
   	    //exit();
        return;
   }
   
   session_start();
   $user=$_SESSION['COD_USUARIO'];
   
   $query="UPDATE USERS SET SESSIONID='' WHERE USERCODE='$user'";
   //echo "user=$user";
   //echo "query=$query";
   $resultado=genesis_exec($con,$query);
   genesis_commit($con);
   closeDB($con);
   $_SESSION = array();
   session_destroy();  
   
}


//SECCION PRINCIPAL
    salir();
    Header("Location:$pagina");
    


?>
