<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.profile",
	"profile",
	Array(
		"CHECK_RIGHTS" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"SEND_INFO" => "N",
		"SET_TITLE" => "Y",
		"USER_PROPERTY" => "",
		"USER_PROPERTY_NAME" => ""
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>