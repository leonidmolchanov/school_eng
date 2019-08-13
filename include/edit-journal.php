<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 19/01/2019
 * Time: 18:11
 */
$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "JOURNAL",
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
$PROP['SCHOOL_ID']=$schoolID;
if(!empty(json_decode($_REQUEST['be']))):
$PROP["BE"] = json_decode($_REQUEST['be']);
endif;
if(!empty(json_decode($_REQUEST['notbe']))):
$PROP["NOTBE"] = json_decode($_REQUEST['notbe']);
endif;
if(!empty(json_decode($_REQUEST['disease']))):
$PROP["DISEASE"] = json_decode($_REQUEST['disease']);
endif;
$PROP["GROUPID"]  = json_decode($_REQUEST['groupid']);
$PROP["LESSONID"] = json_decode($_REQUEST['lessonid']);
$PROP["SUB"] = json_decode($_REQUEST['sub']);
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $iblockid,
    "PROPERTY_VALUES"=> $PROP,
    "ACTIVE"         => "Y"
);

if($el->Update($_REQUEST['id'],$arLoadProductArray))
    $request = 'Success';
else
    $request = 'Error';

if($_REQUEST['adj']):
    $iblockid=0;
    if(CModule::IncludeModule("iblock"))
    {

        $ib_list = CIBlock::GetList(
            Array(),
            Array(
                "CODE" => "ADJUSTMENT",
                "CHECK_PERMISSIONS" => "N"
            )
        );
        while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
        {
            $iblockid = $arIBlock["ID"];

        }
    }
    $adj = json_decode($_REQUEST['adj']);
foreach ($adj as $item){

    $ELEMENT_ID = $item->id;  // код элемента
    $PROPERTY_CODE = "STATUS";  // код свойства
    $PROPERTY_VALUE = $item->status;  // значение свойства

// Установим новое значение для данного свойства данного элемента
    CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
}


endif;

echo json_encode($request);
?>