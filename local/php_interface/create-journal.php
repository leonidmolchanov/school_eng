<?
$schedule=[];
$weekend= false;
$dateFormat =             date("m-d", strtotime('now'));
$dayFormat =  date("D", strtotime('now'));
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'WEEKENDS', "PROPERTY_TYPE"=>"GLOBAL"),
            false,
            false,
            Array('PROPERTY_DATE')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            if( date("m-d", strtotime($ar_fields['PROPERTY_DATE_VALUE'])) == $dateFormat ){
             $weekend = true;
             echo "find";
            }
        }

        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'SCHEDULE', "PROPERTY_TYPE"=>"GLOBAL"),
            false,
            false,
            Array('PROPERTY_MON' ,
                'PROPERTY_TUE' ,
                'PROPERTY_WEN' ,
                'PROPERTY_THU' ,
                'PROPERTY_FRI' ,
                'PROPERTY_SAT' ,
                'PROPERTY_SUN' , )
        );

        $ar_fields = $my_elements->GetNext() ;
                $schedule['Mon'] = $ar_fields['PROPERTY_MON_VALUE'];
        $schedule['Tue'] = $ar_fields['PROPERTY_TUE_VALUE'];
        $schedule['Wed'] = $ar_fields['PROPERTY_WEN_VALUE'];
        $schedule['Thu'] = $ar_fields['PROPERTY_THU_VALUE'];
        $schedule['Fri'] = $ar_fields['PROPERTY_FRI_VALUE'];
        $schedule['Sat'] = $ar_fields['PROPERTY_SAT_VALUE'];
        $schedule['Sun'] = $ar_fields['PROPERTY_SUN_VALUE'];


    endif;

$scheduleTeacher=[];
$weekendsTeacher=[];

if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'SCHEDULE', "PROPERTY_TYPE"=>"TEACHER"),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_MON','PROPERTY_TUE','PROPERTY_WEN','PROPERTY_THU','PROPERTY_FRI','PROPERTY_SAT','PROPERTY_SUN', 'PROPERTY_TYPE', 'PROPERTY_TEACHER_ID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $scheduleTeacher[$ar_fields['PROPERTY_TEACHER_ID_VALUE']]=Array(
            'Mon' => $ar_fields['PROPERTY_MON_VALUE'],
            'Tue' => $ar_fields['PROPERTY_TUE_VALUE'],
            'Wed' => $ar_fields['PROPERTY_WEN_VALUE'],
            'Thu' => $ar_fields['PROPERTY_THU_VALUE'],
            'Fri' => $ar_fields['PROPERTY_FRI_VALUE'],
            'Sat' => $ar_fields['PROPERTY_SAT_VALUE'],
            'Sun' => $ar_fields['PROPERTY_SUN_VALUE']
        );
    }

    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'WEEKENDS', "PROPERTY_TYPE"=>"TEACHER"),
        false,
        false,
        Array('PROPERTY_DATE', 'PROPERTY_TEACHER_ID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        if(!$weekendsTeacher[$ar_fields['PROPERTY_TEACHER_ID_VALUE']]){
            $weekendsTeacher[$ar_fields['PROPERTY_TEACHER_ID_VALUE']]=[];
        }
        array_push($weekendsTeacher[$ar_fields['PROPERTY_TEACHER_ID_VALUE']],date("m-d", strtotime($ar_fields['PROPERTY_DATE_VALUE'])));
    }
endif;




if(!$weekend && (int) $schedule[$dayFormat]==0):
    $date = date("Y-m-d  H:i:s", strtotime('-15 minutes'));
    $dateEND = date("Y-m-d H:i:s", strtotime('+15 minutes'));
    echo $dateEND;
    $lessons = [];
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'LESSON',
                '>=PROPERTY_FROM' => $date,
                '<=PROPERTY_FROM' => $dateEND,),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_FROM', 'PROPERTY_TO', 'PROPERTY_GROUP', 'PROPERTY_AUDITORIUM', 'PROPERTY_SUB')
        );

        while ($ar_fields = $my_elements->GetNext()) {

            $groupID = CIBlockElement::GetList(
                Array("PROPERTY_TO" => "ASC"),
                Array("IBLOCK_CODE" => 'GROUP',
                    'ID' => $ar_fields['PROPERTY_GROUP_VALUE'],
                    ),
                false,
                false,
                Array('PROPERTY_TEACHER')
            );
$fields = $groupID->GetNext();

            if(!$scheduleTeacher[$fields['PROPERTY_TEACHER_VALUE']][$dayFormat]):
                if(!in_array($dateFormat, $weekendsTeacher[$fields['PROPERTY_TEACHER_VALUE']])):

            getJournal($ar_fields['ID'], $ar_fields['PROPERTY_GROUP_VALUE'], $ar_fields['NAME'],  $ar_fields['PROPERTY_SUB_VALUE']);
      endif;
      endif;

        }
    endif;




    ;

