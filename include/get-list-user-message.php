<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 24/02/2019
 * Time: 00:36
 */

// Определение групп пользователей
$isAdmin=1;
$isMethodist=9;
$isTeacher=8;
$isStudent=7;
$privilege=0;
$arGroups = $USER->GetUserGroupArray();
foreach ($arGroups as $state){
    if($state==$isAdmin){
        $privilege=1;
    }
    else if($state==$isMethodist){
        $privilege=2;
    }
    else if($state==$isTeacher){
        $privilege=3;
    }
    else if($state==$isStudent){
        $privilege=4;
    }
}
global $USER;
$users=[];
$filter = Array();
$rsUsers = CUser::GetList(($by = "ID"), ($order = "desc"), $filter);
while ($arUser = $rsUsers->Fetch()) {
    if(CFile::GetPath($arUser['PERSONAL_PHOTO'])) {
        $users[$arUser['ID']] = 'https://'.SITE_SERVER_NAME.CFile::GetPath($arUser['PERSONAL_PHOTO']);
    }
    else{
        $users[$arUser['ID']] = 'https://'.SITE_SERVER_NAME.'/local/templates/school_eng/img/noPhoto.png';
    }
}
$usersList=[];




if($_REQUEST['group']):

    $structure=[];

    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'GROUP_STRUCTURE', "PROPERTY_GROUP_ID" => $_REQUEST['groupID'],
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID', 'PROPERTY_STUDENT_ID','PROPERTY_GROUP_ID')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            array_push($structure, $ar_fields['PROPERTY_STUDENT_ID_VALUE']);
        }

        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'STUDENTS', "ID" => $structure,
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID', 'PROPERTY_DOGOVOR','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME', 'PROPERTY_USERID')
        );

        while($ar_fields = $my_elements->GetNext())
        {

            if($ar_fields['PROPERTY_STATUS_VALUE']!==0){
                array_push($usersList, Array('ID'=>$ar_fields['PROPERTY_USERID_VALUE'],
                    'NAME'=>$ar_fields['PROPERTY_NAME_VALUE'],
                    'LAST_NAME'=>$ar_fields['PROPERTY_LAST_NAME_VALUE'],
                    'AVATAR'  => $users[$ar_fields['PROPERTY_USERID_VALUE']],
                    'DESCRIPTION'=>'Студент'));
            }        }

    endif;

    echo json_encode($usersList);

 else:

if($privilege==2):
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'STUDENTS',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_DOGOVOR','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME', 'PROPERTY_STATUS', 'PROPERTY_USERID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        if($ar_fields['PROPERTY_STATUS_VALUE']!==0){
        array_push($usersList, Array('ID'=>$ar_fields['PROPERTY_USERID_VALUE'],
            'NAME'=>$ar_fields['PROPERTY_NAME_VALUE'],
            'LAST_NAME'=>$ar_fields['PROPERTY_LAST_NAME_VALUE'],
            'AVATAR'  => $users[$ar_fields['PROPERTY_USERID_VALUE']],
            'DESCRIPTION'=>'Студент'));
    }

    }
endif;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'METHODIST',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_USER','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        if($ar_fields['PROPERTY_STATUS_VALUE']!==0){
            array_push($usersList, Array('ID'=>$ar_fields['PROPERTY_USER_VALUE'],
                'NAME'=>$ar_fields['PROPERTY_NAME_VALUE'],
                'LAST_NAME'=>$ar_fields['PROPERTY_LAST_NAME_VALUE'],
                'AVATAR'  => $users[$ar_fields['PROPERTY_USER_VALUE']],
                'DESCRIPTION'=>'Методист'));
        }

    }
endif;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'TEACHER',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_USER','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        if($ar_fields['PROPERTY_STATUS_VALUE']!==0){
            array_push($usersList, Array('ID'=>$ar_fields['PROPERTY_USER_VALUE'],
                'NAME'=>$ar_fields['PROPERTY_NAME_VALUE'],
                'LAST_NAME'=>$ar_fields['PROPERTY_LAST_NAME_VALUE'],
                'AVATAR'  => $users[$ar_fields['PROPERTY_USER_VALUE']],
                'DESCRIPTION'=>'Учитель'));
        }

    }
