<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 16/12/2018
 * Time: 03:01
 */

$students=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'STUDENTS',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_DOGOVOR','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($students, $ar_fields);
    }
endif;
echo json_encode($students);
?>