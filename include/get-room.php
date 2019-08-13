<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 10/12/2018
 * Time: 16:30
 */
$room=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'AUDITORIUM',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_COLOR')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($room, $ar_fields);
    }
endif;
    echo json_encode($room);
    ?>