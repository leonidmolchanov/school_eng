<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оплата заказа");
?><?$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket",
    "",
    Array()
);?>