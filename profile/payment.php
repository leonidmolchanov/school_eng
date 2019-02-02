<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 31/01/2019
 * Time: 01:48
 */

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оплата заказа");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment",
	"",
Array()
);?>