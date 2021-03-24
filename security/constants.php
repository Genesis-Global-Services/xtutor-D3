<?php
//$RATE=9;  //rate for 30 minutes
$RELOAD=300000; //in miliseconds
$MAXINACTIVETIME=120; //120 secs=2 minutes
$MAXWAITINGTIME=60; // this is the time tutor will wait the student to enter the lesson (update this if the student needs to click a button to enter the lesson)
$MAXWAITINGTIMEFORSTUDENT = 60;

$FIELDS_LIST[0]="Mathematics/Statistics";
$FIELDS_LIST[1]="Natural Sciences";
$FIELDS_LIST[2]="Social Sciences";
$FIELDS_LIST[3]="English/Literature";

//REQUEST STATUS
$REQUESTSTATUS_LIST[0]="Lesson requested";
$REQUESTSTATUS_LIST[1]="Tutor accepted";
$REQUESTSTATUS_LIST[2]="Lesson in progress";    //LESSON STARTED=IN PROGRESS
$REQUESTSTATUS_LIST[3]="Lesson terminated";
$REQUESTSTATUS_LIST[4]="Request canceled";

$GENDER_LIST[0]="Male";
$GENDER_LIST[1]="Female";
$GENDER_LIST[2]="Non disclosed";


$SCHOOLTYPE_LIST[0]="High School";
$SCHOOLTYPE_LIST[1]="College undergrad";
$SCHOOLTYPE_LIST[2]="Graduate college";


$TUTOR_LEVEL[0]="College student";
$TUTOR_LEVEL[1]="College graduate";
$TUTOR_LEVEL[2]="Graduate student";
$TUTOR_LEVEL[3]="Master degree";
$TUTOR_LEVEL[4]="Doctorate degree";



$WHITEBOARD="TWIDDLA";  
//$WHITEBOARD="LIVEBOARD";
$SHOWSTARTBUTTON = FALSE;

$BLUE= "#222848";
$GREEN = "#7AB700";

$LESSON_TYPE[0]="Instant lesson";
$LESSON_TYPE[1]="Scheduled lesson";
//$LESSON_TYPE[1]="Written solution";
//$LESSON_TYPE[3]="Written lesson";

$LESSON_RATE_FACTOR[0]=1;
$LESSON_RATE_FACTOR[1]=1;
//$LESSON_RATE_FACTOR[1]=1.1;
//$LESSON_RATE_FACTOR[2]=1.5;
//$LESSON_RATE_FACTOR[3]=2;


// LEVEL STUDENT.   MAE. 09/06/2020 Se agregan los clasificadores para el nivel del estudiante
$LEVELSTUDENT_LIST[0]="Beginner";
$LEVELSTUDENT_LIST[1]="Advanced";

?>