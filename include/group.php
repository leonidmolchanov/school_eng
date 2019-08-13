<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/12/2018
 * Time: 19:38
 */
$group=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("NAME" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_TEACHER', 'PROPERTY_LESSON_COST', 'PROPERTY_LENGTH', 'PROPERTY_PLACE')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($group, $ar_fields);
    }
endif;
    ?>