<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 04/02/2019
 * Time: 01:42
 */

$user = new CUser;
$fields = Array(
    "PASSWORD"          => $_REQUEST['password'],
    "CONFIRM_PASSWORD"  => $_REQUEST['password'],
);
$user->Update($_REQUEST['id'], $fields);
$strError .= $user->LAST_ERROR;
if($strError) {
    $strError=strip_tags($strError);
    echo json_encode($strError);
}
else{
    echo json_encode('success');
}
?>