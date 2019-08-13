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
            "CODE" => "FRANCHISEE",
            "CHECK_PERMISSIONS" => "N"
        )
    );
    while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
    {
        $iblockid = $arIBlock["ID"];

    }
}

$code="FRANCHISEE";
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

    else:
        $request = 'Error';
endif;

echo json_encode($responce);
?>