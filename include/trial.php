<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/12/2018
 * Time: 19:39
 */

use Bitrix\Main\Grid\Declension;


function getTrial($date)
{
    $lessons = [];
    $yearDeclension = new Declension('год', 'года', 'лет');
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'TRIAL',
                'PROPERTY_SCHOOL_ID'=>$schoolID,
                '>=PROPERTY_DATE_LESSON' => $date . ' 00:00:00',
                '<=PROPERTY_DATE_LESSON' => $date . ' 23:59:59',),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_DATE_LESSON', 'PROPERTY_TEACHER_ID', 'PROPERTY_AUDITORIUM_ID', 'PROPERTY_NAME', 'PROPERTY_AGE')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            $ar_fields['NAME'] = 'Демо урок ('.$ar_fields['NAME'].' - '.$ar_fields['PROPERTY_AGE_VALUE'].' '.$yearDeclension->get($ar_fields['PROPERTY_AGE_VALUE']).')';
            $ar_fields['TRIAL']=true;
            $ar_fields['PROPERTY_REPEAT_VALUE'] = 0;
            $ar_fields['PROPERTY_FROM_VALUE'] = date("H:i", strtotime($ar_fields['PROPERTY_DATE_LESSON_VALUE']));
            $ar_fields['PROPERTY_TO_VALUE'] = date("H:i", strtotime($ar_fields['PROPERTY_DATE_LESSON_VALUE'].'+ 30  minutes'));
            $ar_fields['PROPERTY_AUDITORIUM_VALUE'] = $ar_fields['PROPERTY_AUDITORIUM_ID_VALUE'];
            $ar_fields['PROPERTY_COST_VALUE'] = 0;
            $ar_fields['PROPERTY_SUB_VALUE'] = 0;
            $ar_fields['PROPERTY_GROUP_VALUE'] = 'trial';

            array_push($lessons, $ar_fields);
        }

    endif;

return $lessons;
}
    ?>


