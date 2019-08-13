<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 10/12/2018
 * Time: 04:46
 */
global $USER;

$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "SCHOOL",
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
$PROP["ADDRESS"] = $_REQUEST["schooladdress"];
$PROP["PHONE"] = $_REQUEST["schoolphone"];
$PROP["EMAIl"] = $_REQUEST["schoolemail"];
$PROP["MASTER_FIO"] = $_REQUEST["schoolfioperson"];
$PROP["MASTER_PHONE"] = $_REQUEST["schoolphoneperson"];
$PROP["MASTER_EMAIL"] = $_REQUEST["schoolemailperson"];
if($_REQUEST["franchid"]) {





    $PROP['MASTER_ID'] = $_REQUEST["franchid"];
}
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $iblockid,
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => $_REQUEST["schoolname"],
    "ACTIVE"         => "Y"
);

if($PRODUCT_ID = $el->Add($arLoadProductArray)) {
    $request = 'Success';


    $user = new CUser;
    $fields = Array(
        "UF_SCHOOL_ID" => $PRODUCT_ID,
    );
    $user->Update($_REQUEST["franchid"], $fields);

}
else {
    $request = 'Error' . $_REQUEST["name"];
}
echo json_encode($request);
?>