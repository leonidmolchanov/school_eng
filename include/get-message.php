<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 21/02/2019
 * Time: 02:58
 */
$message=[];
$users=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "desc"),
        Array("IBLOCK_CODE" => 'STUDENTS',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_NAME','PROPERTY_LAST_NAME', 'PROPERTY_USERID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $users[$ar_fields['PROPERTY_USERID_VALUE']]['NAME'] = $ar_fields['PROPERTY_NAME_VALUE'].' '.$ar_fields['PROPERTY_LAST_NAME_VALUE'];
        $users[$ar_fields['PROPERTY_USERID_VALUE']]['ONLINE']= CUser::IsOnLine($ar_fields['PROPERTY_USERID_VALUE']);
    }
endif;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "desc"),
        Array("IBLOCK_CODE" => 'TEACHER',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_NAME','PROPERTY_LAST_NAME', 'PROPERTY_USER')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $users[$ar_fields['PROPERTY_USER_VALUE']]['NAME'] = $ar_fields['PROPERTY_NAME_VALUE'].' '.$ar_fields['PROPERTY_LAST_NAME_VALUE'];
        $users[$ar_fields['PROPERTY_USER_VALUE']]['ONLINE']= CUser::IsOnLine($ar_fields['PROPERTY_USER_VALUE']);
    }
endif;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "desc"),
        Array("IBLOCK_CODE" => 'METHODIST',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_NAME','PROPERTY_LAST_NAME', 'PROPERTY_USER')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $users[$ar_fields['PROPERTY_USER_VALUE']]['NAME'] = $ar_fields['PROPERTY_NAME_VALUE'].' '.$ar_fields['PROPERTY_LAST_NAME_VALUE'];
        $users[$ar_fields['PROPERTY_USER_VALUE']]['ONLINE']= CUser::IsOnLine($ar_fields['PROPERTY_USER_VALUE']);
    }
