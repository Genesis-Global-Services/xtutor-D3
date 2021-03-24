<?php 
// Proceso de validación del user email para student o tutor.
require_once("conexion/conexion.php");

if (isset($_POST['email_check'])) {
    $p_useremail =  $_POST['email'];
    echo validate_user_email($p_useremail);
}

function validate_user_email($user_email)
{
    $con=openDB();
    $query="SELECT * FROM USERS2 WHERE EMAIL = '$user_email'";

    $resultado=genesis_exec($con,$query);
    if(genesis_fetch_row($resultado))
    {
        // The user email already exist.        
        return true;
    } else {
        // The user email not exist.
        return false;
    }
    closeDB($con);
}

?>