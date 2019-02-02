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
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'STUDENTS', "PROPERTY_USERID"=>$id),
        false,
        false,
        Array('ID', 'PROPERTY_DOGOVOR','PROPERTY_LESSON_BALANCE','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
       $students= $ar_fields;
    }
endif;
$ELEMENT_ID = $students['ID'];  // код элемента
$PROPERTY_CODE = "LESSON_BALANCE";  // код свойства
if($type=="add"){
    $PROPERTY_VALUE = $students['PROPERTY_LESSON_BALANCE_VALUE']+$val;  // значение свойства
}
else{
    $PROPERTY_VALUE = $students['PROPERTY_LESSON_BALANCE_VALUE']-$val;  // значение свойства

}
// Установим новое значение для данного свойства данного элемента
$test  = CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
echo json_encode($test);

?>