<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 04/12/2018
 * Time: 00:04
 */
// Получаем список групп

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

$arLoadProductArray = Array(
  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
  "IBLOCK_ID"      => $iblockid,
  "PROPERTY_VALUES"=> $PROP,
  "NAME"           => $_REQUEST["nameGroup"],
  "ACTIVE"         => "Y"
  );

if($PRODUCT_ID = $el->Add($arLoadProductArray))
    $request = 'Success';
else
    $request = 'Error';

echo json_encode($request);
?>