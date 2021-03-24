<?php
/************************************* 
* Ingresan:
*  $schoolType
*  $field
*  $language
*  $subject
*  
*  Devuelve:   html con la las tarjetas de tutores correspondientes
*
**************************************/
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
$schoolType = $_REQUEST['st'];
$field = $_REQUEST['f'];
$subject = $_REQUEST['s'];
$language = 0;


$query="SELECT DISTINCT  t.NAME as nombre, t.SUMMARY as resumen, t.TARIFF as tarifa, t.USERCODE as tutorid  FROM USERS2 t, TUTORS_SUBJECTS ts 
        WHERE t.USERTYPE = 'TUTOR' AND t.USERCODE = ts.USERCODE  
        AND ts.FIELD ='".$field."' AND ts.SCHOOLTYPE = '".$schoolType."'";
if ($subject!='')  $query.=" AND ts.SUBJECT ='".$subject."'";


$resultado=mysql_query($query);

if (!$resultado) {
    echo 'No se pudo ejecutar la consulta: ' . mysql_error();
    exit;
}
$tarjetas ="<div class='row mt-5'>";
$i=1;
while ($fila = mysql_fetch_array($resultado))
    {   
        $nombre = $fila[0];
        $resumen = $fila[1];
        $tarifa = $fila[2];
        $tutorid = $fila[3];

        /******************** */
        if ($resumen =="")  {
            $resumen="Lorem ipsum dolor, sit amet consectetur adipisicing elit. ! Omnis, quod. Nulla nam voluptas magni quaerat? Voluptatem!";
        } 

        //$pictureSource = "https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSM6uQb2hAyMAc4aqJHcMQ5a1h5NhE0GcS_0Q&usqp=CAU";
      
        $picture = "tutors/photo".$tutorid.".jpg";
        
        if (file_exists($picture)) {
            
            $pictureSource = "https://xtutor.online/".$picture;
        } else {
            $pictureSource = "https://xtutor.online/tutors/Portrait_Placeholder.png";
        }
      
$query2 = "SELECT  LASTACTIVITY from USERS2 WHERE USERCODE='".$tutorid."'";

$res2=mysql_query($query2);
$fila2 = mysql_fetch_array($res2);
$olddate = $fila2[0];

$datetime1 = new  DateTime($olddate);
$datetime2 = time();

$diff = $datetime2 - $datetime1->getTimestamp();



if (($diff<100) && ($diff>0))  { $online = "block";
                $offline = "none";
                $isDisabled = "";
    
                }
else {
    $online = "none";
    $offline =  "block";
    $isDisabled = "disabled";   
    
}



        

        $no_letter = 30 ;

        //saca los primeros 160 chars del resumen sin romper palabras
        if(strlen($resumen) > 160 )
        {
            $resumen = substr($resumen,0,strpos($resumen,' ',160));             //strpos to find ‘ ‘ after 30 characters.
        }
        

        //$online = "block";
        $rate = $i;
        $indice = ($rate*25)/5;
        $indice = 27-$indice;
        $canvasid="uno"+$i;
        $tarjeta = file_get_contents("tarjeta.html");
        $bodytag = str_replace("{{TUTOR NAME}}", ucfirst($nombre), $tarjeta);
        $bodytag = str_replace("{{summary}}", ucfirst($resumen), $bodytag);
        $bodytag = str_replace("{{rate}}", $tarifa, $bodytag);
        $bodytag = str_replace("{{online}}", $online, $bodytag);
        $bodytag = str_replace("{{offline}}", $offline, $bodytag);
        $bodytag = str_replace("{{calificacion}}", $rate, $bodytag);
        $bodytag = str_replace("{{canvasid}}", $canvasid, $bodytag);
        $bodytag = str_replace("{{indice}}", $indice, $bodytag);
        $bodytag = str_replace("{{pictureSource}}", $pictureSource, $bodytag);
        $bodytag = str_replace("{{tutor}}", $tutorid, $bodytag);
        $bodytag = str_replace("{{field}}", $field, $bodytag);
        $bodytag = str_replace("{{subject}}", $subject, $bodytag);
        $bodytag = str_replace("{{isDisabled}}", $isDisabled, $bodytag);

        /************************* */
        $tarjetas.= $bodytag;
        $i++;
    }

// cerrando fila    
$tarjetas.="</div>";

genesis_commit($con);
closeDB($con);	


    
    echo $tarjetas;
    ?>
    
   