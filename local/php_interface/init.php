<?
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 23/12/2018
 * Time: 01:04
 */
function journalDemon()
{
    require("create-journal.php");
    return "journalDemon();";

}
function lessonDemon(){
    require("create-lesson.php");

return "lessonDemon();";
}
function adjustmentDemon(){
    require("create-adjustment.php");

    return "adjustmentDemon();";
}
function costDemon(){
    require("create-cost.php");

    return "costDemon();";
}
require("pay-modify.php");

function lessonProc($id, $val, $type){
    require("lesson-proc.php");
}
?>