endif;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "desc"),
        Array("IBLOCK_CODE" => 'CHAT',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'PROPERTY_TEXT','PROPERTY_FROM_ID','PROPERTY_TO_ID', 'DATE_CREATE')
    );

    while($ar_fields = $my_elements->GetNext()) {
        $date="";
        if(((strtotime('now'))-strtotime($ar_fields['DATE_CREATE']))<=360){
            $date = 'сейчас';
        }
        else if(((strtotime('now'))-strtotime($ar_fields['DATE_CREATE']))>360 && ((strtotime('now'))-strtotime($ar_fields['DATE_CREATE']))<3600){
            $date = 'в течении часа';
        }
        else if(((strtotime('now'))-strtotime($ar_fields['DATE_CREATE']))>360 && ((strtotime('now'))-strtotime($ar_fields['DATE_CREATE']))<3600){
            $date = 'в течении часа';
        }
        else if(((strtotime('now'))-strtotime($ar_fields['DATE_CREATE']))>3600 && ((strtotime('now'))-strtotime($ar_fields['DATE_CREATE']))<86400){
            $date = 'в течении суток';
        }
        else{
            $date = date("d.m.Y H:i", strtotime($ar_fields['DATE_CREATE']));
        }
        if ($_REQUEST['filter'] == 'incoming' && $ar_fields['PROPERTY_FROM_ID_VALUE']!==$USER->GetID()) {

            $dbUser = CUser::GetByID($ar_fields['PROPERTY_FROM_ID_VALUE']);
            $arUser = $dbUser->Fetch();
            if ($arUser["PERSONAL_PHOTO"]) {
                $URL = CFile::GetPath($arUser["PERSONAL_PHOTO"]);

            } else {
                $URL = '/local/templates/school_eng/img/noPhoto.png';
            }
            if ($ar_fields['PROPERTY_FROM_ID_VALUE'] == $USER->GetID()) {
                $from = 1;
            } else {
                $from = 2;
            }

            array_push($message, Array(
                'id' => $ar_fields['ID'],
                'from' => $ar_fields['PROPERTY_FROM_ID_VALUE'],
                'to' => $ar_fields['PROPERTY_TO_ID_VALUE'],
                'text' => $ar_fields['PROPERTY_TEXT_VALUE'],
                'avatar' => 'https://' . SITE_SERVER_NAME . $URL,
                'date' => $date,
                'avtor' => $from,
                'name' => $users[$ar_fields['PROPERTY_FROM_ID_VALUE']['NAME']]
            ));
        }
        if ($_REQUEST['filter'] == 'outgoing' && $ar_fields['PROPERTY_FROM_ID_VALUE']==$USER->GetID()) {

            $dbUser = CUser::GetByID($ar_fields['PROPERTY_FROM_ID_VALUE']);
            $arUser = $dbUser->Fetch();
            if ($arUser["PERSONAL_PHOTO"]) {
                $URL = CFile::GetPath($arUser["PERSONAL_PHOTO"]);

            } else {
                $URL = '/local/templates/school_eng/img/noPhoto.png';
            }
            $dbUserTo = CUser::GetByID($ar_fields['PROPERTY_TO_ID_VALUE']);
            $arUserTo = $dbUserTo->Fetch();
            if ($arUserTo["PERSONAL_PHOTO"]) {
                $URLTo = CFile::GetPath($arUser["PERSONAL_PHOTO"]);

            } else {
                $URLTo = '/local/templates/school_eng/img/noPhoto.png';
            }
            if ($ar_fields['PROPERTY_FROM_ID_VALUE'] == $USER->GetID()) {
                $from = 1;
            } else {
                $from = 2;
            }
            array_push($message, Array(
                'id' => $ar_fields['ID'],
                'from' => $ar_fields['PROPERTY_FROM_ID_VALUE'],
                'to' => $ar_fields['PROPERTY_TO_ID_VALUE'],
                'text' => $ar_fields['PROPERTY_TEXT_VALUE'],
                'avatar' => 'https://' . SITE_SERVER_NAME . $URL,
                'avatarTo' => 'https://' . SITE_SERVER_NAME . $URLTo,
                'date' => $date,
                'avtor' => $from,
                'name' => $users[$ar_fields['PROPERTY_FROM_ID_VALUE']['NAME']],
                                'nameFrom' => $users[$ar_fields['PROPERTY_From_ID_VALUE']],
                'online' => $users[$ar_fields['PROPERTY_FROM_ID_VALUE']]['ONLINE']

            ));
        }
        if ($_REQUEST['filter'] == 'all') {

            $dbUser = CUser::GetByID($ar_fields['PROPERTY_FROM_ID_VALUE']);
            $arUser = $dbUser->Fetch();
            if ($arUser["PERSONAL_PHOTO"]) {
                $URL = CFile::GetPath($arUser["PERSONAL_PHOTO"]);

            } else {
                $URL = '/local/templates/school_eng/img/noPhoto.png';
            }
            $dbUserTo = CUser::GetByID($ar_fields['PROPERTY_TO_ID_VALUE']);
            $arUserTo = $dbUserTo->Fetch();
            if ($arUserTo["PERSONAL_PHOTO"]) {
                $URLTo = CFile::GetPath($arUserTo["PERSONAL_PHOTO"]);

            } else {
                $URLTo = '/local/templates/school_eng/img/noPhoto.png';
            }
            if ($ar_fields['PROPERTY_FROM_ID_VALUE'] == $USER->GetID()) {
                $from = 1;
            } else {
                $from = 2;
            }
            if($ar_fields['PROPERTY_FROM_ID_VALUE'] == $USER->GetID() || $ar_fields['PROPERTY_TO_ID_VALUE'] == $USER->GetID()) {
                array_push($message, Array(
                    'id' => $ar_fields['ID'],
                    'from' => $ar_fields['PROPERTY_FROM_ID_VALUE'],
                    'to' => $ar_fields['PROPERTY_TO_ID_VALUE'],
                    'text' => $ar_fields['PROPERTY_TEXT_VALUE'],
                    'avatar' => 'https://' . SITE_SERVER_NAME . $URL,
                    'avatarTo' => 'https://' . SITE_SERVER_NAME . $URLTo,
                    'date' => $date,
                    'avtor' => $from,
                    'name' => $users[$ar_fields['PROPERTY_FROM_ID_VALUE']]['NAME'],
                    'nameTo' => $users[$ar_fields['PROPERTY_TO_ID_VALUE']]['NAME'],
                    'online' => $users[$ar_fields['PROPERTY_FROM_ID_VALUE']]['ONLINE']


                ));
            }
        }
    }
endif;
echo json_encode($message);
?>