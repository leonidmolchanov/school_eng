<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 08/01/2019
 * Time: 20:11
 */

global $USER;


$elem=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'SCHOOL', 'ID'=>$_REQUEST['id']),
        false,
        false,
        Array('ID','IBLOCK_ID', 'PROPERTY_MASTER_ID','PROPERTY_BLOCK')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $elem=$ar_fields;
    }
endif;

$el = new CIBlockElement;

$PROP = array();
$PROP["ADDRESS"] = $_REQUEST['address'];
$PROP["PHONE"] = $_REQUEST['name'];
$PROP["EMAIL"] = $_REQUEST['email'];
$PROP["MASTER_FIO"] = $_REQUEST['fioperson'];
$PROP["MASTER_PHONE"] = $_REQUEST['phoneperson'];
$PROP["MASTER_EMAIL"] = $_REQUEST['emailperson'];
$PROP["MASTER_ID"] = $elem['PROPERTY_MASTER_ID_VALUE'];
$PROP["BLOCK"] = $elem['PROPERTY_BLOCK_VALUE'];
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $elem['IBLOCK_ID'],
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => $_REQUEST['name'],
    "ACTIVE"         => "Y"
);

if($el->Update($_REQUEST['id'],$arLoadProductArray))
    $request = 'Success';
else
    $request = 'Error'.$_REQUEST["name"];

echo json_encode($request);

?>