<?      //header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");              // Date in the past
		//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
		//header("Cache-Control: no-cache, must-revalidate");            // HTTP/1.1
        //header("Pragma: no-cache");
        include("constants.php");
        session_start(); //aqui obtiene la sesion ya abierta ya sea por cookies o por URL
        $hay_sesion=isset($_SESSION['COD']);
		//echo "hay_sesion=$hay_sesion";
       include("conexion/conexion.php");  
	   $con=openDB();
       if($hay_sesion )
       {
			
            
			$USER_CODE=$_SESSION['COD'];	            
			//echo "mierda carajo USER_CODE=$USER_CODE";
			$query="SELECT SESSIONID,NAME,BALANCE,USERTYPE,SCHOOLTYPE FROM USERS2 WHERE USERCODE='$USER_CODE'";
			$resultado=genesis_exec($con,$query);
			$SSID=genesis_result($resultado,1);
			$USER_NAME=genesis_result($resultado,2);$_SESSION['NAME']=$USER_NAME;
			$USER_BALANCE=genesis_result($resultado,3);$_SESSION['BALANCE']=$USER_BALANCE;
			$USER_TYPE=genesis_result($resultado,4);$_SESSION['TYPE']=$USER_TYPE;
			$SCHOOLTYPE=genesis_result($resultado,5);$_SESSION['SCHOOLTYPE']=$SCHOOLTYPE;
			if($USER_TYPE!='STUDENT')
			{
				$USER_BALANCE='30';	
			    $_SESSION['BALANCE']=$USER_BALANCE;
			}			
			if($SSID!=session_id())
			{
				$hay_sesion=false;
			}
       }
	   genesis_commit($con);
       closeDB($con);	
?>