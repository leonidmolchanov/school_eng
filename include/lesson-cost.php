<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/02/2019
 * Time: 01:31
 */
$lessoncost=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'TICKETS',
//            'PROPERTY_SCHOOL_ID'=>$schoolID
        ),
        false,
        false,
        Array()
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($lessoncost, $ar_fields);
    }
endif;