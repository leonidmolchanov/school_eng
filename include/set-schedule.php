<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 13/03/2019
 * Time: 20:35
 */



if($_REQUEST['action']=='global'):

    global $USER;
    $iblockid=0;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "desc"),
        Array("IBLOCK_CODE" => 'SCHEDULE', "PROPERTY_TYPE"=>"GLOBAL",
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $iblockid = $ar_fields['ID'];
    }
endif;
$el = new CIBlockElement;
$data = json_decode($_REQUEST["data"]);
$PROP = array();
if($data->weekend->mon){
    $PROP["MON"] =1;
}
else{
    $PROP["MON"] =0;

}
if($data->weekend->tue){
    $PROP["TUE"] =1;
}
else{
    $PROP["TUE"] =0;

}if($data->weekend->wen){
    $PROP["WEN"] =1;
}
else{
    $PROP["WEN"] =0;

}if($data->weekend->thu){
    $PROP["THU"] =1;
}
else{
    $PROP["THU"] =0;

}if($data->weekend->fri){
    $PROP["FRI"] =1;
}
else{
    $PROP["FRI"] =0;

}if($data->weekend->sat){
    $PROP["SAT"] =1;
}
else{
    $PROP["SAT"] =0;

}if($data->weekend->sun){
    $PROP["SUN"] =1;
}
else{
    $PROP["SUN"] =0;

}
$PROP['TYPE']="GLOBAL";
$arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "PROPERTY_VALUES"=> $PROP,
    "NAME"           => 'weekend',
    "ACTIVE"         => "Y"
);

if($el->Update($iblockid,$arLoadProductArray))
    $request = 'Success';
else
    $request = 'Error';


$weekendsBlockId=0;
if(CModule::IncludeModule("iblock"))
{

    $ib_list = CIBlock::GetList(
        Array(),
        Array(
            "CODE" => "WEEKENDS",
            "CHECK_PERMISSIONS" => "N"
        )
    );
    while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
    {
        $weekendsBlockId = $arIBlock["ID"];

    }
}

$weekends=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "desc"),
        Array("IBLOCK_CODE" => 'WEEKENDS', "PROPERTY_TYPE"=>"GLOBAL",
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_DATE')
    );

    while($ar_fields = $my_elements->GetNext())
    {
$weekends[$ar_fields['ID']]=date('d.m', strtotime($ar_fields['PROPERTY_DATE_VALUE']));
    }
endif;
foreach ($data->schedule as $item){

    if(!in_array($item, $weekends)){

        $el = new CIBlockElement;

        $PROP = array();
        $PROP["DATE"] = $item.'.03';  // учитель для группы
        $PROP['TYPE']="GLOBAL";

        $arLoadProductArray = Array(
            "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
            "IBLOCK_ID"      => $weekendsBlockId,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => 'weekend',
            "ACTIVE"         => "Y"
        );
        if($PRODUCT_ID = $el->Add($arLoadProductArray))
            $request = 'Success';
        else
            $request = 'Error';
    }

    foreach ($weekends as $key => $item) {

        if(!in_array($item, $data->schedule) ){
            $DB->StartTransaction();
            if(!CIBlockElement::Delete($key))
            {
                $request='error';
                $strWarning .= 'Error!';
                $DB->Rollback();
            }
            else{
                $DB->Commit();
            $request='Success';
            }

        }
    }
    }
if(empty($data->schedule)):
    foreach ($weekends as $key => $item) {

        if(!in_array($item, $data->schedule) ){
            $DB->StartTransaction();
            if(!CIBlockElement::Delete($key))
            {
                $request='error';
                $strWarning .= 'Error!';
                $DB->Rollback();
            }
            else{
                $DB->Commit();
                $request='Success';
            }

        }
    }
    endif;

echo json_encode($request);

elseif($_REQUEST['action']=='holidays'):




    $weekendsBlockId=0;
    if(CModule::IncludeModule("iblock"))
    {

        $ib_list = CIBlock::GetList(
            Array(),
            Array(
                "CODE" => "WEEKENDS",
                "CHECK_PERMISSIONS" => "N"
            )
        );
        while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
        {
            $weekendsBlockId = $arIBlock["ID"];

        }
    }

    $weekends=[];
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "desc"),
            Array("IBLOCK_CODE" => 'WEEKENDS', "PROPERTY_TYPE"=>"HOLIDAYS",
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID', 'PROPERTY_DATE')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            $weekends[$ar_fields['ID']]=date('d.m', strtotime($ar_fields['PROPERTY_DATE_VALUE']));
        }
    endif;
    $data = json_decode($_REQUEST["data"]);

    foreach ($data as $item){
        $test = 'yes';
        if(!in_array($item, $weekends)){

            $el = new CIBlockElement;

            $PROP = array();
            $PROP["DATE"] = $item.'.03';  // учитель для группы
            $PROP['TYPE']="HOLIDAYS";
            $arLoadProductArray = Array(
                "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
                "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                "IBLOCK_ID"      => $weekendsBlockId,
                "PROPERTY_VALUES"=> $PROP,
                "NAME"           => 'holiday',
                "ACTIVE"         => "Y"
            );
            if($PRODUCT_ID = $el->Add($arLoadProductArray))
                $request = 'Success';
            else
                $request = 'Error';
        }


    }


        foreach ($weekends as $key => $item) {

            if(!in_array($item, $data) ){
                $DB->StartTransaction();
                if(!CIBlockElement::Delete($key))
                {
                    $request='error';
                    $strWarning .= 'Error!';
                    $DB->Rollback();
                }
                else{
                    $DB->Commit();
                    $request='Success';
                }

            }
        }
    echo json_encode($request);







