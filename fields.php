<?php
require_once ("conexion/conexion.php");

$con = openDB();

$ui_no_subject = "<h3>No Subject</h3>";

$FIELD_ID = (isset($FIELD_ID)) ? intval($FIELD_ID) : 0;
?>
<div id="tab1" class="subjects1" >
    <div class="container"><h3><strong>High School Subjects</strong></h3></div>
    <div class="container">
        <div width=100%  style="width=100%;">
            <table width=100% border=0>
                <tr>
                    <?php
                    $result_0 = genesis_exec($con, "SELECT * FROM SUBJECTS WHERE FIELD = '" . $FIELD_ID . "' AND SCHOOLTYPE = 0");
                    $nun_rows_0 = genesis_num_rows($result_0);
                    $mid_nun_row_0 = ceil($nun_rows_0 / 2);
                    if ($nun_rows_0 > 0) {
                        ?>
                        <td width=50%>	
                            <div width=100%>
                                <ul>
                                    <?php
                                    for ($i = 0; $i < $mid_nun_row_0; $i++) {
                                        $row = genesis_fetch_row($result_0);
                                        $subject = genesis_result($result_0, 'subjectcode');
                                        ?>
                                        <li class="icon2"><i class="fa fa-check"></i></li>
                                        <h4>
                                        <a href="javascript:cargarTutores(0,<?=$FIELD_ID?>,<?=$subject?>,'tutoresUno')">
                                            <?php echo genesis_result($result_0, 'DESCRIPTION') ?>&nbsp;
                                        </a>    
                                        </h4>
                                        <br>                                       
                                    <?php } ?>
                                </ul>
                            </div>
                        </td>
                        <td width=50%>	
                            <div width=100%>
                                <ul>
                                    <?php
                                    for ($i = $mid_nun_row_0; $i < $nun_rows_0; $i++) {
                                        $row = genesis_fetch_row($result_0);
                                        $subject = genesis_result($result_0, 'subjectcode');
                                        ?>
                                        <li class="icon2"><i class="fa fa-check"></i></li>
                                        
                                        <h4>
                                        <a href="javascript:cargarTutores(0,<?=$FIELD_ID?>,<?=$subject?>,'tutoresUno')">
                                            <?php echo genesis_result($result_0, 'DESCRIPTION') ?>&nbsp;
                                        </a>
                                        </h4>
                                        <br>                                       
                                    <?php } ?>
                                    <?php if ($nun_rows_0 % 2 > 0) { ?>
                                        <li style="visibility: hidden" class="icon2"><i class="fa fa-check"></i></li><h4 style="visibility: hidden">Relleno...&nbsp;</h4>
                                        <br>
                                    <?php } ?>
                                </ul>
                            </div>
                           
                        </td>
                    <?php } else { ?>
                        <td><?php echo $ui_no_subject; ?></td>
                    <?php } ?>   
                    
                </tr>
                <tr><td colspan="2">
                        <div id="tutoresUno"></div>
                </td></tr>                 
            </table>
            <div></div>
        </div>
    </div>
