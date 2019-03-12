<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/02/2019
 * Time: 19:48
 */

CModule::IncludeModule('pull');
CModule::IncludeModule('group');

$adminArr = CGroup::GetGroupUser(1);
$methodistArr = CGroup::GetGroupUser(9);
if($pushtype){
    $pushtype = $pushtype;
}
else{
    $pushtype='false';
}
CPullStack::AddByUsers(
    $adminArr, Array(
    'module_id' => $pushtype,
    'command' => $message,
    'params' => Array(
        'message' => Array($message)
    ),
));
CPullStack::AddByUsers(
    $methodistArr, Array(
    'module_id' => $pushtype,
    'command' => $message,
    'params' => Array(
        'message' => Array($message)
    ),
));
?>