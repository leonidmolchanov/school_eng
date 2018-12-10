<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 04/12/2018
 * Time: 00:48
 */
if(CIBlock::GetPermission($_REQUEST["idGroup"])>='W')
{
    $DB->StartTransaction();
    if(!CIBlockElement::Delete($_REQUEST["idGroup"]))
    {
        $request='error';
        $strWarning .= 'Error!';
        $DB->Rollback();
    }
    else
        $DB->Commit();
    $request='Success';
}
echo json_encode($request);
?>