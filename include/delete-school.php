<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 10/12/2018
 * Time: 16:30
 */
$elArr=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array(
            'PROPERTY_SCHOOL_ID'=>$_REQUEST['id']),
        false,
        false,
        Array('ID', 'NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $DB->StartTransaction();
        if(!CIBlockElement::Delete($ar_fields['ID']))
        {
            $request='error';
            $strWarning .= 'Error!';
            $DB->Rollback();
        }
        else
            $DB->Commit();
    }

    $DB->StartTransaction();
    if(!CIBlockElement::Delete($_REQUEST['id']))
    {
        $request='error';
        $strWarning .= 'Error!';
        $DB->Rollback();
    }
    else
        $DB->Commit();
endif;
    echo json_encode('Success');
    ?>