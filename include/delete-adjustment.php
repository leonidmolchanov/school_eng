<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 09/01/2019
 * Time: 23:00
 */

$DB->StartTransaction();
if(!CIBlockElement::Delete($_REQUEST["id"]))
{
    $request='error';
    $strWarning .= 'Error!';
    $DB->Rollback();
}
else
    $DB->Commit();
$request='Success';
//}
echo json_encode($request);
?>