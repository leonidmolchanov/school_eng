<?php

// создадим массив описывающий изображение
// находящееся в файле на сервере

$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "STUDENTS",
            "CHECK_PERMISSIONS" => "N"
        )
    );
    while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
    {
        $iblockid = $arIBlock["ID"];

    }
}

$code="STUDENTS";
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
    "LOGIN"             => $_REQUEST['dogovor'],
    "PERSONAL_BIRTHDAY" => $date,
    "LID"               => "ru",
    "ACTIVE"            => "Y",
    "GROUP_ID"          => array($id),
    "PASSWORD"          => $_REQUEST['password'],
    "CONFIRM_PASSWORD"  => $_REQUEST['passwordConfirm'],
);

$ID = $user->Add($arFields);
if (intval($ID) > 0):
    $responce = "success";


    $el = new CIBlockElement;

    $PROP = array();
    $PROP["DOGOVOR"] = $_REQUEST["dogovor"];
    $PROP["NAME"] = $_REQUEST["name"];
    $PROP["LAST_NAME"] = $_REQUEST["lastName"];
    $PROP["SECOND_NAME"] = $_REQUEST["secondName"];
    $PROP["BIRTHDAY"] = $date;
    $PROP["TEL"] = $_REQUEST["tel"];
    $PROP["FATHER_NAME"] = $_REQUEST["fatherName"];
    $PROP["FATHER_LAST_NAME"] = $_REQUEST["fatherLastName"];
    $PROP["FATHER_SECOND_NAME"] = $_REQUEST["fatherSecondName"];
    $PROP["FATHER_TEL"] = $_REQUEST["fatherTel"];
    $PROP["MOTHER_NAME"] = $_REQUEST["motherName"];
    $PROP["MOTHER_SECOND_NAME"] = $_REQUEST["motherSecondName"];
    $PROP["MOTHER_LAST_NAME"] = $_REQUEST["motherLastName"];
    $PROP["MOTHER_TEL"] = $_REQUEST["motherTel"];
    $PROP["COMMENTS"] = $_REQUEST["comments"];
    $PROP["STATUS"] = 1;
    $PROP["USERID"] = $ID;
    $PROP["LESSON_BALANCE"]=0;
    $arLoadProductArray = Array(
        "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
        "IBLOCK_ID"      => $iblockid,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $_REQUEST["dogovor"],
        "ACTIVE"         => "Y"
    );

    if($PRODUCT_ID = $el->Add($arLoadProductArray))
        $request = 'Success';
    else
        $request = 'Error';



else:
    $responce =  $user->LAST_ERROR;
endif;
echo json_encode($responce);
?>