else:
    global $USER;
    $iblockid=0;

    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "desc"),
            Array("IBLOCK_CODE" => 'SCHEDULE', "PROPERTY_TYPE"=>"TEACHER", "PROPERTY_TEACHER_ID"=>$_REQUEST["action"],
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            $iblockid = $ar_fields['ID'];
        }
    endif;
    $el = new CIBlockElement;
    $data = json_decode($_REQUEST["data"]);
    $PROP = array();
    if($data->weekend->mon){
        $PROP["MON"] =1;
    }
    else{
        $PROP["MON"] =0;

    }
    if($data->weekend->tue){
        $PROP["TUE"] =1;
    }
    else{
        $PROP["TUE"] =0;

    }if($data->weekend->wen){
    $PROP["WEN"] =1;
}
else{
    $PROP["WEN"] =0;

}if($data->weekend->thu){
    $PROP["THU"] =1;
}
else{
    $PROP["THU"] =0;

}if($data->weekend->fri){
    $PROP["FRI"] =1;
}
else{
    $PROP["FRI"] =0;

}if($data->weekend->sat){
    $PROP["SAT"] =1;
}
else{
    $PROP["SAT"] =0;

}if($data->weekend->sun){
    $PROP["SUN"] =1;
}
else{
    $PROP["SUN"] =0;

}
    $PROP['TYPE']="TEACHER";
    $PROP['TEACHER_ID']=$_REQUEST["action"];
    $PROP['PROPERTY_SCHOOL_ID']= $schoolID;


    if($iblockid!==0) {
        $arLoadProductArray = Array(
            "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => 'weekend',
            "ACTIVE"         => "Y"
        );
        if ($el->Update($iblockid, $arLoadProductArray))
            $request = 'Success';
        else
            $request = 'Error';

    }
    else{
        $arLoadProductArray = Array(
            "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
            "PROPERTY_VALUES"=> $PROP,
            "IBLOCK_ID"      => 18,
            "NAME"           => 'weekend',
            "ACTIVE"         => "Y"
        );
        if ($el->Add($arLoadProductArray))
            $request = 'Success';
        else
            $request = 'Error';

    }


    $weekendsBlockId=0;
    if(CModule::IncludeModule("iblock"))
    {

        $ib_list = CIBlock::GetList(
            Array(),
            Array(
                "CODE" => "WEEKENDS",
                "CHECK_PERMISSIONS" => "N"
            )
        );
        while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
        {
            $weekendsBlockId = $arIBlock["ID"];

        }
    }

    $weekends=[];
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "desc"),
            Array("IBLOCK_CODE" => 'WEEKENDS', "PROPERTY_TYPE"=>"TEACHER", "PROPERTY_TEACHER_ID"=>$_REQUEST["action"],
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID', 'PROPERTY_DATE')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            $weekends[$ar_fields['ID']]=date('d.m', strtotime($ar_fields['PROPERTY_DATE_VALUE']));
        }
    endif;
    foreach ($data->schedule as $item){

        if(!in_array($item, $weekends)){

            $el = new CIBlockElement;

            $PROP = array();
            $PROP["DATE"] = $item.'.03';  // учитель для группы
            $PROP['TYPE']="TEACHER";
            $PROP['SCHOOL_ID']=$schoolID;

            $PROP["TEACHER_ID"]=$_REQUEST["action"];
            $arLoadProductArray = Array(
                "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
                "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                "IBLOCK_ID"      => $weekendsBlockId,
                "PROPERTY_VALUES"=> $PROP,
                "NAME"           => 'weekend',
                "ACTIVE"         => "Y"
            );
            if($PRODUCT_ID = $el->Add($arLoadProductArray))
                $request = 'Success';
            else
                $request = 'Error';
        }

        foreach ($weekends as $key => $item) {

            if(!in_array($item, $data->schedule)){
                $DB->StartTransaction();
                if(!CIBlockElement::Delete($key))
                {
                    $request='error';
                    $strWarning .= 'Error!';
                    $DB->Rollback();
                }
                else{
                    $DB->Commit();
                    $request='Success';
                }

            }
        }
    }

    if(empty($data->schedule)):
        foreach ($weekends as $key => $item) {

            if(!in_array($item, $data->schedule) ){
                $DB->StartTransaction();
                if(!CIBlockElement::Delete($key))
                {
                    $request='error';
                    $strWarning .= 'Error!';
                    $DB->Rollback();
                }
                else{
                    $DB->Commit();
                    $request='Success';
                }

            }
        }
    endif;
    echo json_encode($request);


endif;