endif;
    endif;
if($privilege==3):
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'METHODIST',
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID', 'PROPERTY_USER','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            if($ar_fields['PROPERTY_STATUS_VALUE']!==0){
                array_push($usersList, Array('ID'=>$ar_fields['PROPERTY_USER_VALUE'],
                    'NAME'=>$ar_fields['PROPERTY_NAME_VALUE'],
                    'LAST_NAME'=>$ar_fields['PROPERTY_LAST_NAME_VALUE'],
                    'AVATAR'  => $users[$ar_fields['PROPERTY_USER_VALUE']],
                    'DESCRIPTION'=>'Методист'));
            }

        }
    endif;
    $groupID=[];
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'GROUP', "PROPERTY_TEACHER" => $USER->GetID(),
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID', 'PROPERTY_TEACHER')
        );

        while($ar_fields = $my_elements->GetNext())
        {

            array_push($groupID, $ar_fields['ID']);

        }
    endif;
$studentArr=[];

    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'GROUP_STRUCTURE', "PROPERTY_GROUP_ID" => $groupID,
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID', 'PROPERTY_STUDENT_ID','PROPERTY_GROUP_ID')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            array_push($studentArr, $ar_fields['PROPERTY_STUDENT_ID_VALUE']);
        }

    endif;

    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'STUDENTS', 'ID'=>$studentArr,
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID', 'PROPERTY_DOGOVOR','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME', 'PROPERTY_STATUS', 'PROPERTY_USERID')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            if($ar_fields['PROPERTY_STATUS_VALUE']!==0){
                array_push($usersList, Array('ID'=>$ar_fields['PROPERTY_USERID_VALUE'],
                    'NAME'=>$ar_fields['PROPERTY_NAME_VALUE'],
                    'LAST_NAME'=>$ar_fields['PROPERTY_LAST_NAME_VALUE'],
                    'AVATAR'  => $users[$ar_fields['PROPERTY_USERID_VALUE']],
                    'DESCRIPTION'=>'Студент'));
            }

        }
    endif;

    endif;
if($privilege==4):
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'METHODIST',
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID', 'PROPERTY_USER','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            if($ar_fields['PROPERTY_STATUS_VALUE']!==0){
                array_push($usersList, Array('ID'=>$ar_fields['PROPERTY_USER_VALUE'],
                    'NAME'=>$ar_fields['PROPERTY_NAME_VALUE'],
                    'LAST_NAME'=>$ar_fields['PROPERTY_LAST_NAME_VALUE'],
                    'AVATAR'  => $users[$ar_fields['PROPERTY_USER_VALUE']],
                    'DESCRIPTION'=>'Методист'));
            }

        }
    endif;

    $studentID=0;
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'STUDENTS', 'PROPERTY_USERID'=>$USER->GetID(),
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID')
        );

        while($ar_fields = $my_elements->GetNext())
        {

           $studentID= $ar_fields["ID"];

        }
        endif;
        $groupID=[];
    if (CModule::IncludeModule("iblock")):
        # show url my elements
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

    endif;
        $teacherID=[];
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'GROUP', "ID" => $groupID,
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID', 'PROPERTY_TEACHER')
        );

        while($ar_fields = $my_elements->GetNext())
        {

            array_push($teacherID, $ar_fields['PROPERTY_TEACHER_VALUE']);

        }
    endif;
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'TEACHER', 'ID'=> $teacherID,
                'PROPERTY_SCHOOL_ID'=>$schoolID),
            false,
            false,
            Array('ID', 'PROPERTY_USER','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            if($ar_fields['PROPERTY_STATUS_VALUE']!==0){
                array_push($usersList, Array('ID'=>$ar_fields['PROPERTY_USER_VALUE'],
                    'NAME'=>$ar_fields['PROPERTY_NAME_VALUE'],
                    'LAST_NAME'=>$ar_fields['PROPERTY_LAST_NAME_VALUE'],
                    'AVATAR'  => $users[$ar_fields['PROPERTY_USER_VALUE']],
                    'DESCRIPTION'=>'Учитель'));
            }

        }
    endif;

    endif;
echo json_encode($usersList);




endif;
?>