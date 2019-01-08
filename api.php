<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 02/12/2018
 * Time: 17:09
 */
ob_start(); //стартуем буферизацию
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
ob_end_clean(); //очищаем буфер
ob_end_flush(); //закрываем его
//Далее код использующий функционал Битрикс
if($_REQUEST['sessid']==bitrix_sessid()):
global $USER;
CModule::IncludeModule('iblock');
if($_REQUEST['type']=='getGraph'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-graph.php");
elseif($_REQUEST['type']=='getGroup'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-group.php");
elseif($_REQUEST['type']=='createGroup'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/create-group.php");
elseif($_REQUEST['type']=='deleteGroup'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/delete-group.php");
elseif($_REQUEST['type']=='createLesson'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/create-lesson.php");
elseif($_REQUEST['type']=='deleteLesson'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/delete-lesson.php");
elseif($_REQUEST['type']=='editLesson'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/edit-lesson.php");
elseif($_REQUEST['type']=='createRoom'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/create-room.php");
elseif($_REQUEST['type']=='getRoom'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-room.php");
elseif($_REQUEST['type']=='deleteRoom'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/delete-room.php");
elseif($_REQUEST['type']=='createStudent'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/create-student.php");
elseif($_REQUEST['type']=='getStudent'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-student.php");
elseif($_REQUEST['type']=='createTeacher'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/create-teacher.php");
elseif($_REQUEST['type']=='createMethodist'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/create-methodist.php");
elseif($_REQUEST['type']=='getGroupStructure'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-group-structure.php");
elseif($_REQUEST['type']=='addInGroupStructure'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/add-in-group-structure.php");
elseif($_REQUEST['type']=='deleteInGroupStructure'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/delete-in-group-structure.php");
elseif($_REQUEST['type']=='getProfileInfo'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-profile-info.php");
elseif($_REQUEST['type']=='createPayment'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/createPayment.php");
else:
    echo "err Type";
endif;
    else:
  echo json_encode('bad sessid');
    endif;
?>
