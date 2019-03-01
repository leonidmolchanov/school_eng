<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 08/01/2019
 * Time: 20:11
 */

global $USER;


$balance=0;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'STUDENTS', 'ID'=>$_REQUEST['elementid']),
        false,
        false,
        Array('ID', 'PROPERTY_DOGOVOR','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME', 'PROPERTY_LESSON_BALANCE')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $balance=$ar_fields['PROPERTY_LESSON_BALANCE_VALUE'];
    }
endif;

$el = new CIBlockElement;

$PROP = array();
$PROP["DOGOVOR"] = $_REQUEST['dogovor'];
$PROP["NAME"] = $_REQUEST['name'];
$PROP["LAST_NAME"] = $_REQUEST['lastname'];
$PROP["SECOND_NAME"] = $_REQUEST['secondname'];
$PROP["BIRTHDAY"] = $_REQUEST['date'];
$PROP["TEL"] = $_REQUEST['tel'];
$PROP["FATHER_NAME"] = $_REQUEST['fathername'];
$PROP["FATHER_LAST_NAME"] = $_REQUEST['fatherlastname'];
$PROP["FATHER_SECOND_NAME"] = $_REQUEST['fathersecondname'];
$PROP["FATHER_TEL"] = $_REQUEST['fathertel'];
$PROP["MOTHER_NAME"] = $_REQUEST['mothername'];
$PROP["MOTHER_SECOND_NAME"] = $_REQUEST['mothersecondname'];
$PROP["MOTHER_LAST_NAME"] = $_REQUEST['motherlastname'];
$PROP["MOTHER_TEL"] = $_REQUEST['mothertel'];
$PROP["COMMENTS"] = $_REQUEST['comments'];
$PROP["STATUS"] = $_REQUEST['status'];
$PROP["USERID"] = $_REQUEST['userid'];
$PROP["LESSON_BALANCE"] = $balance;
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $_REQUEST['iblockid'],
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => $_REQUEST['elementname'],
    "ACTIVE"         => "Y"
);

if($el->Update($_REQUEST['elementid'],$arLoadProductArray))
    $request = 'success';
else
    $request = 'Error'.$_REQUEST["name"];

echo json_encode($request);

?>