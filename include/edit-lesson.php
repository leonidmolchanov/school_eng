<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 05/12/2018
 * Time: 00:32
 */
$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "LESSON",
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
$PROP["AUDITORIUM"] = $_REQUEST["auditorium"];  // учитель для группы
$PROP["FROM"] = date("d.m.Y H:i", strtotime($_REQUEST["date"].$_REQUEST["from"]));  // учитель для группы
$PROP["TO"] = date("d.m.Y H:i", strtotime($_REQUEST["date"].$_REQUEST["to"]));
$PROP["GROUP"] = $_REQUEST["group"];  // учитель для группы
$PROP["COST"] = $_REQUEST['cost'];
if($_REQUEST['repeat']=='false'){
    $PROP["REPEAT"]  = 0;
}
else{
    $PROP["REPEAT"]  = 1;
}
if($_REQUEST['sub']=='false'){
    $PROP["SUB"]  = 0;
}
else{
    $PROP["SUB"]  = 1;
}
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $iblockid,
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => $_REQUEST["name"],
    "ACTIVE"         => "Y"
);

if($el->Update($_REQUEST['idLesson'],$arLoadProductArray))
    $request = 'Success';
else
    $request = 'Error'.$_REQUEST["name"];

echo json_encode($request);
?>