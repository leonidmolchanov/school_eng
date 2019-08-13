<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 12/12/2018
 * Time: 03:05
 */


$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "TEACHER",
            "CHECK_PERMISSIONS" => "N"
        )
    );
    while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
    {
        $iblockid = $arIBlock["ID"];

    }
}

$code="TEACHER";
function GetGroupByCode ($code)
{
    $rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("STRING_ID" => $code));
    return $rsGroups->Fetch();
}
$id =  GetGroupByCode ($code);
$id = $id["ID"];
$user = new CUser;
$date = date('d.m.Y', strtotime($_REQUEST["birth"]));
$arFields = Array(
    "NAME"              => $_REQUEST['name'],
    "LAST_NAME"         => $_REQUEST['lastName'],
    "EMAIL"             => $_REQUEST['email'],
    "LOGIN"             => $_REQUEST['login'],
    "LID"               => "ru",
    "ACTIVE"            => "Y",
    "PERSONAL_BIRTHDAY" => $date,
    "PERSONAL_PHONE" => $_REQUEST["tel"],
    "GROUP_ID"          => array($id),
    "PASSWORD"          => $_REQUEST['password'],
    "CONFIRM_PASSWORD"  => $_REQUEST['passwordConfirm'],
);

$ID = $user->Add($arFields);
if (intval($ID) > 0):
    $responce = "success";


    $el = new CIBlockElement;

    $PROP = array();
    $PROP["NAME"] = $_REQUEST["name"];
    $PROP["LAST_NAME"] = $_REQUEST["lastName"];
    $PROP["SECOND_NAME"] = $_REQUEST["secondName"];
    $PROP["BIRTHDAY"] = $date;
    $PROP["TEL"] = $_REQUEST["tel"];
    $PROP["USER"] = $ID;
    $PROP['SCHOOL_ID']= $schoolID;

    $arLoadProductArray = Array(
        "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
        "IBLOCK_ID"      => $iblockid,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $_REQUEST["name"],
        "ACTIVE"         => "Y"
    );

    if($PRODUCT_ID = $el->Add($arLoadProductArray)){

        $user = new CUser;
        $fields = Array(
            "UF_SCHOOL_ID"          => $schoolID,
        );
        $user->Update($ID, $fields);
        $strError .= $user->LAST_ERROR;
        if($strError) {
            $request = 'Error';
        }
        else{
            $request = 'Success';}}
    else {
        $request = 'Error';
    }


else:
    $responce =  $user->LAST_ERROR;
endif;
echo json_encode($responce);
?>