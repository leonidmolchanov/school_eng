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
    $order = CSaleOrder::GetByID($id);
    $dbBasketItems = CSaleBasket::GetList(array(), array("ORDER_ID" => $id), false, false, array());
    while ($arItems = $dbBasketItems->Fetch()) {
        $macciw = $arItems;
    }
    lessonProc($order['USER_ID'], $macciw['QUANTITY'], 'add');


//        $sum = $order['SUM_PAID'];
//    $desc = "Зачисление средств на счет";
//
//        $d =  CSaleUserAccount::UpdateAccount(
//            $order['USER_ID'],
//            $sum,
//            "RUB",
//            $desc,
//            $desc
//        );
//        if($d){
//            echo json_encode("success");
//        }
//        else{
//            echo "error";
//        }
}