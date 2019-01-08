<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 16/12/2018
 * Time: 04:43
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
if(!empty($check)):

//    if(CIBlock::GetPermission($check[0]["ID"])>='W')
    {
        $DB->StartTransaction();
        if(!CIBlockElement::Delete($check[0]["ID"]))
        {
            $request='error';
            $strWarning .= 'Error!';
            $DB->Rollback();
        }
        else
            $DB->Commit();
        $request='Success';
    }
    echo json_encode(CIBlock::GetPermission($USER->GetID));
//else:
//    echo json_encode('Error');

endif;

?>