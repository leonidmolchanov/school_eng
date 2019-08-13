<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/12/2018
 * Time: 19:39
 */

    $lessons = [];
    $weekends=[];
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'LESSON',
                '>=PROPERTY_FROM' => $_REQUEST['date'].'-01' . ' 00:00:00',
                '<=PROPERTY_FROM' => $_REQUEST['date'].'-31' . ' 23:59:59',
                'PROPERTY_GROUP'=>$_REQUEST['group'],
//                'PROPERTY_SCHOOL_ID'=>$schoolID

            ),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_FROM', 'PROPERTY_TO', 'PROPERTY_GROUP', 'PROPERTY_AUDITORIUM', 'PROPERTY_REPEAT', 'PROPERTY_COST',  'PROPERTY_SUB')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            if(!$lessons[date('m-j', strtotime($ar_fields['PROPERTY_FROM_VALUE']))]){
                $lessons[date('m-j', strtotime($ar_fields['PROPERTY_FROM_VALUE']))]=[];
            }
            array_push($lessons[date('m-j', strtotime($ar_fields['PROPERTY_FROM_VALUE']))],Array('TYPE'=>'LESSON','DATA'=>$ar_fields));
//            array_push($lessons, $ar_fields);
        }
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'TRIAL',
                '>=PROPERTY_DATE_LESSON' => $_REQUEST['date'].'-01' . ' 00:00:00',
                '<=PROPERTY_DATE_LESSON' => $_REQUEST['date'].'-31' . ' 23:59:59',
                'PROPERTY_TEACHER_ID'=>$_REQUEST['teacherId'],
//                'PROPERTY_SCHOOL_ID'=>$schoolID
                ),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_DATE_LESSON')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            if(!$lessons[date('m-j', strtotime($ar_fields['PROPERTY_FROM_VALUE']))]){
                $lessons[date('m-j', strtotime($ar_fields['PROPERTY_FROM_VALUE']))]=[];
            }
            array_push($lessons[date('m-j', strtotime($ar_fields['PROPERTY_DATE_LESSON_VALUE']))],Array('TYPE'=>'TRIAL','DATA'=>$ar_fields));
//            array_push($lessons, $ar_fields);
        }

        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'WEEKENDS',
                '>=PROPERTY_DATE' => '0003-'.date('m', strtotime($_REQUEST['date'])).'-01' . ' 00:00:00',
                '<=PROPERTY_DATE' => '0003-'.date('m', strtotime($_REQUEST['date'])).'-31' . ' 23:59:59',
                'PROPERTY_TEACHER_ID'=>$_REQUEST['teacherId'],
//                'PROPERTY_SCHOOL_ID'=>$schoolID

            ),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_DATE')
        );

        while ($ar_fields = $my_elements->GetNext()) {
                $lessons[date('m-d', strtotime($ar_fields['PROPERTY_DATE_VALUE']))]='WEEK';

        }
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'SCHEDULE',
                'PROPERTY_TEACHER_ID'=>$_REQUEST['teacherId'],
//                'PROPERTY_SCHOOL_ID'=>$schoolID

            ),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_MON', 'PROPERTY_TUE', 'PROPERTY_WEN', 'PROPERTY_THU', 'PROPERTY_FRI', 'PROPERTY_SAT', 'PROPERTY_SUN')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            $weekends=$ar_fields;

        }
    endif;

echo json_encode(Array('LESSON'=>$lessons,'WEEKENDS'=>$weekends));
    ?>


