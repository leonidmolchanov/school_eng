<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 22/02/2019
 * Time: 01:08
 */
$PROPERTY_CODE = "COLOR";
$query  = CIBlockElement::SetPropertyValuesEx($_REQUEST['id'], false, array($PROPERTY_CODE => $_REQUEST['color']));

    $request = 'Success';


echo json_encode($request);

