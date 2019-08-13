<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 15/07/2019
 * Time: 23:18
 */

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();
$schoolID =  $arUser['UF_SCHOOL_ID'];

?>