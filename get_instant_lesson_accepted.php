<?php 
// Proceso que verifica si un active instant lesson fue aceptada por el tutor.
require_once("conexion/conexion.php");

if (isset($_POST['usercode'])) {
    $p_usercode =  $_POST['usercode'];
    echo get_instant_lesson_accepted($p_usercode);
}

function get_instant_lesson_accepted($l_usercode)
{
    $con=openDB();
    $query="SELECT * FROM LESSONREQUESTS2 WHERE usercode = '$l_usercode' AND STATUS = 1";

    $resultado=genesis_exec($con,$query);
    if(genesis_fetch_row($resultado))
    {
        // Instant lesson Accepted.        
        return true;
    } else {
        // Instant lesson not accepted.
        return false;
    }
    closeDB($con);
}

?>