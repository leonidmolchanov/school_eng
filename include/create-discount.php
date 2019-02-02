<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 01/02/2019
 * Time: 03:07
 */

//echo $_REQUEST['body'];
$array=json_decode($_REQUEST['body']);
$arGroups = CUser::GetUserGroup($array->id);
foreach ($array->group as $item){
    if($item->state){
$arGroups[] = $item->group;
    }
    else{
        unset($arGroups[array_search($item->group,$arGroups)]);
    }
}
CUser::SetUserGroup($array->id, $arGroups);

echo json_encode('success');
?>

<?//
//// привязка пользователя с кодом 10 дополнительно к группе c кодом 5
//$arGroups = CUser::GetUserGroup(10);
//$arGroups[] = 5;
//CUser::SetUserGroup(10, $arGroups);
//?>
