<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 20/01/2019
 * Time: 21:42
 */
$lessons = [];
$group=[];
$structure=[];
$students=[];
$adjustment=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList(
        Array("PROPERTY_TO" => "ASC"),
        Array("IBLOCK_CODE" => 'LESSON',
            'ID' => $_REQUEST['id']),
        false,
        false,
        Array('ID', 'NAME', 'PROPERTY_FROM', 'PROPERTY_TO', 'PROPERTY_GROUP', 'PROPERTY_AUDITORIUM', 'PROPERTY_REPEAT')
    );

    while ($ar_fields = $my_elements->GetNext()) {
        $ar_fields['PROPERTY_TO_VALUE'] = date("H:i", strtotime($ar_fields['PROPERTY_TO_VALUE']));
        $ar_fields['PROPERTY_FROM_VALUE'] = date("H:i", strtotime($ar_fields['PROPERTY_FROM_VALUE']));
       $lessons=$ar_fields;
    }
endif;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP',
            'ID' => $lessons['PROPERTY_GROUP_VALUE']),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_TEACHER')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $group= $ar_fields;
    }
endif;

if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP_STRUCTURE', "PROPERTY_GROUP_ID" => $lessons['PROPERTY_GROUP_VALUE']),
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
        Array('ID', 'PROPERTY_DOGOVOR','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME', 'PROPERTY_STATUS')
    );

    while($ar_fields = $my_elements->GetNext())
    {

        array_push($students, $ar_fields);
    }

    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'ADJUSTMENT', "PROPERTY_ALESSONID" => $_REQUEST['id']),
        false,
        false,
        Array('ID', 'PROPERTY_USERID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($adjustment, $ar_fields['PROPERTY_USERID_VALUE']);
    }
endif;
    if(!empty($adjustment)) {
        $my_elements = CIBlockElement::GetList(
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'STUDENTS', "ID" => $adjustment),
            false,
            false,
            Array('ID', 'PROPERTY_DOGOVOR', 'PROPERTY_NAME', 'PROPERTY_LAST_NAME', 'PROPERTY_SECOND_NAME', 'PROPERTY_STATUS')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            $ar_fields['ADJUSTMENT'] = 'YES';
            array_push($students, $ar_fields);
        }
    }

    $request = Array('LESSON'=> $lessons,
        'GROUP'=>$group,
        'STUDENTS'=>$students,
        'ADJUSTMENT'=>$adjustment);
    echo json_encode($request);
    ?>