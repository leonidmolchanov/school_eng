<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 08/01/2019
 * Time: 20:11
 */

global $USER;


$iblock = 0;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'TRIAL', 'ID'=>$_REQUEST['id']),
        false,
        false,
        Array('ID', 'PROPERTY_DOGOVOR','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME', 'PROPERTY_LESSON_BALANCE', 'IBLOCK_ID',
            'PROPERTY_SCHOOL_ID'=>$schoolID)
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $iblock=$ar_fields['IBLOCK_ID'];
    }
endif;

$el = new CIBlockElement;

$PROP = array();
$PROP["NAME"] = $_REQUEST["name"];  // учитель для группы
$PROP["FAMILY_NAME"] = $_REQUEST["familyName"];
$PROP["AGE"] = $_REQUEST["age"];
$PROP["DATE"] = date("d.m.Y", strtotime($_REQUEST["date"]));
$PROP["TEL"] = $_REQUEST['tel'];
$PROP["SOURCE"] = $_REQUEST['source'];
$PROP["TEACHER_ID"] = $_REQUEST['teacherId'];
$PROP["AUDITORIUM_ID"] = $_REQUEST['auditoriumId'];
$PROP["DATE_LESSON"] = date("d.m.Y H:i", strtotime($_REQUEST["dateLesson"]." ".$_REQUEST["timeLesson"]));
$PROP["STATUS"] = $_REQUEST['status'];
$PROP["DESCRIPTION"] = $_REQUEST['description'];
$PROP['SCHOOL_ID']=$schoolID;

$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $iblock,
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => $_REQUEST['name'],
    "ACTIVE"         => "Y"
);

if($el->Update($_REQUEST['id'],$arLoadProductArray))
    $request = 'Success';
else
    $request = 'Error'.$_REQUEST["id"];

echo json_encode($request);

?>