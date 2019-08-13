<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/12/2018
 * Time: 19:41
 */
$teacher=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'TEACHER',
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'NAME', 'DETAIL_PAGE_URL','PROPERTY_USER')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($teacher, $ar_fields);
    }
endif;
    ?>