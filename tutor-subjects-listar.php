<?php
require_once ("conexion/conexion.php");

if (!function_exists("createSqlQueryTutorSubjetList")) {

    function createSqlQueryTutorSubjetList($userCode, $field = false, $schoolType = false) {
        $sqlQuery = "SELECT
                        ts.*, s.DESCRIPTION
                     FROM `TUTORS_SUBJECTS` ts
                        INNER JOIN SUBJECTS s ON s.SUBJECTCODE = ts.`SUBJECT`
                        WHERE ts.USERCODE = '" . $userCode . "'"
//                . " and ts.FIELD = '" . $field . "'"
//                . " and ts.SCHOOLTYPE = '" . $schoolType . "'"
                . ' order by s.FIELD,s.SCHOOLTYPE, s.DESCRIPTION';

        return $sqlQuery;
    }

}



if (!function_exists("getTutorSubjectList")) {

    function getTutorSubjectList($userCode, $field = false, $schoolType = false) {

        $resultArray = array();

        if (empty($userCode) || intval($userCode) < 0) {
            goto _return;
        }

        $conex = openDB();

        $sqlQuery = createSqlQueryTutorSubjetList($userCode, $field, $schoolType);
        $result = genesis_exec($conex, $sqlQuery);

        if (!empty($result) && genesis_num_rows($result) > 0) {
            while (($row = genesis_fetch_row($result))) {
                array_push($resultArray, $row);
            }
        }

        closeDB($conex);

        _return:

        return $resultArray;
    }

}

//models

$schoolTypeList = $SCHOOLTYPE_LIST;
$fieldList = $FIELDS_LIST;

$codUsuario = $_SESSION['COD'];
$userCode = $codUsuario;

//request

$field = filter_input(INPUT_GET, 'field');
$school = filter_input(INPUT_GET, 'school');

$tutorSubjectList = getTutorSubjectList($userCode, $school);

//parse results
$str1 = <<<EOF
        <tr>
            <th>FIELD</th>           
             <th>SUBJECT</th>
        </tr> 
EOF;
$str2 = $str1;
$str3 = $str2;
$i = 0;
$j = 0;
$k = 0;

foreach ($tutorSubjectList as $tutorSubject) {

    $_row = <<<EOF
                <tr>
                    <td>{$fieldList[$tutorSubject['FIELD']]}</td>                   
                    <td>{$tutorSubject['DESCRIPTION']}</td>
                </tr>
EOF;

    if ($tutorSubject['SCHOOLTYPE'] == 0) {
        $str1 .= $_row;
        $i++;
    } elseif ($tutorSubject['SCHOOLTYPE'] == 1) {
        $str2 .= $_row;
        $j++;
    } elseif ($tutorSubject['SCHOOLTYPE'] == 2) {
        $str3 .= $_row;
        $k++;
    }
}
?>

<div>
    <a class="but_plus" href="tutor-subjects.html?field=0"><i class="fa fa-plus"></i>&nbsp;Add</a>
    <br>
    <br>
</div>

<ul class="tabs2">
    <li><a href="#example-2-tab-1" target="_self"><?php echo $schoolTypeList[0] . ' (' . $i . ')'; ?></a></li>
    <li><a href="#example-2-tab-2" target="_self"><?php echo $schoolTypeList[1] . ' (' . $j . ')'; ?></a></li>
    <li><a href="#example-2-tab-3" target="_self"><?php echo $schoolTypeList[2] . ' (' . $k . ')'; ?></a></li>
    <li style="visibility: hidden"><a href="" target="_self">&nbsp;</a></li>   
</ul>

<div class="tabs-content2 fullw">

    <div id="example-2-tab-1" class="tabs-panel2">
        <div class="table-style">
            <table class="table-list table-condensed">                             
                <?php echo $str1; ?>
            </table>
        </div>
    </div><!-- end tab 1 -->

    <div id="example-2-tab-2" class="tabs-panel2">
        <div class="table-style">
            <table class="table-list table-condensed">                             
                <?php echo $str2; ?>
            </table>
        </div>
    </div><!-- end tab 2 -->

    <div id="example-2-tab-3" class="tabs-panel2">
        <div class="one_full">            
            <div class="table-style">
                <table class="table-list table-condensed">                                
                    <?php echo $str3; ?>
                </table>
            </div>
        </div>
    </div><!-- end tab 3 -->
</div>