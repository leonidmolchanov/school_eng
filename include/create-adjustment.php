<?
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
$el = new CIBlockElement;

$PROP = array();
$PROP["USERID"] = $_REQUEST["userid"];  // учитель для группы
$PROP["DATESET"] = date("d.m.Y H:i");  // учитель для группы
$PROP["STATUS"] = 0;
$PROP["ALESSONID"] = $_REQUEST["lessonid"];  // учитель для группы
$PROP["DESCRIPTION"] = $_REQUEST["description"];  // учитель для группы
$PROP['SCHOOL_ID']=$schoolID;
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $iblockid,
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => 'Отработка',
    "ACTIVE"         => "Y"
);

if($PRODUCT_ID = $el->Add($arLoadProductArray))
    $request = 'Success';
else
    $request = 'Error'.$_REQUEST["name"];

echo json_encode($request);
?>

