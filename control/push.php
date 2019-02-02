<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 02/02/2019
 * Time: 00:13
 */
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CModule::IncludeModule('pull');
CPullStack::AddShared(Array(
    'module_id' => 'test',
    'command' => 'check',
    'params' => Array($_REQUEST['message']),
));
    ?>