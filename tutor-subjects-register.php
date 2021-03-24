<?php
require_once ("conexion/conexion.php");

if (!function_exists("getSubjectList")) {

    function getSubjectList($field) {

        $resultArray = array();

        $conex = openDB();

        $sqlQuery = "SELECT * FROM `SUBJECTS` where FIELD = '" . $field . "'";

        $result = genesis_exec($conex, $sqlQuery);

        if (!empty($result) && genesis_num_rows($result) > 0) {
            while (($row = genesis_fetch_row($result))) {
                array_push($resultArray, $row);
            }
        }

        closeDB($conex);

        return $resultArray;
    }

}

//models

$schoolTypeList = $SCHOOLTYPE_LIST;
$fieldList = $FIELDS_LIST;
$userCode = 27;

//request

$field = filter_input(INPUT_GET, 'field');
$school = filter_input(INPUT_GET, 'school');
$subjectList = getSubjectList($field);

//parse results

$i = 0;
$j = 0;
$k = 0;
$_numCol = 3;

$_table0 = "";
$_table1 = $_table0;
$_table2 = $_table1;

$_table_td = "";

$_table0_tds = "";
$_table1_tds = "";
$_table2_tds = "";

foreach ($subjectList as $tutorSubject) {

    $_subjectDescription = $tutorSubject['DESCRIPTION'] . '(' . $tutorSubject['FIELD'] . ',' . $tutorSubject['SCHOOLTYPE'] . ',' . $tutorSubject['SUBJECTCODE'] . ')';
    $_subjectDescription = $tutorSubject['DESCRIPTION'];
    $_subjectKey = $tutorSubject['SUBJECTCODE'];

    $_subjectHtml = <<<EOF
                    <strong><input form="form_registrar_subjects" type="checkbox" id="subject_list" name="subject_list[]"  value="{$_subjectKey}"/>&nbsp;&nbsp;{$_subjectDescription}</strong>
EOF;

    $_table_td = '<td width="30%">' . $_subjectHtml . '</td>';

    if ($tutorSubject['SCHOOLTYPE'] == 0) {
        $i++;
        $_table0_tds .= $_table_td;
        if ($i % $_numCol == 0) {
            $_table0 .= '<tr>' . $_table0_tds . '</tr>'; // agregar fila a la table
            $_table0_tds = ""; // abri una nueva fila
        }
    } elseif ($tutorSubject['SCHOOLTYPE'] == 1) {
        $j++;
        $_table1_tds .= $_table_td;
        if ($j % $_numCol == 0) {
            $_table1 .= '<tr>' . $_table1_tds . '</tr>';
            $_table1_tds = "";
        }
    } elseif ($tutorSubject['SCHOOLTYPE'] == 2) {
        $k++;
        $_table2_tds .= $_table_td;
        if ($k % $_numCol == 0) {
            $_table2 .= '<tr>' . $_table2_tds . '</tr>';
            $_table2_tds = "";
        }
    }
}
// rellenar.

$_count0 = $_numCol - intval($i % $_numCol);
for ($index = 0; $index < $_count0; $index++) {
    $_table0_tds .= '<td width="30%">&nbsp;</td>';
}
$_table0 .= ($i % $_numCol == 0 ) ? "" : '<tr>' . $_table0_tds . '</tr>';

$_count1 = $_numCol - intval($j % $_numCol);
for ($index = 0; $index < $_count1; $index++) {
    $_table1_tds .= '<td width="30%">&nbsp;</td>';
}
$_table1 .= ($j % $_numCol == 0 ) ? "" : '<tr>' . $_table1_tds . '</tr>';

$_count2 = $_numCol - intval($k % $_numCol);
for ($index = 0; $index < $_count2; $index++) {
    $_table2_tds .= '<td width="30%">&nbsp;</td>';
}
$_table2 .= ($k % $_numCol == 0 ) ? "" : '<tr>' . $_table2_tds . '</tr>';
?>

<div>
    <style>
        .acs td{
            text-align: left;
        }
    </style>
</div>


<div  class="seccion1 form form-horizontal one">

    <form id="form_filter" class="">                       
        <div>
            <select id="fieldSelect" name="field" onchange="submit()">                    
                <option value="0"><?php echo $fieldList[0]; ?></option>
                <option value="1"><?php echo $fieldList[1]; ?></option>
                <option value="2"><?php echo $fieldList[2]; ?></option>
                <option value="3"><?php echo $fieldList[3]; ?></option>
            </select>            
        </div>           
    </form>   
</div>
<br>
<h3><?php echo $fieldList[$field]; ?></h3>
<div class="clearfix divider_dashed3"></div>

<div class="seccion2">
    <strong><?php echo $schoolTypeList[0]; ?></strong>
    <div class="table-style">
        <table class="table-list table-condensed acs">  
            <?php echo $_table0; ?>
        </table>
    </div>
</div>

<div class="seccion3">
    <strong><?php echo $schoolTypeList[1]; ?></strong>
    <div class="table-style">
        <table class="table-list table-condensed acs">  
            <?php echo $_table1; ?>&nbsp;
        </table>
    </div>
</div>

<div class="seccion4">
    <strong><?php echo $schoolTypeList[2]; ?></strong>
    <div class="table-style">
        <table class="table-list table-condensed acs">  
            <?php echo $_table2; ?>&nbsp;
        </table>
    </div>
</div>

<div class="clearfix divider_dashed3"></div>

<div class="formulario">
    <form id="form_registrar_subjects" action="tutor-subjects-register-save.php">
        <input type="submit" value="submit">
    </form>
</div>

