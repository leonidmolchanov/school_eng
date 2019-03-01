<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 13/02/2019
 * Time: 02:18
 */




use Bitrix\Main\Web\HttpClient;
$httpClient = new HttpClient(array(
));
$httpClient->setHeader('Content-Type', 'application/x-www-form-urlencoded', true);
$url = "https://api.kontur.ru/auth/authenticate-by-pass?login=zvezdnaya@lingvitan.ru";
$data = array("free" => false);
$response = $httpClient->post($url, "MAKC123456789");
//var_dump($data);
//var_dump($response);
$response=json_decode($response);
//print_r($response);

$ssid = $response->Sid;
$apikey = "e8d5f8e7-d62f-4286-bd44-bc1ea847005e";
$httpClient2 = new HttpClient(array(
));
$httpClient2->setHeader('Content-Type', 'application/x-www-form-urlencoded', true);
$httpClient2->setCookies(Array('ofd_api_key'=>$apikey,
    'auth.sid'=>$ssid));
$httpClient2->setTimeout(10);
$url = "https://ofd-api.kontur.ru/v1/integration/inns/890103827017/kkts/0002930566037785/fss/9252440300020527/tickets?dateFrom=".date('Y-m-d')."&dateTo=".date('Y-m-d');
//$url = "https://ofd-api.kontur.ru/v1/integration/inns/890103827017/kkts/0002930566037785/fss/9252440300020527/tickets?dateFrom=2019-02-12&dateTo=2019-02-12";

$response2 = $httpClient2->get($url, false);
$response2 = json_decode($response2);

$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "TRANSACTION",
            "CHECK_PERMISSIONS" => "N"
        )
    );
    while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
    {
        $iblockid = $arIBlock["ID"];

    }
}
CModule::IncludeModule('iblock');
if(CModule::IncludeModule("iblock"))
{
    $transArr=[];
    $ib_list = CIBlockElement::GetList(
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => "TRANSACTION"
        ),
        false,
        false,
        Array('ID', 'PROPERTY_NUMBER')
    );
    while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
    {
        array_push($transArr, $arIBlock["PROPERTY_NUMBER_VALUE"]);
    }
}

print_r($transArr);
foreach ($response2 as $item){
    $result=Array();
    ?><pre><?print_r($item);?></pre><?
    if($item->receipt) {

        if(!in_array($item->receipt->fiscalSign, $transArr)) {
            $result['sum'] = number_format(($item->receipt->totalSum / 100), 2, ',', ' ');
            $result['number'] = $item->receipt->fiscalSign;
            $result['date'] = date('d.m.Y H:i', strtotime($item->receipt->dateTime));
            print_r($result);
            echo $result['sum'];
            $el = new CIBlockElement;

            $PROP = array();
            $PROP["DATE"] = $result['date'];
            $PROP["SUM"] = $result['sum'];
            $PROP["NUMBER"] = $result['number'];
            $PROP["STATUS"] = 0;

            $arLoadProductArray = Array(
                "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
                "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                "IBLOCK_ID" => $iblockid,
                "PROPERTY_VALUES" => $PROP,
                "NAME" => 'Транзакция',
                "ACTIVE" => "Y"
            );

            if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
                echo 'Success';
                $message = "Была произведена оплата № ".$result['number']." на сумму ".$result['sum']." рублей";
                require("push.php");
            }
            else {
                echo 'Error';
            }

        } }
}
?>