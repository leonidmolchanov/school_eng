<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/12/2018
 * Time: 22:08
 */

// Получаем список учителей
require($_SERVER["DOCUMENT_ROOT"]."/include/teacher.php");
// Получаем список аудиторий
require($_SERVER["DOCUMENT_ROOT"]."/include/auditorium.php");
// Получаем список групп
require($_SERVER["DOCUMENT_ROOT"]."/include/group.php");
// Получаем список занятий
require($_SERVER["DOCUMENT_ROOT"]."/include/lesson.php");
// Получаем список пробных занятий
require($_SERVER["DOCUMENT_ROOT"]."/include/trial.php");

$contentArr=[];
$scheduleTeacher=[];
$weekendsTeacher=[];
$trialLessons=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'SCHEDULE', "PROPERTY_TYPE"=>"TEACHER",
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_MON','PROPERTY_TUE','PROPERTY_WEN','PROPERTY_THU','PROPERTY_FRI','PROPERTY_SAT','PROPERTY_SUN', 'PROPERTY_TYPE', 'PROPERTY_TEACHER_ID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $scheduleTeacher[$ar_fields['PROPERTY_TEACHER_ID_VALUE']]=Array(
        'Mon' => $ar_fields['PROPERTY_MON_VALUE'],
        'Tue' => $ar_fields['PROPERTY_TUE_VALUE'],
        'Wed' => $ar_fields['PROPERTY_WEN_VALUE'],
        'Thu' => $ar_fields['PROPERTY_THU_VALUE'],
        'Fri' => $ar_fields['PROPERTY_FRI_VALUE'],
        'Sat' => $ar_fields['PROPERTY_SAT_VALUE'],
        'Sun' => $ar_fields['PROPERTY_SUN_VALUE']
    );
    }

    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'WEEKENDS', "PROPERTY_TYPE"=>"TEACHER",
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('PROPERTY_DATE', 'PROPERTY_TEACHER_ID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        if(!$weekendsTeacher[$ar_fields['PROPERTY_TEACHER_ID_VALUE']]){
            $weekendsTeacher[$ar_fields['PROPERTY_TEACHER_ID_VALUE']]=[];
        }
        array_push($weekendsTeacher[$ar_fields['PROPERTY_TEACHER_ID_VALUE']],date("m-d", strtotime($ar_fields['PROPERTY_DATE_VALUE'])));
    }
endif;


for ($i = 0; $i <= 6; $i++) {
    $content = [];
    $schedule=[];
    $weekend= false;
    $holiday =false;
    $date =             date("m-d", strtotime($_REQUEST['date'].'+'.$i.' day'));
    $day =  date("D", strtotime($_REQUEST['date'].'+'.$i.' day'));
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'WEEKENDS', "PROPERTY_TYPE"=>"GLOBAL",
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('PROPERTY_DATE')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            if( date("m-d", strtotime($ar_fields['PROPERTY_DATE_VALUE'])) == $date ){
                $weekend = true;
            }
        }
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'WEEKENDS', "PROPERTY_TYPE"=>"HOLIDAYS",
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('PROPERTY_DATE')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            if( date("m-d", strtotime($ar_fields['PROPERTY_DATE_VALUE'])) == $date ){
                $holiday = true;
            }
        }
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'SCHEDULE', "PROPERTY_TYPE"=>"GLOBAL",
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('PROPERTY_MON' ,
                'PROPERTY_TUE' ,
                'PROPERTY_WEN' ,
                'PROPERTY_THU' ,
                'PROPERTY_FRI' ,
                'PROPERTY_SAT' ,
                'PROPERTY_SUN' , )
        );

        $ar_fields = $my_elements->GetNext() ;
        $schedule['Mon'] = $ar_fields['PROPERTY_MON_VALUE'];
        $schedule['Tue'] = $ar_fields['PROPERTY_TUE_VALUE'];
        $schedule['Wed'] = $ar_fields['PROPERTY_WEN_VALUE'];
        $schedule['Thu'] = $ar_fields['PROPERTY_THU_VALUE'];
        $schedule['Fri'] = $ar_fields['PROPERTY_FRI_VALUE'];
        $schedule['Sat'] = $ar_fields['PROPERTY_SAT_VALUE'];
        $schedule['Sun'] = $ar_fields['PROPERTY_SUN_VALUE'];


    endif;

    if(!$holiday):

    if(!$weekend && (int) $schedule[$day]==0):


    foreach ($teacher as $value) {
        $groupArr = [];

        foreach (getTrial(date('Y-m-d', strtotime($_REQUEST['date'].'+'.$i.' day'))) as $value3) {
            if ($value3['PROPERTY_TEACHER_ID_VALUE'] == $value['ID']):
            $value3['DATE222']=$_REQUEST['date'];
                array_push($groupArr, $value3);
            endif;
        }
        foreach ($group as $value2) {



            if ($value2['PROPERTY_TEACHER_VALUE'] == $value['ID']):
                $lessonsArr = [];


                if(!$scheduleTeacher[$value['ID']][$day]):
                    if(!in_array($date, $weekendsTeacher[$value['ID']])):
                foreach (getLessons(date('Y-m-d', strtotime($_REQUEST['date'].'+'.$i.' day'))) as $value3) {
                    if ($value3['PROPERTY_GROUP_VALUE'] == $value2['ID']):
                        // array_push($lessonsArr, $value3);
                        array_push($groupArr, $value3);
                    endif;
                }
                else:
                    $groupArr= false;
endif;
else:
    $groupArr= false;

                endif;


            endif;

            usort($groupArr, function ($a1, $a2) {
                $value1 = strtotime($a1['PROPERTY_FROM_VALUE']);
                $value2 = strtotime($a2['PROPERTY_FROM_VALUE']);
                return $value1 - $value2;
            });


        }


        $teacherArr = [];
        $teacherArr['NAME'] = $value['NAME'];
        $teacherArr['CONTENT'] = $groupArr;
        array_push($content, $teacherArr);
    }
    array_push($contentArr, $content);
else:
    $teacherArr = [];
    $teacherArr['WEEKEND'] = true;
   $content= $teacherArr;
    array_push($contentArr, $content);

    endif;


else:
    $teacherArr = [];
    $teacherArr['HOLIDAY'] = true;
    $content= $teacherArr;
    array_push($contentArr, $content);

endif;

}


$request = Array('teacher'=>$teacher,'content'=>$contentArr, 'auditorium'=>$auditorium, 'group'=>$group, 'trial'=>$trialLessons);


echo json_encode($request);
?>