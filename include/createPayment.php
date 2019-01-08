
<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 08/01/2019
 * Time: 15:20
 */
global $USER;
CModule::IncludeModule('Sale');

    $sum=0;
    $desc="";
    if($_REQUEST['debit']=='Y'){
        $sum+=$_REQUEST['amount'];
        $desc = 'Зачисление средств через кассу';
    }
    else{
        $sum-=$_REQUEST['amount'];
        $desc = 'Списание средств через кассу';

    }
   $d =  CSaleUserAccount::UpdateAccount(
      $_REQUEST['userid'],
       $sum,
      "RUB",
       $desc,
       $desc
);
if($d){
    echo json_encode("success");
}
//}
?>