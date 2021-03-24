<?php

include("security/header.php");

$haySession = isset($_SESSION['COD']) && intval($_SESSION['COD']) > 0;
if (!$haySession) {
    
   //return to login o other page
}

$tipoUsuario = $_SESSION['TYPE'];

if ($tipoUsuario != 'TUTOR') {

    // return to student page or other page
    
}

$codUsuario = $_SESSION['COD'];

$subjectList = isset($_REQUEST['subject_list']) ? $_REQUEST['subject_list'] : array();

if (is_array($subjectList) && count($subjectList) > 0) {// si hay que guardar

    $_in = "(";

    foreach ($subjectList as $value) {
        $_in .= "'" . $value . "',";
    }

    $setIn = substr_replace($_in, ')', -1);

    $escapeCodUsuario = "'" . $codUsuario . "'";

    $sqlQuery = "INSERT INTO TUTORS_SUBJECTS SELECT
	$codUsuario,
	tb1.SCHOOLTYPE,
	tb1.FIELD,
	tb1.SUBJECTCODE
FROM
	`SUBJECTS` tb1
WHERE
	tb1.SUBJECTCODE IN $setIn
AND tb1.SUBJECTCODE NOT IN (
	SELECT
		tb2.`SUBJECT`
	FROM
		TUTORS_SUBJECTS tb2
	WHERE
		tb2.USERCODE = $codUsuario
	AND tb2.`SUBJECT` IN $setIn
);";


    $conex = openDB();

    genesis_exec($conex, $sqlQuery);

    closeDB($conex);
}

header("Location: tutor-subjects.html");
