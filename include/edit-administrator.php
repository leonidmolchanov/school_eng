<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 08/01/2019
 * Time: 20:11
 */

global $USER;


$balance=0;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'ADMINISTRATOR', 'ID'=>$_REQUEST['elementid'],
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_BIRTHDAY','PROPERTY_USER')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $birthday=date($ar_fields['PROPERTY_BIRTHDAY_VALUE']);
        $userid=$ar_fields['PROPERTY_USER_VALUE'];

    }
endif;

$el = new CIBlockElement;

$PROP = array();
$PROP["NAME"] = $_REQUEST['name'];
$PROP["LAST_NAME"] = $_REQUEST['lastname'];
$PROP["SECOND_NAME"] = $_REQUEST['secondname'];
$PROP["BIRTHDAY"] = $birthday;
$PROP["USER"] = $userid;
//$PROP["DESCRIPTION"] = $_REQUEST['comments'];
$PROP["TEL"] = $_REQUEST['tel'];
$PROP["STATUS"] = $_REQUEST['status'];
$PROP['SCHOOL_ID']=$schoolID;

$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $_REQUEST['iblockid'],
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => $_REQUEST['elementname'],
    "ACTIVE"         => "Y"
);

if($el->Update($_REQUEST['elementid'],$arLoadProductArray))
    $request = 'success';
else
    $request = 'Error'.$_REQUEST["name"];

echo json_encode($request);

?>