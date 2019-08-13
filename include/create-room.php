<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 10/12/2018
 * Time: 04:46
 */

$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "AUDITORIUM",
            "CHECK_PERMISSIONS" => "N"
        )
    );
    while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
    {
        $iblockid = $arIBlock["ID"];

    }
}
$el = new CIBlockElement;

$PROP = array();
$PROP["COLOR"] = $_REQUEST["color"];  // учитель для группы
$PROP['SCHOOL_ID']=$schoolID;
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $iblockid,
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => $_REQUEST["name"],
    "ACTIVE"         => "Y"
);

if($PRODUCT_ID = $el->Add($arLoadProductArray))
    $request = 'Success';
else
    $request = 'Error'.$_REQUEST["name"];

echo json_encode($request);
?>