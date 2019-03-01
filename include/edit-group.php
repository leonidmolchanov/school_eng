<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/02/2019
 * Time: 02:52
 */
global $USER;
$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "GROUP",
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
$PROP["TEACHER"] = $_REQUEST["teacherGroup"];  // учитель для группы
$PROP["LESSON_COST"] = $_REQUEST["lessoncost"];
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $iblockid,
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => $_REQUEST['nameGroup'],
    "ACTIVE"         => "Y"
);

if($el->Update($_REQUEST['id'],$arLoadProductArray))
    $request = 'Success';
else
    $request = 'Error'.$_REQUEST["name"];

echo json_encode($request);
?>