</div>
<div id="tab2" class="subjects2">
    <div class="container"><h3><strong>College Subjects</strong></h3></div>
    <div class="container">
        <div width=100%  style="width=100%;">
            <table width=100% border=0>
                <tr>
                    <?php
                    $result_0 = genesis_exec($con, "SELECT * FROM SUBJECTS WHERE FIELD = '" . $FIELD_ID . "' AND SCHOOLTYPE = 1");
                    $nun_rows_0 = genesis_num_rows($result_0);
                    $mid_nun_row_0 = ceil($nun_rows_0 / 2);
                    if ($nun_rows_0 > 0) {
                        ?>
                        <td width=50%>	
                            <div width=100%>
                                <ul>
                                    <?php
                                    for ($i = 0; $i < $mid_nun_row_0; $i++) {
                                        $row = genesis_fetch_row($result_0);
                                        $subject = genesis_result($result_0, 'subjectcode');
                                        ?>
                                        <li class="icon2"><i class="fa fa-check"></i></li>
                                        <h4>
                                        <a href="javascript:cargarTutores(1,<?=$FIELD_ID?>,<?=$subject?>,'tutoresDos')">
                                            <?php echo genesis_result($result_0, 'DESCRIPTION') ?>&nbsp;
                                        </a>    
                                        </h4>

                                        <br>                                       
                                    <?php } ?>
                                </ul>
                            </div>
                        </td>
                        <td width=50%>	
                            <div width=100%>
                                <ul>
                                    <?php
                                    for ($i = $mid_nun_row_0; $i < $nun_rows_0; $i++) {
                                        $row = genesis_fetch_row($result_0);
                                        $subject = genesis_result($result_0, 'subjectcode');
                                        ?>
                                        <li class="icon2"><i class="fa fa-check"></i></li>
                                        <h4>
                                        <a href="javascript:cargarTutores(1,<?=$FIELD_ID?>,<?=$subject?>,'tutoresDos')">
                                            <?php echo genesis_result($result_0, 'DESCRIPTION') ?>&nbsp;
                                        </a>    
                                        </h4>
                                        <br>                                       
                                    <?php } ?>
                                    <?php if ($nun_rows_0 % 2 > 0) { ?>
                                        <li style="visibility: hidden" class="icon2"><i class="fa fa-check"></i></li><h4 style="visibility: hidden">Relleno...&nbsp;</h4>
                                        <br>
                                    <?php } ?>
                                </ul>
                            </div>
                        </td>

                    <?php } else { ?>
                        <td><?php echo $ui_no_subject; ?></td>
                    <?php } ?>                    
                </tr>
                <tr><td colspan="2">
                        <div id="tutoresDos"></div>
                </td></tr>
            </table>
            <div></div>
        </div>
    </div>
</div>
<div id="tab3" class="subjects3">
    <div class="container"><h3><strong>Graduate School Subjects</strong></h3></div>
    <div class="container">
        <div width=100%  style="width=100%;">
            <table width=100% border=0>
                <tr>
                    <?php
                    $result_0 = genesis_exec($con, "SELECT * FROM SUBJECTS WHERE FIELD = '" . $FIELD_ID . "' AND SCHOOLTYPE = 2");
                    $nun_rows_0 = genesis_num_rows($result_0);
                    $mid_nun_row_0 = ceil($nun_rows_0 / 2);
                    // $_style = ($nun_rows_0 % 2 > 0) ? 'style="visibility: hidden"' : "";

                    if ($nun_rows_0 > 0) {
                        ?>
                        <td width=50%>	
                            <div width=100%>
                                <ul>
                                    <?php
                                    for ($i = 0; $i < $mid_nun_row_0; $i++) {
                                        $row = genesis_fetch_row($result_0);
                                        $subject = genesis_result($result_0, 'subjectcode');
                                        ?>
                                        <li class="icon2"><i class="fa fa-check"></i></li>
                                        <h4>
                                        <a href="javascript:cargarTutores(2,<?=$FIELD_ID?>,<?=$subject?>,'tutoresTres')">
                                            <?php echo genesis_result($result_0, 'DESCRIPTION') ?>&nbsp;
                                        </a>    
                                        </h4>
                                        <br>                                       
                                    <?php } ?>                                    
                                </ul>
                            </div>
                        </td>
                        <td width=50%>	
                            <div width=100%>
                                <ul>
                                    <?php
                                    for ($i = $mid_nun_row_0; $i < $nun_rows_0; $i++) {
                                        $row = genesis_fetch_row($result_0);
                                        $subject = genesis_result($result_0, 'subjectcode');
                                        ?>
                                        <li class="icon2"><i class="fa fa-check"></i></li>
                                        <h4>
                                        <a href="javascript:cargarTutores(2,<?=$FIELD_ID?>,<?=$subject?>,'tutoresTres')">
                                            <?php echo genesis_result($result_0, 'DESCRIPTION') ?>&nbsp;
                                        </a>    
                                        </h4>
                                        
                                        <br>                                       
                                    <?php } ?>
                                    <?php if ($nun_rows_0 % 2 > 0) { ?>
                                        <li style="visibility: hidden" class="icon2"><i class="fa fa-check"></i></li><h4 style="visibility: hidden">Relleno...&nbsp;</h4>
                                        <br>
                                    <?php } ?>
                                </ul>
                            </div>
                        </td>
                    <?php } else { ?>
                        <td><?php echo $ui_no_subject; ?></td>
                    <?php } ?>                    
                </tr>
                <tr><td colspan="2">
                        <div id="tutoresTres"></div>
                </td></tr>
            </table>
            <div></div>
        </div>
    </div>
</div>
<?php
closeDB($con);
