<?php      //header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");              // Date in the past
		//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
		//header("Cache-Control: no-cache, must-revalidate");            // HTTP/1.1
        //header("Pragma: no-cache");
        // tutorcode
        // lesson type
        // subject
        // field
        // schooltype?       
        session_start(); //aqui obtiene la sesion ya abierta ya sea por cookies o por URL
        $hay_sesion=isset($_SESSION['COD']);
		//echo "hay_sesion=$hay_sesion";
   
	
      if($hay_sesion )
      {
        if($_REQUEST['t']==''){
          if(isset($_SESSION['S_TUTORCODE'])){
            unset($_SESSION['S_TUTORCODE']);
          }
        } else {
          $_SESSION['S_TUTORCODE'] = $_REQUEST['t'];
        }

        if($_REQUEST['l']==''){
          if(isset($_SESSION['S_LESSONTYPE'])){
            unset($_SESSION['S_LESSONTYPE']);
          }
        } else {
          $_SESSION['S_LESSONTYPE'] = $_REQUEST['l'];
        }

        if($_REQUEST['s']==''){
          if(isset($_SESSION['S_SUBJECT'])){
            unset($_SESSION['S_SUBJECT']);
          }
        } else {
          $_SESSION['S_SUBJECT'] = $_REQUEST['s'];
        }

        if($_REQUEST['c']==''){
          if(isset($_SESSION['S_FIELD'])){
            unset($_SESSION['S_FIELD']);
          }
        } else {
          $_SESSION['S_FIELD'] = $_REQUEST['c'];
        }
			
        if($SSID!=session_id())
        {
          $hay_sesion=false;
        }
      }
     
     
     header('Location: lesson.htm');
?>