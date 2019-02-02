<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 02/02/2019
 * Time: 04:08
 */

AddEventHandler("sale", "OnSalePayOrder", "UserAddLessons");


function UserAddLessons($id,$val){
    CModule::IncludeModule('sale');

    $dbBasketItems = CSaleBasket::GetList(array(), array("ORDER_ID" => $id), false, false, array());
    while ($arItems = $dbBasketItems->Fetch()) {
        $macciw = $arItems;
    }
    lessonProc($macciw['FUSER_ID'], $macciw['QUANTITY'], 'add');
if (mail("leonidmolchanov@yandex.ru","Заказы", json_encode($macciw),"From: info@erperp.ru")){
    echo "Сообщение передано функции mail, проверьте почту в ящике.";}
else{
    echo "Функция mail не работает, свяжитесь с администрацией хостинга.";}
}