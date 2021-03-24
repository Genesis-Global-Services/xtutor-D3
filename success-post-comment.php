<?php

require './security/header.php';
require './security/session_helper.php';

if (Session_Helper::isLogged() && isset($_POST['send'])) {
    $_param_user_code = Session_Helper::getUserCode();
    $_param_school_type = intval($_POST['school_type']);
    $_param_comment = "'" . $_POST['comment'] . "'";

    $sqlQuery = "INSERT INTO `REVIEWS` (
	`ID`,
	`REVIEWDATE`,
	`USERCODE`,
	`SCHOOLTYPE`,
	`COMMENT`
)
VALUES
	(
		NULL,
		NOW(),
		$_param_user_code,
		$_param_school_type,
		$_param_comment
	)";
    include_once './conexion/conexion.php';
    $conex = openDB();

    genesis_exec($conex, $sqlQuery);

    closeDB($conex);
}

$_success_query = "";
if ($_param_school_type == 1){
    $_success_query = '?type=college';
}elseif ($_param_school_type == 2){
    $_success_query = '?type=graduate';
}

header("Location: success.html$_success_query");
