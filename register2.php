<?php

include("security/header2.php");
//include("conexion/conexion.php");
//$pagina es var HTTP

$form_name=$_POST['form_name'];
$form_password=$_POST['form_password'];
$form_email=$_POST['form_email'];
$form_gender=$_POST['form_gender'];
$form_school=$_POST['form_school'];
$USER_TYPE=$_POST['USER_TYPE'];

if($USER_TYPE=="STUDENT")$pagina="payment.htm";
else $pagina="tutor-subjects.html"; 


//session_start();   		        
//$SESION=session_id();
//$hay_sesion=isset($_SESSION['COD']);
//$USERCODE=$_SESSION['COD'];			
if($hay_sesion) $modify=1;   //hay_session and modify are the same (unles we need to change in the future)
else $modify=0;

function autentificar()
{

global $pagina,$hay_sesion,$SESION,$USERCODE,$_SESSION,$modify,$USER_TYPE,$_FILES;
//echo "linea 1";
global $form_name,$form_password,$form_email,$form_gender,$form_school;
//echo "linea 2";
$mensaje=1;

if($form_name=='' || $form_password=='' || $form_email=="")
{
	$mensaje="Incomplete data";

}
else
{

  $con=openDB();
  if(!$con)
  {
   	$mensaje="It was not possible to connect to database";
   	//exit();
  }
  else
  {

     $query="SELECT * FROM USERS2 WHERE EMAIL='$form_email'";
     $resultado=genesis_exec($con,$query);
     if(!$resultado)
     {
         $mensaje="Error en la sentencia SQL";
	     echo "Sentencia: $query <br>";
  	     echo "Error: ".mysql_error();
  	     exit();
     }
     else
     {
     	 $fila=genesis_fetch_row($resultado);

         if($fila) //user exists in DB
	     {
	      	if($modify)  //For security reasons it is very important to check there is a session (the user logged in) before updating information
			{	
				$query="UPDATE USERS2 SET NAME='$form_name',EMAIL='$form_email',PASSWORD=HEX(AES_ENCRYPT('$form_password', UNHEX(SHA2('babel',512)))),GENDER=$form_gender,SCHOOLTYPE=$form_school WHERE USERCODE='$USERCODE'";
				$resultado=genesis_exec($con,$query);
                $mensaje=1;
				$_SESSION['NAME']=$form_name;	
				$_SESSION['EMAIL']=$form_email;	
                $_SESSION['SCHOOLTYPE']=$form_school;				
			}
			else
			{
				$mensaje="User already exists, please log in"; //he is trying to register (modify==0) a previous user 
				$pagina="login2.htm";		
			}
	     }
	     else  //user does not exist in DB
	     {               
	      	if($modify)
			{
				$mensaje="User does not exist, please register";
				$pagina="register2.html";		
			}		
		    else
			{	
				session_start();   	
				$SESION=session_id();
				$query="INSERT INTO USERS2 (NAME,SIGNUPDATE,EMAIL,PASSWORD,BALANCE,SESSIONID,USERTYPE,GENDER,SCHOOLTYPE) VALUES ('$form_name',NOW(),'$form_email',HEX(AES_ENCRYPT('$form_password', UNHEX(SHA2('babel',512)))),0,'$SESION','$USER_TYPE',$form_gender,$form_school)";
				$resultado=genesis_exec($con,$query);
				$query="SELECT LAST_INSERT_ID()";
				//$query="SELECT USERCODE FROM USERS WHERE EMAIL='$form_email'";
				$resultado=genesis_exec($con,$query);
		 
				$USERCODE=genesis_result($resultado,1);
				if($USERCODE!='')
				{
					$mensaje=1;      //solo devuelve 1 si el usuario se autentificó con éxito
					$_SESSION['TYPE']=$USER_TYPE;   	//usar esto si register_globals=off
					$_SESSION['COD']=$USERCODE;   	//this will set hay_session to true  
					$USER_NAME=$form_name;
					$_SESSION['NAME']=$USER_NAME;	
                    $_SESSION['SCHOOLTYPE']=$form_school;											
				}		
				else $mensaje='Database error creating new user';
			}
		 }
		 
		 	if($USER_TYPE!="STUDENT")$target_dir = "tutors/";
			else $target_dir = "students/";
			
			if(isset($_FILES['pictureToUpload']))
			{	
			
				$_FILES["pictureToUpload"]["name"]="photo".$USERCODE.".jpg";	
			    $target_file = $target_dir . basename($_FILES["pictureToUpload"]["name"]);
				move_uploaded_file($_FILES['pictureToUpload']['tmp_name'], $target_file);
			}
			if(isset($_FILES['fileToUpload']))
			{	
		        $_FILES["pictureToUpload"]["name"]="resume".$USERCODE.".pdf";	
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file);
			}
		 
	  }
      genesis_commit($con);
      closeDB($con);
   }

  }
 
return $mensaje;
}//fin autentificar()




//SECCION PRINCIPAL

    

        $res=autentificar();

	    if($res==1)//si se autentificó con éxito va a la página solicitada
	    {
              //No tiene que preocuparse de los cookies si es que utiliza URL para pasar el SID
              //(poner session.use_trans_sid=1 para que pase el SID automaticamente )
	          //echo SID;   //muestra algo como esto PHPSESSID=8f9674164c2d38b241149aea40db105a
		
			Header("Location:$pagina");  //esto lo envia a la pagina que solicita
              //exit();
              

        }
        else
		{
			Header("Location:$pagina?message=$res");
			//si llega aqui es porque hubo algun error con la BD
			//echo "<script language='javascript'>alert('".$res."')</script>";
		}


    

    


?>
