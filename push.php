<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 02/02/2019
 * Time: 00:24
 */

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CModule::IncludeModule('pull');
CModule::IncludeModule('group');

$adminArr = CGroup::GetGroupUser(1);
$methodistArr = CGroup::GetGroupUser(9);
//CPullStack::AddShared(Array(
//    'module_id' => 'test',
//    'command' => 'check',
//    'params' => Array($_REQUEST['message']),
//));
$arrayUserId=[1,2];

CPullStack::AddByUsers(
    $arrayUserId, Array(
    'module_id' => 'test',
    'command' => json_encode($methodistArr),
    'params' => Array(
        'message' => json_encode($arrayUserId)
    ),
));
    ?>