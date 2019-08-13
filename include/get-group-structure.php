<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 16/12/2018
 * Time: 04:00
 */
$structure=[];
$students=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP_STRUCTURE', "PROPERTY_GROUP_ID" => $_REQUEST['groupID'],
        'PROPERTY_SCHOOL_ID'=>$schoolID),
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
        Array("IBLOCK_CODE" => 'STUDENTS', "ID" => $structure,
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
    if(!empty($structure)) {
        echo json_encode($students);
    }
    else{
       echo json_encode('error');
    }
?>