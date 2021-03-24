<?php

  error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED); //this is for removing warnings about mysql deprecated, mysqli is more secure but only if you use prepared statements, so migrating to mysqli is not beneficial unless making this change 
  //SI EL TIPO DE CONNEXION A LA BASE ES ODBC
  /*$TIPOBASE="ODBC";
  $DNS="hotel";  //en la conexion ODBC ya especifica cual es la BD
  $USER    = "root";
  $PASS    = "";
  */

  //SI EL TIPO DE CONEXION A LA BASE ES MYSQL
  $TIPOBASE="MYSQL";
  $SERVIDOR=$_SERVER["REMOTE_ADDR"];
  //echo "SERVIDOR=$SERVIDOR";

  if($SERVIDOR=="127.0.0.1")
  {
    //local
    $SERVER = "localhost";
    $USER    = "root";
    $PASS    = "";
	$BASE = "xtutor_database1";
  }
  else
  {
     
     $SERVER = "localhost";
     $USER   = "jorgecs_xtutor";
     $PASS   = "ny1sh145";
	 $BASE = "jorgecs_xtutor";
  }


  //AQUI ESTA LA CORRESPONDENCIA ENTRE EMPRESA Y BASE DE DATOS
  //$EMPRESA ES VARIABLE DE SESION
  //echo "EMPRESA=$EMPRESA";  //solo para ver si llega la variable
  //exit();

  function openDB()
  {

    global $SERVER,$USER,$PASS,$TIPOBASE,$BASE,$DNS;
    if($TIPOBASE=="ODBC")
    {
       $conexion  = odbc_connect($DNS,$USER,$PASS);
       odbc_autocommit($conexion,false);
    }
    else
    {
       $conexion  = mysql_connect($SERVER,$USER,$PASS);
       if($conexion) //añadido 25-10-2013 error cambio de servidor
		{
			$query="use ".$BASE;
                $result=mysql_query($query,$conexion);
                $result=mysql_query("set autocommit=0",$conexion);//para poder hacer rollback
			//$result=mysql_query("FLUSH HOSTS",$conexion); //25-10-13 
		}     
    }
    if(!$conexion)
	{
	   echo "ERROR: It was not possible to open the database";
	   exit();
    }
    return $conexion;
  }

  function closeDB($conex)
  {
      global $TIPOBASE;
      if($TIPOBASE=="ODBC")
        odbc_close($conex);
      else
        mysql_close($conex);
  }


  $MATRIZFILA=array();
  $VECTORPOSICION=array();
  function genesis_exec($conexion,$query)
  {
     //echo "LOG query=$query";
	 if(!$conexion) //añadido 25-10-2013 error en el servidor
	{
	   echo "ERROR: No se pudo abrir la Base de Datos";
	   exit();
     }

     global $TIPOBASE;
     global $MATRIZFILA;
     global $VECTORPOSICION;
     global $EMPRESA;
     //$query=strtoupper($query); UPPER CASE
     //se cambia el nombre de la BD porque en UNIX diferencia
     //echo "SENTENCIA=$query  <br> \n";
     if($TIPOBASE=="ODBC")
       $result=odbc_exec($conexion,$query);
     else  //MYSQL
     {
       $result=mysql_query($query,$conexion);
	   //$result=mysql_unbuffered_query($query,$conexion);
       $MATRIZFILA[(int)$result]="";  //cada vez que llama a ejecutar limpia el vector
	   ////////echo "MATRIZFILA[result]=".$MATRIZFILA[$result]." <br>\n";
	   $VECTORPOSICION[(int)$result]=0;

     }
     //$posicion=mysql_num_rows($result);//funciona con unbuffered query
     //////////echo "posicion al ejecutar=$posicion <br>\n";
     if(!$result)
     {
        echo "<b>ERROR DE SQL </b><br>\n";
        echo "SENTENCIA=$query  <br> \n";
        echo "ERROR=".genesis_errormsg($conexion)."<br> \n";
        genesis_rollback($conexion);
        exit (); //aqui termina todo
        //return false;
     }
	 else
	 {
		 $query=str_replace("'","\'",$query);
		 $logquery="INSERT INTO LOG (DATETIME,QUERY) VALUES (now(),'".$query."')";
		 //echo "logquery=$logquery";
		 //mysql_query($logquery,$conexion);
		 
	 }

     //echo "result=$result<br>\n";
     return $result;

  }



  function genesis_fetch_row($result)
  {

     global $TIPOBASE;
     global $MATRIZFILA;
     global $VECTORPOSICION;
     //echo "result de entrada a fetch=$result <br>\n";
     //$posicion=mysql_num_rows($result);//funciona con unbuffered query
     //echo "posicion antes del fetch=$posicion<br>\n";
     //echo "VECTORFILA=$VECTORFILA <br>\n";
     //parece ser que en ODBC fetch_row no devuelve el vector
     //pero si devuelve "1" (true) o "" (false)
     if($TIPOBASE=="ODBC")
	   //$MATRIZFILA[$result]=odbc_fetch_row($result);
	   return odbc_fetch_row($result);
	 else  //MYSQL
	 {

       $MATRIZFILA[(int)$result]=mysql_fetch_array($result);   //mueve el cursor a la siguiente posicion

       /*
       echo "0=".$MATRIZFILA[$result][0]."<br>\n";
       echo "1=".$MATRIZFILA[$result][1]."<br>\n";
       echo "2=".$MATRIZFILA[$result][2]."<br>\n";
       echo "3=".$MATRIZFILA[$result][3]."<br>\n";

       $fila=array();
       $fila=mysql_fetch_array($result);   //mueve el cursor a la siguiente posicion
       echo "fila[0]=".$fila[0]."<br>\n";
	   echo "fila[1]=".$fila[1]."<br>\n";
	   echo "fila[2]=".$fila[2]."<br>\n";
       echo "fila[3]=".$fila[3]."<br>\n";
       */
       $VECTORPOSICION[(int)$result]++;
       return $MATRIZFILA[(int)$result];
     }

     //////////echo "pos=".$VECTORPOSICION[$result];
     //$posicion=mysql_num_rows($result);//funciona con unbuffered query
     //////////echo "posicion despues del fetch=$posicion<br>\n";
     ////////echo "MATRIZFILA[result]=".$MATRIZFILA[$result]." <br>\n";

  }


  function genesis_result($result,$campo)
  {
     global $TIPOBASE;
     global $MATRIZFILA;
     global $VECTORPOSICION;


     //echo "campo=$campo <br>\n";
     if($TIPOBASE=="ODBC")
	   $valor=odbc_result($result,$campo);
	 else  //MYSQL
	 {
       //////////echo "VECTORFILA=$VECTORFILA <br>\n";
       if($MATRIZFILA[(int)$result]=="")
       {
         ////////echo "MATRIZFILA esta vacio <br>\n";
         $MATRIZFILA[(int)$result]=genesis_fetch_row($result);//si no llamó desde el script

       }

       //exit();
       $posicion=$VECTORPOSICION[(int)$result];
       //$posicion=mysql_num_rows($result);//funciona con unbuffered query
       ////////echo "posicion=$posicion <br>\n";
       ////////echo "campo=$campo <br>\n";
       //$valor=mysql_result($result,$posicion-1,$campo-1); //no funciona parece un bug cuando se pasa de mysql4 a mysql5
       ////////echo "result=$result";
       //echo "MATRIZFILA[result]=".$MATRIZFILA[$result]." <br>\n";
       $fila=$MATRIZFILA[(int)$result];
       //echo "fila=$fila<br>\n";
       //echo "fila[0]=$fila[0]<br>\n";
	   //echo "fila[1]=$fila[1]<br>\n";
	   //echo "fila[2]=$fila[2]<br>\n";
       $valor=$fila[$campo-1];
       //echo "campo=$campo<br>\n";

       if(is_numeric($campo))
          $valor=$MATRIZFILA[(int)$result][$campo-1];
       else
       {
          $campo=strtoupper($campo); //esto causa error en el result pero no en la matriz
          $valor=$MATRIZFILA[(int)$result][$campo];
       }


       //echo "valor=$valor <br>\n";


     }

     return $valor;
  }
  function genesis_num_rows($result)
  {
     global $TIPOBASE;
     if($TIPOBASE=="ODBC")
	   return  odbc_num_rows($result);
	 else  //MYSQL
       return  mysql_num_rows($result);
  }

  function genesis_errormsg($conex)
  {
     global $TIPOBASE;
     if($TIPOBASE=="ODBC")
  	   return  odbc_errormsg($conex);
  	 else  //MYSQL
         return  mysql_error($conex);
  }

  function genesis_commit($conex)
  {
     global $TIPOBASE;
     if($TIPOBASE=="ODBC")
  	   return  odbc_commit($conex);
  	 else  //MYSQL
         return  mysql_query("commit",$conex);
  }


  function genesis_rollback($conex)
  {
     global $TIPOBASE;
     if($TIPOBASE=="ODBC")
  	   odbc_exec($conex,"rollback");
  	 else  //MYSQL
       mysql_query("rollback",$conex);
     echo "rollback";
  }
?>
