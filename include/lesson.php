<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/12/2018
 * Time: 19:39
 */
function getLessons($date)
{
    $lessons = [];
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'LESSON',
                '>=PROPERTY_FROM' => $date . ' 00:00:00',
                '<=PROPERTY_FROM' => $date . ' 23:59:59',),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_FROM', 'PROPERTY_TO', 'PROPERTY_GROUP', 'PROPERTY_AUDITORIUM', 'PROPERTY_REPEAT', 'PROPERTY_COST')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            $ar_fields['PROPERTY_TO_VALUE'] = date("H:i", strtotime($ar_fields['PROPERTY_TO_VALUE']));
            $ar_fields['PROPERTY_FROM_VALUE'] = date("H:i", strtotime($ar_fields['PROPERTY_FROM_VALUE']));
            array_push($lessons, $ar_fields);
        }
    endif;

return $lessons;
}
    ?>


