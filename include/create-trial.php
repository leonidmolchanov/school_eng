<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 04/12/2018
 * Time: 00:04
 */
// Получаем id iblock c уроками

$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "TRIAL",
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
$PROP["NAME"] = $_REQUEST["name"];  // учитель для группы
$PROP["FAMILY_NAME"] = $_REQUEST["familyName"];
$PROP["AGE"] = $_REQUEST["age"];
$PROP["DATE"] = date("d.m.Y", strtotime($_REQUEST["date"]));
$PROP["TEL"] = $_REQUEST['tel'];
$PROP["SOURCE"] = $_REQUEST['source'];
$PROP["TEACHER_ID"] = $_REQUEST['teacherId'];
$PROP["AUDITORIUM_ID"] = $_REQUEST['auditoriumId'];
$PROP["DATE_LESSON"] = date("d.m.Y H:i", strtotime($_REQUEST["dateLesson"]." ".$_REQUEST["timeLesson"]));
$PROP['SCHOOL_ID']=$schoolID;

$PROP["STATUS"] = 0;

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