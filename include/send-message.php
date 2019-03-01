<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 21/02/2019
 * Time: 04:59
 */

$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "CHAT",
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
$PROP["TEXT"] = $_REQUEST["text"];  // учитель для группы
$PROP["FROM_ID"] = $USER->GetID();  // учитель для группы
if($_REQUEST["to"]){
    $PROP["TO_ID"] = $_REQUEST["to"];  // учитель для группы
}
else{
    $PROP["TO_ID"] = 1;
}
$arLoadProductArray = Array(
    "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $iblockid,
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => 'message',
    "ACTIVE"         => "Y"
);

if($PRODUCT_ID = $el->Add($arLoadProductArray))
    $request = 'Success';
CModule::IncludeModule('pull');
if(CModule::IncludeModule('pull')) {
    CPullStack::AddByUser(
        $PROP["TO_ID"], Array(
            'module_id' => 'message',
            'command' => 'check',
            'params' => Array(),
        )
    );
}
else
    $request = 'Error';

echo json_encode($request);
?>