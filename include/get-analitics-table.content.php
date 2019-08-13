<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 10/12/2018
 * Time: 16:30
 */
$structure=[];
$students=[];

$Month_r = array(
    "01" => "Январь",
    "02" => "Февраль",
    "03" => "Март",
    "04" => "Апрель",
    "05" => "Май",
    "06" => "Июнь",
    "07" => "Июль",
    "08" => "Август",
    "09" => "Сентябрь",
    "10" => "Октябрь",
    "11" => "Ноябрь",
    "12" => "Декабрь");



$from =  date("01.m.Y", strtotime("-1 month"));
$to =  date("d.m.Y");
if($_REQUEST['from']){
    $from =  date("d.m.Y", strtotime($_REQUEST['from']));

}
if($_REQUEST['to']){
    $to =  date("d.m.Y", strtotime($_REQUEST['to']));
}


if (CModule::IncludeModule("iblock")):
# show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP_STRUCTURE', "PROPERTY_GROUP_ID" => $_REQUEST['id'],
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_STUDENT_ID','PROPERTY_GROUP_ID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($structure, $ar_fields['PROPERTY_STUDENT_ID_VALUE']);
    }
//    if (CModule::IncludeModule("iblock")):
//        $my_elements = CIBlockElement::GetList (
//            Array("ID" => "ASC"),
//            Array("IBLOCK_CODE" => 'STUDENTS', "ID" => $structure),
//            false,
//            false,
//            Array('ID', 'PROPERTY_DOGOVOR','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME')
//        );
//
//        while($ar_fields = $my_elements->GetNext())
//        {
//            $students[$ar_fields['ID']]= $ar_fields;
//        }
//    endif;

    $content = [];
    $structure2=[];
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'JOURNAL',
            "PROPERTY_GROUPID" => $_REQUEST['id'],
            '>=DATE_CREATE' => $from.' 00:00',
            '<=DATE_CREATE' => $to.' 23:99',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_BE','PROPERTY_NOTBE','PROPERTY_DISEASE','PROPERTY_BLOCK','PROPERTY_SUB', 'DATE_CREATE',  'PROPERTY_GROUPID')
    );

    while($ar_fields = $my_elements->GetNext()) {

foreach ($structure as $valueS){
            if(!$content[date("m", strtotime($ar_fields['DATE_CREATE']))][date("j", strtotime($ar_fields['DATE_CREATE']))][$valueS]){
                $content[date("m", strtotime($ar_fields['DATE_CREATE']))][date("j", strtotime($ar_fields['DATE_CREATE']))][$valueS]=4;
            }
}


//       echo  date("m", strtotime($ar_fields['DATE_CREATE']));

        if(!$content[date("m", strtotime($ar_fields['DATE_CREATE']))]){
            $content[date("m", strtotime($ar_fields['DATE_CREATE']))]=[];
        }

        if(!$content[date("m", strtotime($ar_fields['DATE_CREATE']))][date("j", strtotime($ar_fields['DATE_CREATE']))]){
            $content[date("m", strtotime($ar_fields['DATE_CREATE']))][date("j", strtotime($ar_fields['DATE_CREATE']))]=[];
        }


        if(is_array($ar_fields['PROPERTY_DISEASE_VALUE'])){
            foreach ($ar_fields['PROPERTY_DISEASE_VALUE'] as $item){
                if($item):

                        $content[date("m", strtotime($ar_fields['DATE_CREATE']))][date("j", strtotime($ar_fields['DATE_CREATE']))][$item]=2;

                endif;
            }

        }
        else{
            if($ar_fields['PROPERTY_DISEASE_VALUE']):
                    $content[date("m", strtotime($ar_fields['DATE_CREATE']))][date("j", strtotime($ar_fields['DATE_CREATE']))][$ar_fields['PROPERTY_DISEASE_VALUE']]=2;

            endif;
        }

        if(is_array($ar_fields['PROPERTY_NOTBE_VALUE'])){
            foreach ($ar_fields['PROPERTY_NOTBE_VALUE'] as $item){
                if($item):

                        $content[date("m", strtotime($ar_fields['DATE_CREATE']))][date("j", strtotime($ar_fields['DATE_CREATE']))][$item]=3;

                endif;
            }

        }
        else{
            if($ar_fields['PROPERTY_NOTBE_VALUE']):
                    $content[date("m", strtotime($ar_fields['DATE_CREATE']))][date("j", strtotime($ar_fields['DATE_CREATE']))][$ar_fields['PROPERTY_NOTBE_VALUE']]=3;

            endif;
        }

        if(is_array($ar_fields['PROPERTY_BE_VALUE'])){
            foreach ($ar_fields['PROPERTY_BE_VALUE'] as $item){
                if($item):
                        $content[date("m", strtotime($ar_fields['DATE_CREATE']))][date("j", strtotime($ar_fields['DATE_CREATE']))][$item]=1;

                endif;
            }

        }
        else{
            if($ar_fields['PROPERTY_BE_VALUE']):
                    $content[date("m", strtotime($ar_fields['DATE_CREATE']))][date("j", strtotime($ar_fields['DATE_CREATE']))][$ar_fields['PROPERTY_BE_VALUE']]=1;

            endif;
        }

    }

    endif;


    echo json_encode($content);
    ?>