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
$contentArr=[];

for ($i = 0; $i <= 6; $i++) {
    $content = [];
    foreach ($teacher as $value) {
        $groupArr = [];
        foreach ($group as $value2) {
            if ($value2['PROPERTY_TEACHER_VALUE'] == $value['ID']):
                $lessonsArr = [];
                foreach (getLessons(date('Y-m-d', strtotime($_REQUEST['date'].'+'.$i.' day'))) as $value3) {
                    if ($value3['PROPERTY_GROUP_VALUE'] == $value2['ID']):
                        // array_push($lessonsArr, $value3);
                        array_push($groupArr, $value3);
                    endif;
                }
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
}


$request = Array('teacher'=>$teacher,'content'=>$contentArr, 'auditorium'=>$auditorium, 'group'=>$group);


echo json_encode($request);
?>