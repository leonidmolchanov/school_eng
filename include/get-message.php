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
        Array("IBLOCK_CODE" => 'STUDENTS'),
        false,
        false,
        Array('ID', 'PROPERTY_NAME','PROPERTY_LAST_NAME', 'PROPERTY_USERID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $users[$ar_fields['PROPERTY_USERID_VALUE']] = $ar_fields['PROPERTY_NAME_VALUE'].' '.$ar_fields['PROPERTY_LAST_NAME_VALUE'];
    }
endif;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "desc"),
        Array("IBLOCK_CODE" => 'CHAT'),
        false,
        false,
        Array('ID', 'PROPERTY_TEXT','PROPERTY_FROM_ID','PROPERTY_TO_ID', 'DATE_CREATE')
    );

    while($ar_fields = $my_elements->GetNext()) {
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
                'date' => date("d M Y H:i", strtotime($ar_fields['DATE_CREATE'])),
                'avtor' => $from,
                'name' => $users[$ar_fields['PROPERTY_FROM_ID_VALUE']]
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
                'date' => date("d M Y H:i", strtotime($ar_fields['DATE_CREATE'])),
                'avtor' => $from,
                'name' => $users[$ar_fields['PROPERTY_TO_ID_VALUE']]
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
                'date' => date("d M Y H:i", strtotime($ar_fields['DATE_CREATE'])),
                'avtor' => $from,
                'name' => $users[$ar_fields['PROPERTY_FROM_ID_VALUE']]
            ));
        }
    }
endif;
echo json_encode($message);
?>