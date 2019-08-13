<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 20/01/2019
 * Time: 23:13
 */

$room=[];
    $group=[];
    $groupCheck=[];

if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'AUDITORIUM',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_COLOR')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        if(!$room[$ar_fields['ID']]){
            $room[$ar_fields['ID']]=[];
        }
        array_push($room[$ar_fields['ID']], $ar_fields);
    }
endif;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_TEACHER')
    );

    while($ar_fields = $my_elements->GetNext())
    {
//        if($ar_fields['PROPERTY_TEACHER_VALUE']==$_REQUEST['teacherId']) {
            array_push($group , $ar_fields['ID']);
//        }
                if($ar_fields['PROPERTY_TEACHER_VALUE']==$_REQUEST['teacherId']) {
        array_push($groupCheck , $ar_fields['ID']);
        }
    }
endif;
$lessons = $room;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList(
        Array("PROPERTY_TO" => "ASC"),
        Array("IBLOCK_CODE" => 'LESSON',
            'PROPERTY_GROUP'=> $group,
            'PROPERTY_SCHOOL_ID'=>$schoolID,
            '>=PROPERTY_TO' => date("Y-m-d", strtotime($_REQUEST['dateFrom'])).' '.date("H:i:s", strtotime($_REQUEST['timeFrom'])),
            '<=PROPERTY_FROM' => date("Y-m-d", strtotime($_REQUEST['dateTo'])).' '.date("H:i:s", strtotime($_REQUEST['timeTo']))),
        false,
        false,
        Array('ID', 'NAME', 'PROPERTY_FROM', 'PROPERTY_TO', 'PROPERTY_GROUP', 'PROPERTY_AUDITORIUM', 'PROPERTY_REPEAT')
    );

    while ($ar_fields = $my_elements->GetNext()) {
        if(!$lessons[$ar_fields['PROPERTY_AUDITORIUM_VALUE']]){
            $lessons[$ar_fields['PROPERTY_AUDITORIUM_VALUE']]=[];
        }
        if(in_array($ar_fields['PROPERTY_GROUP_VALUE'], $groupCheck))
        {

            foreach ($room as $key => $value) {
if($ar_fields['PROPERTY_AUDITORIUM_VALUE']!==$key){
    array_push($lessons[$key], $ar_fields);
}
            }
        }
        array_push($lessons[$ar_fields['PROPERTY_AUDITORIUM_VALUE']], $ar_fields);
    }
endif;


$freetime=[];
foreach ($lessons as $key => $value) {
    $starttime=strtotime(date("Y-m-d", strtotime($_REQUEST['dateFrom'])).' '.date("H:i:s", strtotime($_REQUEST['timeFrom'])));
    $endtime=strtotime(date("Y-m-d", strtotime($_REQUEST['dateTo'])).' '.date("H:i:s", strtotime($_REQUEST['timeTo'])));
    if(!empty($lessons[$key])) {
        foreach ($value as $value2) {
if(!$starttime){
    $starttime=strtotime(date("Y-m-d", strtotime($_REQUEST['dateFrom'])).' '.date("H:i:s", strtotime($_REQUEST['timeFrom'])));

}
            if ((int)$_REQUEST['interval'] * 60 <= (strtotime($value2['PROPERTY_FROM_VALUE']) - $starttime)) {
                $e = [];
                $e['FROM'] = date("Y-m-d H:i",$starttime);
                $e['TO'] = date("Y-m-d H:i",strtotime($value2['PROPERTY_FROM_VALUE']));
                $e['AUDITORIUM'] = $key;
                array_push($freetime, $e);
            }
            $starttime = strtotime($value2['PROPERTY_TO_VALUE']);
        }
    }
        if(!$starttime){
            $starttime=strtotime(date("Y-m-d", strtotime($_REQUEST['dateFrom'])).' '.date("H:i:s", strtotime($_REQUEST['timeFrom'])));

        }
        if ((int)$_REQUEST['interval'] * 60 <= ($endtime - $starttime)) {
            $e = [];
            $e['FROM'] = date("Y-m-d H:i", $starttime);
            $e['TO'] = date("Y-m-d H:i", $endtime);
            $e['AUDITORIUM'] = $key;
            array_push($freetime, $e);
        }

}

$request=Array('FREETIME'=>$freetime, 'AUDITORIUM'=> $room);

    echo json_encode($request);
    ?>