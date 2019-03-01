<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 25/01/2019
 * Time: 04:34
 */
CModule::IncludeModule('Sale');

$date = date("d.m.Y  00:00:00");
$dateEND = date("d.m.Y 23:59:59");
$cost = [];
$lessonArr=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList(
        Array("PROPERTY_TO" => "ASC"),
        Array("IBLOCK_CODE" => 'JOURNAL',
            '>=DATE_CREATE' => $date,
            '<=DATE_CREATE' => $dateEND,),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_LESSONID','PROPERTY_BE')
    );

    while ($ar_fields = $my_elements->GetNextElement()) {
        $prop = $ar_fields->GetFields();
        if($prop['PROPERTY_BE_VALUE']) {
            array_push( $cost,Array('LESSONID'=>$prop['PROPERTY_LESSONID_VALUE'],'USERID'=>$prop['PROPERTY_BE_VALUE']));
            if (!in_array($prop['PROPERTY_LESSONID_VALUE'], $lessonArr)) {
                array_push($lessonArr, $prop['PROPERTY_LESSONID_VALUE']);
            }
        }


    }

    // Модификация отработки fix 19.02.2018
//    if (CModule::IncludeModule("iblock")):
//        # show url my elements
//        $my_elements = CIBlockElement::GetList(
//            Array("PROPERTY_TO" => "ASC"),
//            Array("IBLOCK_CODE" => 'ADJUSTMENT',
//                '>=DATE_CREATE' => $date,
//                '<=DATE_CREATE' => $dateEND,),
//            false,
//            false,
//            Array('ID', 'NAME','PROPERTY_ALESSONID','PROPERTY_STATUS',)
//        );
//
//        while ($ar_fields = $my_elements->GetNextElement()) {
//            $prop = $ar_fields->GetFields();
//            if($prop['PROPERTY_STATUS_VALUE']=='1') {
//                array_push( $cost,Array('LESSONID'=>$prop['PROPERTY_ALESSONID_VALUE'],'USERID'=>$prop['PROPERTY_USERID_VALUE']));
//                if (!in_array($prop['PROPERTY_LESSONID_VALUE'], $lessonArr)) {
//                    array_push($lessonArr, $prop['PROPERTY_ALESSONID_VALUE']);
//                }
//            }
//
//
//        }
//
//
//    endif;


if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList(
        Array("PROPERTY_TO" => "ASC"),
        Array("IBLOCK_CODE" => 'JOURNAL',
            '>=DATE_CREATE' => $date,
            '<=DATE_CREATE' => $dateEND,),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_LESSONID','PROPERTY_NOTBE')
    );

    while ($ar_fields = $my_elements->GetNextElement()) {
        $prop = $ar_fields->GetFields();
        if($prop['PROPERTY_NOTBE_VALUE']) {
            array_push( $cost,Array('LESSONID'=>$prop['PROPERTY_LESSONID_VALUE'],'USERID'=>$prop['PROPERTY_NOTBE_VALUE']));
            if (!in_array($prop['PROPERTY_LESSONID_VALUE'], $lessonArr)) {
                array_push($lessonArr, $prop['PROPERTY_LESSONID_VALUE']);
            }
        }


    }

endif;

    // Модификация отработки fix 19.02.2018

    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'JOURNAL',
                '>=DATE_CREATE' => $date,
                '<=DATE_CREATE' => $dateEND,),
            false,
            false,
            Array('ID', 'NAME','PROPERTY_LESSONID','PROPERTY_DISEASE')
        );

        while ($ar_fields = $my_elements->GetNextElement()) {
            $prop = $ar_fields->GetFields();
            if($prop['PROPERTY_DISEASE_VALUE']) {
                array_push( $cost,Array('LESSONID'=>$prop['PROPERTY_LESSONID_VALUE'],'USERID'=>$prop['PROPERTY_DISEASE_VALUE']));
                if (!in_array($prop['PROPERTY_LESSONID_VALUE'], $lessonArr)) {
                    array_push($lessonArr, $prop['PROPERTY_LESSONID_VALUE']);
                }
            }


        }

    endif;
$lesson=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'LESSON', 'ID'=>$lessonArr),
        false,
        false,
        Array('ID', 'NAME', 'PROPERTY_COST')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $lesson[$ar_fields['ID']]= $ar_fields;
    }
endif;
$userId=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'STUDENTS'),
        false,
        false,
        Array('ID', 'NAME', 'PROPERTY_USERID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $userId[$ar_fields['ID']]= $ar_fields['PROPERTY_USERID_VALUE'];
    }
endif;
    foreach ($cost as $transaction){
if($lesson[$transaction['LESSONID']]['PROPERTY_COST_VALUE']){
//    $sum = "-".$lesson[$transaction['LESSONID']]['PROPERTY_COST_VALUE'];
//    $desc = "Списание средств за урок ".$lesson[$transaction['LESSONID']]['NAME'];
//
//        $d =  CSaleUserAccount::UpdateAccount(
//            $userId[$transaction['USERID']],
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
    lessonProc($transaction['USERID'],1,'modify');

    }

endif;