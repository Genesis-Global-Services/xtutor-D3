<?php
header('Access-Control-Allow-Origin: *');
//aquí agregamos solo los metodos que necesitemos
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$DEBUG_MODE=1;
//THIS FILE IS ONLY FOR STUDENTS
include("conexion/conexion.php");  
//if(!$hay_sesion )Header("Location:login.htm");
$con=openDB();

$code = $_REQUEST['cd'];

$query="UPDATE USERS2 SET LASTACTIVITY = NOW()  
        WHERE USERCODE ='".$code."' LIMIT 1";



mysql_query($query);


 echo "500";  


genesis_commit($con);
closeDB($con);	


    
   
    ?>
    
   