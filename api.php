<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 02/12/2018
 * Time: 17:09
 */
//ob_start(); //стартуем буферизацию
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
define('STOP_STATISTICS', true);
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define('PUBLIC_AJAX_MODE', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"]="N";
$APPLICATION->ShowIncludeStat = false;$APPLICATION->RestartBuffer();
//ob_end_clean(); //очищаем буфер
//ob_end_flush(); //закрываем его
//Далее код использующий функционал Битрикс

$login_password_correct = false;

if (
    isset( $_REQUEST['login'] ) && strlen( $_REQUEST['password'] ) > 0
    &&
    isset( $_REQUEST['login'] ) && strlen( $_REQUEST['password'] ) > 0
)
{

    $rsUser = CUser::GetByLogin( $_REQUEST['login'] );
    if ($arUser = $rsUser->Fetch())
    {
        if(strlen($arUser["PASSWORD"]) > 32)
        {
            $salt = substr($arUser["PASSWORD"], 0, strlen($arUser["PASSWORD"]) - 32);
            $db_password = substr($arUser["PASSWORD"], -32);
        }
        else
        {
            $salt = "";
            $db_password = $arUser["PASSWORD"];
        }

        $user_password =  md5($salt.$_REQUEST['password']);

        if ( $user_password == $db_password )
        {
            $login_password_correct = true;

            if (!is_object($USER)) $USER = new CUser;
            $arAuthResult = $USER->Login($_REQUEST['login'], $_REQUEST['password'], "Y");
                $APPLICATION->arAuthResult = $arAuthResult;
        }
    }
}

if($_REQUEST['sessid']==bitrix_sessid() || $login_password_correct):
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
elseif($_REQUEST['type']=='editGroup'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/edit-group.php");
elseif($_REQUEST['type']=='createLesson'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/create-lesson.php");
elseif($_REQUEST['type']=='deleteLesson'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/delete-lesson.php");
elseif($_REQUEST['type']=='editLesson'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/edit-lesson.php");
elseif($_REQUEST['type']=='getLessonStructure'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-lesson-structure.php");
elseif($_REQUEST['type']=='createRoom'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/create-room.php");
elseif($_REQUEST['type']=='getRoom'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-room.php");
elseif($_REQUEST['type']=='editRoom'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/edit-room.php");
elseif($_REQUEST['type']=='deleteRoom'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/delete-room.php");
elseif($_REQUEST['type']=='createStudent'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/create-student.php");
elseif($_REQUEST['type']=='getStudent'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-student.php");
elseif($_REQUEST['type']=='editStudent'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/edit-student.php");
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
elseif($_REQUEST['type']=='getProfileInfoMobile'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-profile-info-mobile.php");
elseif($_REQUEST['type']=='createPayment'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/createPayment.php");
elseif($_REQUEST['type']=='createAdjustment'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/create-adjustment.php");
elseif($_REQUEST['type']=='editAdjustment'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/edit-adjustment.php");
elseif($_REQUEST['type']=='deleteAdjustment'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/delete-adjustment.php");
elseif($_REQUEST['type']=='editJournal'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/edit-journal.php");
elseif($_REQUEST['type']=='searchFreeTime'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/search-free-time.php");
elseif($_REQUEST['type']=='createDiscount'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/create-discount.php");
elseif($_REQUEST['type']=='changePassword'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/change-password.php");
elseif($_REQUEST['type']=='getMessage'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-message.php");
elseif($_REQUEST['type']=='sendMessage'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/send-message.php");
elseif($_REQUEST['type']=='getListUserMessage'):
    require($_SERVER["DOCUMENT_ROOT"]."/include/get-list-user-message.php");
else:
    echo $_REQUEST['type'];
    echo "rr Type";
endif;
    else:
if($_REQUEST['type']=='auth'):
    global $USER;
    if (!is_object($USER)) $USER = new CUser;
    $arAuthResult = $USER->Login($_REQUEST['login'], $_REQUEST['password'], "Y");
if(!is_array($arAuthResult)):
    $APPLICATION->arAuthResult = $arAuthResult;
    $request=Array('status'=>'success',
        'sessid'=>bitrix_sessid());
else:
    $request=Array('status'=>'error',
        'body'=>$arAuthResult);
endif;
echo json_encode($request);
    else:
  echo json_encode('bad sessid');
    endif;
    endif;
?>
