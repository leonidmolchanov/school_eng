<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 16/12/2018
 * Time: 04:31
 */

$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "GROUP_STRUCTURE",
            "CHECK_PERMISSIONS" => "N"
        )
    );
    while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
    {
        $iblockid = $arIBlock["ID"];

    }
}
$check=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP_STRUCTURE', "PROPERTY_GROUP_ID" => $_REQUEST['groupID'], "PROPERTY_STUDENT_ID" => $_REQUEST['studentID']),
        false,
        false,
        Array('ID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($check, $ar_fields);
    }
endif;
if(empty($check)):
$el = new CIBlockElement;

$PROP = array();
$PROP["STUDENT_ID"] = $_REQUEST["studentID"];
$PROP["GROUP_ID"] = $_REQUEST["groupID"];
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $iblockid,
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => "bind",
    "ACTIVE"         => "Y"
);

if($PRODUCT_ID = $el->Add($arLoadProductArray))
    $request = 'Success';
else
    $request = 'Error';

echo json_encode($request);
else:
    echo json_encode('Error');

endif;
?>