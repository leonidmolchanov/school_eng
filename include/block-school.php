<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 22/02/2019
 * Time: 01:08
 */
$PROPERTY_CODE = "BLOCK";
if($_REQUEST['add']=='true') {
    $query = CIBlockElement::SetPropertyValuesEx($_REQUEST['id'], false, array($PROPERTY_CODE => 1));
}
else{
    $query = CIBlockElement::SetPropertyValuesEx($_REQUEST['id'], false, array($PROPERTY_CODE => 0));

}
    $request = 'Success';


echo json_encode($request);

