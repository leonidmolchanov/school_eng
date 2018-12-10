<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/12/2018
 * Time: 22:49
 */
// Получаем список групп
require($_SERVER["DOCUMENT_ROOT"]."/include/group.php");
require($_SERVER["DOCUMENT_ROOT"]."/include/teacher.php");
$request = Array('teacher'=>$teacher, 'group'=>$group);
echo json_encode($request);
?>