
<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 10/12/2018
 * Time: 16:47
 */
//if(CIBlock::GetPermission($_REQUEST["idRoom"])>='W')
//{
    $DB->StartTransaction();
    if(!CIBlockElement::Delete($_REQUEST["idRoom"]))
    {
        $request='error';
        $strWarning .= 'Error!';
        $DB->Rollback();
    }
    else
        $DB->Commit();
    $request='Success';
//}
echo json_encode($request);
?>