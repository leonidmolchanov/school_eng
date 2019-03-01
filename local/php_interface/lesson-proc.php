<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 02/02/2019
 * Time: 19:36
 */

/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 16/12/2018
 * Time: 03:01
 */

$students=[];


if($type=="modify"){
    $ELEMENT_ID = $id;
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'STUDENTS', "ID" => $id),
            false,
            false,
            Array('ID', 'PROPERTY_DOGOVOR', 'PROPERTY_LESSON_BALANCE', 'PROPERTY_NAME', 'PROPERTY_LAST_NAME', 'PROPERTY_SECOND_NAME')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            $students = $ar_fields;
        }
    endif;
}else {
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'STUDENTS', "PROPERTY_USERID" => $id),
            false,
            false,
            Array('ID', 'PROPERTY_DOGOVOR', 'PROPERTY_LESSON_BALANCE', 'PROPERTY_NAME', 'PROPERTY_LAST_NAME', 'PROPERTY_SECOND_NAME')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            $students = $ar_fields;
        }
        $ELEMENT_ID = $students['ID'];

    endif;
}
// код элемента
$PROPERTY_CODE = "LESSON_BALANCE";  // код свойства
if($type=="add"){
    $PROPERTY_VALUE = $students['PROPERTY_LESSON_BALANCE_VALUE']+$val;  // значение свойства
    $message = "Пользователь ".$students['PROPERTY_NAME_VALUE']." ".$students['PROPERTY_LAST_NAME_VALUE']." оплатил заказ на ".$val." уроков.";
}
else if($type=="modify"){

    $PROPERTY_VALUE = $students['PROPERTY_LESSON_BALANCE_VALUE']-$val;  // значение свойства
    $message = "C пользователя ".$students['PROPERTY_NAME_VALUE']." ".$students['PROPERTY_LAST_NAME_VALUE']." списан заказ на ".$val." уроков.";
    print_r($students);
}
else{
    $PROPERTY_VALUE = $students['PROPERTY_LESSON_BALANCE_VALUE']-$val;  // значение свойства
    $message = "C пользователя ".$students['PROPERTY_NAME_VALUE']." ".$students['PROPERTY_LAST_NAME_VALUE']." списан заказ на ".$val." уроков.";

}
// Установим новое значение для данного свойства данного элемента
$test  = CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));


require("push.php");
?>