<?php

function uploadAttachDocument($studentCode, $lessonRequestNumber) {

    $_attachDocument = NULL;
    
    $studentDir = "students/assignments/";
    if (empty($studentCode) || empty($lessonRequestNumber)) {
        return;
    }
    if (isset($_FILES['form_attach_document'])) {
        $fileName = basename($_FILES["form_attach_document"]["name"]);
        $fullFileName = $studentCode . '-' . $lessonRequestNumber . '-' . $fileName;
        $targetFile = $studentDir . $fullFileName;
        move_uploaded_file($_FILES['form_attach_document']['tmp_name'], $targetFile);
    }
    $_attachDocument = $fullFileName;
    return $_attachDocument;
}

function updateLessonRequest($conn,$code,$rate, $attachDocument, $problemComments, $estimateTime, 
							$dueDate, 
                            $availabilityOption1 = NULL, $availabilityOption2 = NULL,
                            $availabilityTime1 = NULL, $availabilityTime2 = NULL) {                                 
    $_param_code = "'".$code."'";
    $_param_rate = "'".$rate."'";
    $_param_attachDocument = "'".$attachDocument."'";
    $_param_problemComments = "'".$problemComments."'";
    $_param_estimatedTime = "'".$estimateTime."'";
    $_param_dueDate = "'".$dueDate."'";
    $_param_availabilityOption1 = "'".$availabilityOption1."'";
    $_param_availabilityOption2 = "'".$availabilityOption2."'";
	$_param_availabilityTime1 = "'".$availabilityTime1."'";
    $_param_availabilityTime2 = "'".$availabilityTime2."'";
    
    $sqlQuery = "UPDATE `LESSONREQUESTS2`
SET 
 `RATE` = $_param_rate,
 `ATTACH_DOCUMENT` = $_param_attachDocument,
 `PROBLEM_COMMENTS` = $_param_problemComments,
 `ESTIMATED_TIME` = $_param_estimatedTime,
 `DUE_DATE` = $_param_dueDate,
 `AVAILABILITY_OPTION1` = $_param_availabilityOption1,
 `AVAILABILITY_OPTION2` = $_param_availabilityOption2,
 `AVAILABILITY_TIME1` = $_param_availabilityTime1,
 `AVAILABILITY_TIME2` = $_param_availabilityTime2 
WHERE
	(`CODE` = $_param_code) LIMIT 1";
    
    genesis_exec($conn,$sqlQuery);
}
