<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 25/01/2019
 * Time: 02:12
 */
$date = date("d.m.Y  00:00:00");
$dateEND = date("d.m.Y 23:59:59");
$adjustment = [];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList(
        Array("PROPERTY_TO" => "ASC"),
        Array("IBLOCK_CODE" => 'JOURNAL',
            '>=DATE_CREATE' => $date,
            '<=DATE_CREATE' => $dateEND,),
        false,
        false,
        Array('ID', 'NAME', 'PROPERTY_DISEASE', 'PROPERTY_LESSONID')
    );

    while ($ar_fields = $my_elements->GetNext()) {
        if($ar_fields['PROPERTY_DISEASE_VALUE']) {
            if(is_array($ar_fields['PROPERTY_DISEASE_VALUE'])){
                foreach ($ar_fields['PROPERTY_DISEASE_VALUE'] as $item){
                    array_push($adjustment, Array('USERID'=>$item['PROPERTY_DISEASE_VALUE'], 'LESSONID'=>$item['PROPERTY_LESSONID_VALUE']));
                }

            }
            else {
                array_push($adjustment, Array('USERID'=>$ar_fields['PROPERTY_DISEASE_VALUE'], 'LESSONID'=>$ar_fields['PROPERTY_LESSONID_VALUE']));
            }
        }
    }
endif;


$iblockid=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "ADJUSTMENT",
            "CHECK_PERMISSIONS" => "N"
        )
    );
    while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
    {
        $iblockid = $arIBlock["ID"];

    }
}

foreach ($adjustment as $item) {
    $el = new CIBlockElement;

    $PROP = array();
    $PROP["USERID"] = $item["USERID"];  // учитель для группы
    $PROP["LESSONID"] = $item["LESSONID"];  // учитель для группы
    $PROP["STATUS"] = 3;
    $PROP["DATESET"]= date("d.m.Y H:i");

    $arLoadProductArray = Array(
        "MODIFIED_BY" =>1, // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
        "IBLOCK_ID" => $iblockid,
        "PROPERTY_VALUES" => $PROP,
        "NAME" => 'Отработка',
        "ACTIVE" => "Y"
    );

    if ($PRODUCT_ID = $el->Add($arLoadProductArray))
        $request = 'Success';
    else
        $request = 'Error';
}

//print_r($adjustment);

?>