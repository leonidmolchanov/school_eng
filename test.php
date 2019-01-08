
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CModule::IncludeModule('pull');
CPullStack::AddShared(Array(
    'module_id' => 'test',
    'command' => 'check',
    'params' => Array($_REQUEST['message']),
));
    ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
