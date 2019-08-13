<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/12/2018
 * Time: 19:36
 */

// Получаем список аудиторий
$auditorium=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'AUDITORIUM',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'NAME', 'PROPERTY_COLOR')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($auditorium, $ar_fields);
    }
endif;
    ?>