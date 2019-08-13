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

if(!$_REQUEST["broadcast"]){
$el = new CIBlockElement;

$PROP = array();
    $PROP['SCHOOL_ID']=$schoolID;

$PROP["TEXT"] = $_REQUEST["text"];  // учитель для группы
$PROP["FROM_ID"] = $USER->GetID();  // учитель для группы
if ($_REQUEST["to"]) {
    $PROP["TO_ID"] = $_REQUEST["to"];  // учитель для группы
} else {
    $PROP["TO_ID"] = 1;
}
$arLoadProductArray = Array(
    "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID" => $iblockid,
    "PROPERTY_VALUES" => $PROP,
    "NAME" => 'message',
    "ACTIVE" => "Y"
);

if ($PRODUCT_ID = $el->Add($arLoadProductArray))
    $request = 'Success';
CModule::IncludeModule('pull');
if (CModule::IncludeModule('pull')) {
    $dbUser = CUser::GetByID($USER->GetID());
    $arUser = $dbUser->Fetch();
    if ($arUser["PERSONAL_PHOTO"]) {
        $URL = CFile::GetPath($arUser["PERSONAL_PHOTO"]);

    } else {
        $URL = '/local/templates/school_eng/img/noPhoto.png';
    }
    $PROP['avatar'] = 'https://' . SITE_SERVER_NAME . $URL;
    CPullStack::AddByUser(
        $PROP["TO_ID"], Array(
            'module_id' => 'message',
            'command' => $PROP,
            'params' => Array(),
        )
    );
} else
    $request = 'Error';

echo json_encode($request);
}
else if($_REQUEST["broadcast"]) {

    $structure=[];
    $students=[];
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'GROUP_STRUCTURE', "PROPERTY_GROUP_ID" => $_REQUEST["broadcast"]),
            false,
            false,
            Array('ID', 'PROPERTY_STUDENT_ID','PROPERTY_GROUP_ID')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            array_push($structure, $ar_fields['PROPERTY_STUDENT_ID_VALUE']);
        }

        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'STUDENTS', "ID" => $structure),
            false,
            false,
            Array('ID', 'PROPERTY_USERID')
        );

        while($ar_fields = $my_elements->GetNext())
        {

            array_push($students, $ar_fields['PROPERTY_USERID_VALUE']);



            $el = new CIBlockElement;

            $PROP = array();
            $PROP['SCHOOL_ID']=$schoolID;

            $PROP["TEXT"] = $_REQUEST["text"];  // учитель для группы
            $PROP["FROM_ID"] = $USER->GetID();  // учитель для группы
                $PROP["TO_ID"] = $ar_fields['PROPERTY_USERID_VALUE'];  // учитель для группы

            $arLoadProductArray = Array(
                "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
                "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                "IBLOCK_ID" => $iblockid,
                "PROPERTY_VALUES" => $PROP,
                "NAME" => 'message',
                "ACTIVE" => "Y"
            );

            if ($PRODUCT_ID = $el->Add($arLoadProductArray))
                $request = 'Success';
            CModule::IncludeModule('pull');
            if (CModule::IncludeModule('pull')) {
                $dbUser = CUser::GetByID($USER->GetID());
                $arUser = $dbUser->Fetch();
                if ($arUser["PERSONAL_PHOTO"]) {
                    $URL = CFile::GetPath($arUser["PERSONAL_PHOTO"]);

                } else {
                    $URL = '/local/templates/school_eng/img/noPhoto.png';
                }
                $PROP['avatar'] = 'https://' . SITE_SERVER_NAME . $URL;
                CPullStack::AddByUser(
                    $PROP["TO_ID"], Array(
                        'module_id' => 'message',
                        'command' => $PROP,
                        'params' => Array(),
                    )
                );
            } else
                $request = 'Error';



        }

    endif;
   echo json_encode($request);
}
?>