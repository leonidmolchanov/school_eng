<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 04/02/2019
 * Time: 01:42
 */
global $USER;
$user = new CUser;
$fields = Array(
    "UF_SCHOOL_ID"          => $_REQUEST['id'],
);
$user->Update($USER->GetID(), $fields);
$strError .= $user->LAST_ERROR;
if($strError) {
    $strError=strip_tags($strError);
    echo json_encode($strError);
}
else{
    echo json_encode('success');
}
?>