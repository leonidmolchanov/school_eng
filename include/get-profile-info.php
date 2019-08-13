<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 17/12/2018
 * Time: 01:05
 */
$request=[];
$request['TEST']=$USER->GetID();
$request['STUDENT']=[];
$request['GROUP']=[];
$request['STUDY']=[];
$request['ADJUSTMENT']=[];
$request['JOURNAL']=Array('BE'=>Array(),'NOTBE'=>Array(),'DISEASE'=>Array());
$studentID=[];
$groupID=[];
$teacher=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'STUDENTS', 'PROPERTY_USERID'=>$USER->GetID(),
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID','PROPERTY_DOGOVOR','PROPERTY_NAME',
            'PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME',
            'PROPERTY_BIRTHDAY','PROPERTY_TEL',
        'PROPERTY_FATHER_NAME','PROPERTY_FATHER_LAST_NAME','PROPERTY_FATHER_SECOND_NAME','PROPERTY_FATHER_TEL',
        'PROPERTY_MOTHER_NAME','PROPERTY_MOTHER_SECOND_NAME','PROPERTY_MOTHER_LAST_NAME','PROPERTY_MOTHER_TEL',
        'PROPERTY_COMMENTS','PROPERTY_USERID','PROPERTY_BALANCE')
    );

    while($ar_fields = $my_elements->GetNext())
    {

        $request['STUDENT']= $ar_fields;
        array_push($studentID, $ar_fields["ID"]);

    }

    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'JOURNAL', 'PROPERTY_BE'=>$request['STUDENT']['ID'],
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('NAME', 'DATE_CREATE')
    );

    while($ar_fields = $my_elements->GetNext())
    {

        array_push($request['JOURNAL']['BE'], $ar_fields);

    }
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'JOURNAL', 'PROPERTY_NOTBE'=>$request['STUDENT']['ID'],
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('NAME', 'DATE_CREATE')
    );

    while($ar_fields = $my_elements->GetNext())
    {

        array_push($request['JOURNAL']['NOTBE'], $ar_fields);

    }
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'JOURNAL', 'PROPERTY_DISEASE'=>$request['STUDENT']['ID'],
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('NAME', 'DATE_CREATE')
    );

    while($ar_fields = $my_elements->GetNext())
    {

        array_push($request['JOURNAL']['DISEASE'], $ar_fields);

    }
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP_STRUCTURE', "PROPERTY_STUDENT_ID" => $studentID,
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_STUDENT_ID','PROPERTY_GROUP_ID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($groupID, $ar_fields['PROPERTY_GROUP_ID_VALUE']);
    }

    // Если что-то есть..
if(empty($groupID)):
    $groupID=0;
    endif;
        $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP', 'ID'=>$groupID,
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_TEACHER')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $teacher =  getTeacher($ar_fields['PROPERTY_TEACHER_VALUE']);
        array_push($request['GROUP'], $ar_fields);
    }
endif;

foreach ($request['GROUP'] as $value) {

    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'LESSON', "PROPERTY_GROUP" => $value["ID"],
            'PROPERTY_SCHOOL_ID'=>$schoolID,
            '>=PROPERTY_FROM' => date('Y-m-d', strtotime('monday this week') . ' 00:00:00'),
            '<=PROPERTY_FROM' => date('Y-m-d', strtotime('sunday this week') . ' 23:59:59')),
        false,
        false,
        Array('ID', 'PROPERTY_TEACHER','PROPERTY_FROM','PROPERTY_TO','PROPERTY_AUDITORIUM')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $days = array( 1 => "Понедельник" , "Вторник" , "Среда" , "Четверг" , "Пятница" , "Суббота" , "Воскресенье" );
        $ar_fields['DAY'] = $days[date('N', strtotime($ar_fields['PROPERTY_FROM_VALUE']))];
        $ar_fields['PROPERTY_FROM_VALUE']=date('Y-m-d H:i', strtotime($ar_fields['PROPERTY_FROM_VALUE']));
        $ar_fields['PROPERTY_TO_VALUE']=date('Y-m-d H:i', strtotime($ar_fields['PROPERTY_TO_VALUE']));
        $ar_fields['TEACHER'] =  $teacher;
        $ar_fields['COLOR'] =  getColor($ar_fields['PROPERTY_AUDITORIUM_VALUE']);
        $ar_fields['GROUP'] = $value;
        array_push($request['STUDY'], $ar_fields);
    }

}

function getLesson($id){
    $result=[];
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'LESSON', "ID" => $id,
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'NAME', 'PROPERTY_FROM', 'PROPERTY_TO', 'PROPERTY_AUDITORIUM', 'PROPERTY_GROUP')
    );
    $result=[];
    while($ar_fields = $my_elements->GetNext())
    {
        $ar_fields['PROPERTY_FROM_VALUE']=date('Y-m-d H:i', strtotime($ar_fields['PROPERTY_FROM_VALUE']));
        $ar_fields['PROPERTY_TO_VALUE']=date('Y-m-d H:i', strtotime($ar_fields['PROPERTY_TO_VALUE']));
        $result = $ar_fields;
    }
    return $result;
}


if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList(
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'ADJUSTMENT', 'PROPERTY_USERID'=> $studentID,
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_USERID', 'PROPERTY_ALESSONID', 'PROPERTY_DATASET', 'PROPERTY_DESCRIPTION', 'NAME', 'PROPERTY_STATUS'
        )
    );

    while ($ar_fields = $my_elements->GetNext()) {
        if ($ar_fields['PROPERTY_STATUS_VALUE'] == 0) {
            $ar_fields['LESSON'] = getLesson($ar_fields['PROPERTY_ALESSONID_VALUE']);
            array_push($request['ADJUSTMENT'], $ar_fields);
        }

    }
endif;
function getColor($auditID){

    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'AUDITORIUM', "ID" => $auditID,
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_COLOR')
    );
$result="";
    while($ar_fields = $my_elements->GetNext())
    {
        $result = $ar_fields['PROPERTY_COLOR_VALUE'];
    }
return $result;
}




function getTeacher($teacherID){

    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'TEACHER', "ID" => $teacherID,
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME','PROPERTY_BIRTHDAY','PROPERTY_TEL')
    );
    $result=[];
    while($ar_fields = $my_elements->GetNext())
    {
        $result = $ar_fields;
    }
    return $result;
}


echo json_encode($request);
?>