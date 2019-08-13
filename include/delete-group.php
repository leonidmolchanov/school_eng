<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 04/12/2018
 * Time: 00:48
 */
//if(CIBlock::GetPermission($_REQUEST["idGroup"])>='W')
//{

if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList(
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP_STRUCTURE',
            "PROPERTY_GROUP_ID" => $_REQUEST["idGroup"],
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_STUDENT_ID')
    );

    while ($ar_fields = $my_elements->GetNext()) {

        $DB->StartTransaction();
        if(!CIBlockElement::Delete($ar_fields["ID"]))
        {
            $request='error';
            $strWarning .= 'Error!';
            $DB->Rollback();
        }
        else
            $DB->Commit();
        $request='Success';

    }
endif;

    $DB->StartTransaction();
    if(!CIBlockElement::Delete($_REQUEST["idGroup"]))
    {
        $request='error';
        $strWarning .= 'Error!';
        $DB->Rollback();
    }
    else
        $DB->Commit();
    $request='Success';
//}
echo json_encode($request);
?>