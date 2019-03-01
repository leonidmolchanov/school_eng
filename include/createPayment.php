
<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 08/01/2019
 * Time: 15:20
 */
global $USER;

function lessonP($id, $val, $type){
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
}
CModule::IncludeModule('Sale');

    $sum=0;
    $desc="";
    if($_REQUEST['debit']=='Y'){
        $sum+=$_REQUEST['amount'];
        $desc = $_REQUEST['comments'];
        lessonP($_REQUEST['userid'], $_REQUEST['lessonBalance'], 'add');
    }
    else{
        $sum-=$_REQUEST['amount'];
        $desc = $_REQUEST['comments'];
        lessonP($_REQUEST['userid'], $_REQUEST['lessonBalance'], 'remove');

    }
   $d =  CSaleUserAccount::UpdateAccount(
      $_REQUEST['userid'],
       $sum,
      "RUB",
       $desc,
       $desc
);
if($d){
    if($_REQUEST['transactionid']){
        $ELEMENT_ID = $_REQUEST['transactionid'];  // код элемента
        $PROPERTY_CODE = "STATUS";  // код свойства
        $PROPERTY_CODE2 = "USERID";
            $PROPERTY_VALUE = 1;  // значение свойства
// Установим новое значение для данного свойства данного элемента
        $test  = CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
        $test  = CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE2 => $_REQUEST['userid']));
    }
    echo json_encode("success");
}
//}
?>