else:
    echo "not work";
endif;


function getJournal($id, $group, $name, $sub)
{
    $schoolid=false;
    $check = false;
    if (CModule::IncludeModule("iblock")):
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'JOURNAL',
                'PROPERTY_LESSONID' => $id),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_SCHOOL_ID', 'PROPERTY_FROM', 'PROPERTY_TO', 'PROPERTY_GROUP', 'PROPERTY_AUDITORIUM')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            $check = true;
            $schoolid = $ar_fields['PROPERTY_SCHOOL_ID_VALUE'];
        }
    endif;
    if (!$check) {
        getStudent($group, $id, $name, $sub, $schoolid);
    }
}


function getStudent($id, $lesson, $lessonName, $sub, $schoolid)
{
    echo $id;
    $student = [];
    echo "journal";
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'GROUP_STRUCTURE',
                "PROPERTY_GROUP_ID" => $id),
            false,
            false,
            Array('ID', 'PROPERTY_STUDENT_ID')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            array_push($student, $ar_fields['PROPERTY_STUDENT_ID_VALUE']);
        }
    endif;
    print_r($student);
    if (!empty($student)) {
        createJournal($id, $lesson, $lessonName, $student, $sub, $schoolid);
    }
}


function createJournal($id, $lesson, $lessonName, $student, $sub, $schoolid)
{
    $iblockid = 0;
    $block=[];
    $notbe=[];
    $disease=[];

    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'STUDENTS'),
            false,
            false,
            Array('ID', 'PROPERTY_STATUS')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            if (in_array($ar_fields['ID'], $student))
            {
                if($ar_fields['PROPERTY_STATUS_VALUE']==2){
                    array_push($disease, $ar_fields['ID']);
                }
                else if($ar_fields['PROPERTY_STATUS_VALUE']==1) {
                    array_push($notbe, $ar_fields['ID']);
                }
                else{
                    array_push($block, $ar_fields['ID']);

                }
            }

        }
    endif;

    if (CModule::IncludeModule("iblock")) {

        $ib_list = CIBlock::GetList(
            Array(),
            Array(
                "CODE" => "JOURNAL",
                "CHECK_PERMISSIONS" => "N"
            )
        );
        while ($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
        {
            $iblockid = $arIBlock["ID"];

        }
    }
    $checkJournal = false;
    if (CModule::IncludeModule("iblock")) {

        $ib_list = CIBlock::GetList(
            Array(),
            Array(
                "CODE" => "JOURNAL",
                "CHECK_PERMISSIONS" => "N",
                "NAME"=> $lessonName . "(" . date("d.m.Y", strtotime(now)) . ")",
                "PROPERTY_LESSONID"=>$lesson
            )
        );
        while ($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
        {
            $checkJournal = true;

        }
    }

    $el = new CIBlockElement;

    $PROP = array();
    $PROP["SCHOOL_ID"] = $schoolid;
    $PROP["GROUPID"] = $id;
    $PROP["LESSONID"] = $lesson;
    $PROP["NOTBE"] = $notbe;
    $PROP["BLOCK"] = $block;
    $PROP["DISEASE"]  = $disease;
    $PROP["SUB"]  = $sub;

    $arLoadProductArray = Array(
        "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
        "IBLOCK_ID" => $iblockid,
        "PROPERTY_VALUES" => $PROP,
        "NAME" => $lessonName . "(" . date("d.m.Y", strtotime(now)) . ")",
        "ACTIVE" => "Y"
    );
if(!$checkJournal) {
    if ($PROP["LESSONID"]):
        $request = "";
        if ($PRODUCT_ID = $el->Add($arLoadProductArray))
            $request = 'Success';
        else
            $request = 'Error' . $_REQUEST["name"];
        $pushtype = "journal";
        $message = "Создан журнал " . $lessonName . "(" . date("d.m.Y", strtotime(now)) . ")";
        require("push.php");

    endif;
}
}

?>