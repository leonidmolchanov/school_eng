<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
use Bitrix\Main\Grid\Declension;
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();
global $schoolID;
$schoolID =  $arUser['UF_SCHOOL_ID'];
// Определение групп пользователей
$isAdmin=1;
$isMethodist=9;
$isTeacher=8;
$isStudent=7;
$isFranch=17;
$isAdministrator=18;

$isAdminPortal = 16;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
global $USER;
$privilege=0;
$arGroups = $USER->GetUserGroupArray();
foreach ($arGroups as $state){
    if($state==$isAdmin || $state==$isAdminPortal){
        $privilege=1;
    }
    else if($state==$isMethodist){
        $privilege=2;
    }
    else if($state==$isTeacher){
        $privilege=3;
    }
    else if($state==$isStudent){
        $privilege=4;
    }
    else if($state==$isFranch){
        $privilege=5;
    }
    else if($state==$isAdministrator){
        $privilege=6;
    }
}
    ?>
    <!-- Profile -->
    <h3 class="page-header page-header-top"><i class="fa fa-user"></i> <?=$arResult["arUser"]["NAME"]?> <?=$arResult["arUser"]["SECOND_NAME"]?> <?=$arResult["arUser"]["LAST_NAME"]?>  <small><?=$arResult["arUser"]["LOGIN"]?></small></h3>
<?if($privilege===1 || $privilege==5){?>

    <?

$franchuUserArr=[];
    $filter = Array
    (
        "GROUPS_ID"           => Array(17)
    );
    $rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter);
    while ($arUser = $rsUsers->Fetch()) {
        array_push($franchuUserArr, Array('ID'=>$arUser['ID'],'NAME'=>$arUser['NAME'],'LAST_NAME'=>$arUser['LAST_NAME']));
    }
if($privilege==5) {
    $filter = Array("IBLOCK_CODE" => 'SCHOOL',
        'ID' => $schoolID);
}
else{
    $filter = Array("IBLOCK_CODE" => 'SCHOOL');
}
    $schoolArr=[];
    $schoolArrCount = 0;
    $schoolArrFCount=0;
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            $filter,
            false,
            false,
            Array('ID','NAME',
                'PROPERTY_ADDRESS',
                'PROPERTY_PHONE',
                'PROPERTY_EMAIL',
                'PROPERTY_MASTER_FIO',
                'PROPERTY_MASTER_PHONE',
                'PROPERTY_MASTER_EMAIL',
                'PROPERTY_MASTER_ID',
                'PROPERTY_BLOCK')
        );

        while($ar_fields = $my_elements->GetNext())
        {
          array_push($schoolArr, $ar_fields);
          if($ar_fields['PROPERTY_MASTER_ID_VALUE']=='false'){
              $schoolArrCount++;
          }
          else{
              $schoolArrFCount++;
          }
        }
    endif;


    $yearDeclension = new Declension('Филиал', 'Филиала', 'Филиалов');
    ?>
<? if($privilege==1):?>
<div class="row">

    <div class="text-left" style="margin-left: 20px;">
        <h4>
        <? echo $schoolArrCount. ' ';?>
<?=$yearDeclension->get($schoolArrCount);?>
        </h4>
    </div>
    <div class="row">
        <div class="text-right" style="margin-right: 50px;">
            <button class="btn btn-default"
                    id="taggleButton"
                    data-placement="top"><i id='arrowIcon' class="fa fa-arrow-down"></i>
            </button>
            <?if($privilege!==5):?>
                <a class="btn btn-success" onclick="showCreateSchoolPopup()" id="addSchool"><i class="gemicon-small-plus gemicon-small-white"></i></a>

            <?endif;?>

        </div>
    </div>
    <div id="tableMini">

    <?
    foreach ($schoolArr as $item):
        if($item['PROPERTY_MASTER_ID_VALUE']=='false'):

        ?>
    <div class="col-md-4" style="margin-bottom: 20px;">

        <table id="tableMini" class="table table-striped table-bordered table-hover dataTable no-footer">
            <thead>
            </thead>
            <tbody>
            <tr role="row" class="odd">
                <td>
                    <div class="row">

                        <div class="col-md-4">
                            <a class="btn btn-primary"  onclick="changeSchoolConfrim(<?=$item['ID']?>)" id="addSchool"><i class="gemicon-small-key gemicon-small-white"></i></a>
                        </div>
                        <div class="col-md-8">
                            <strong>Наименование школы: </strong>
                        </div>
                    </div>

                </td>
                <td>
                    <input type="text" value="<?=$item['NAME']?>" id="schoolName" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled="">

                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <?
    endif;
    endforeach;
    ?>
    </div>
    <div id="tableMax" style="display: none;">
    <?
    foreach ($schoolArr as $item):
    if($item['PROPERTY_MASTER_ID_VALUE']=='false'):
    ?>
    <div class="col-md-4"  style="margin-bottom: 20px;">

        <table  class="table table-striped table-bordered table-hover dataTable no-footer">
            <thead>
            </thead>
            <tbody>
            <tr role="row" class="odd">
                <td>
                    <div class="row">

                    <div class="col-md-2">
                    <a class="btn btn-primary"  onclick="changeSchoolConfrim(<?=$item['ID']?>)" id="addSchool"><i class="gemicon-small-key gemicon-small-white"></i></a>
                    </div>
                        <div class="col-md-2">
                            <a class="btn btn-warning"  onclick="editSchool(this.parentNode.parentNode.parentNode.parentNode.parentNode)" id="addSchool"><i class="gemicon-small-pen gemicon-small-white"></i></a>
                        </div>
                    <div class="col-md-8">
                    <strong>Наименование школы: </strong>
                    </div>
                    </div>

                </td>
                <td>
                    <input type="text" value="<?=$item['NAME']?>" name="schoolName"  class="form-control ui-wizard-content" disabled="">

                </td>
            </tr>
            <tr role="row" class="odd">
                <td class="visib">
                    <strong>Адрес школы:</strong>
                </td>
                <td class="visib">
                    <input type="text" value="<?=$item['PROPERTY_ADDRESS_VALUE']?>" name="schoolAddress"  class="form-control ui-wizard-content" disabled="">


                </td>
            </tr>
            <tr role="row" class="odd">
                <td class="visib">
                    <strong>Телефон школы:</strong>
                </td>
                <td class="visib">
                    <input type="text" value="<?=$item['PROPERTY_PHONE_VALUE']?>" name="schoolPhone"  class="form-control ui-wizard-content" disabled="">


                </td>
            </tr>
            <tr role="row" class="odd">
                <td class="visib">
                    <strong>E-mail школы:</strong>
                </td>
                <td class="visib">
                    <input type="text" value="<?=$item['PROPERTY_EMAIL_VALUE']?>" name="schoolEmail"  class="form-control ui-wizard-content" disabled="">


                </td>
            </tr>
            <tr role="row" class="odd">
                <td colspan="2" class="visib">
                    <strong>Контактные данные владельца школы:</strong>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td class="visib">
                    <strong>ФИО владельца школы:</strong>
                </td>
                <td class="visib">
                    <input type="text" value="<?=$item['PROPERTY_MASTER_FIO_VALUE']?>" name="schoolFioPerson"  class="form-control ui-wizard-content" disabled="">


                </td>
            </tr>
            <tr role="row" class="odd">
                <td class="visib">
                    <strong>Телефон владельца школы:</strong>
                </td>
                <td class="visib">
                    <input type="text" value="<?=$item['PROPERTY_MASTER_PHONE_VALUE']?>" name="schoolPhonePerson"  class="form-control ui-wizard-content" disabled="">


                </td>
            </tr>
            <tr role="row" class="odd">
                <td class="visib">
                    <strong>E-mail владельца школы:</strong>
                </td>
                <td class="visib">
                    <input type="text" value="<?=$item['PROPERTY_MASTER_EMAIL_VALUE']?>" name="schoolEmailPerson"  class="form-control ui-wizard-content" disabled="">


                </td>
            </tr>
        <?if($privilege!==5):?>

        <tr role="row" class="odd">
            <td class="visib">
                <div class="text-right">
                    <button class="btn btn-danger" onClick="deleteSchoolConfrim(<?=$item['ID']?>)">Удалить</button>

                    <?if($item['PROPERTY_BLOCK_VALUE']==1):?>
                        <button class="btn btn-success" onClick="blockSchool(<?=$item['ID']?>, false)">Разблокировать</button>

                    <?else:?>
                        <button class="btn btn-warning" onClick="blockSchool(<?=$item['ID']?>, true)">Заблокировать</button>

                    <?endif;?>
                </div>
            </td>
            <td class="visib">
                <div class="text-right">
                    <button class="btn btn-success editButton"  disabled onClick="editSchoolProc(<?=$item['ID']?>, this.parentNode.parentNode.parentNode.parentNode)">Редактировать</button>

                </div>
            </td>
        </tr>
        <?endif;?>
            </tbody>
        </table>

    </div>
    <?
    endif;
    endforeach;
        ?>

</div>
</div>
    <?endif;?>
        <div class="row">

        <div class="text-center">
            <h3>
            Франчайзинговая сеть
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="row">
            <div class="text-right" style="margin-right: 50px;">
                <button class="btn btn-default"
                        id="taggleButton2"
                        data-placement="top"><i id='arrowIcon2' class="fa fa-arrow-down"></i>
                </button>

            </div>
        </div>
        <div class="text-left" style="margin-left: 20px;">
            <h4>
                <? echo $schoolArrFCount. ' ';?>
                <?=$yearDeclension->get($schoolArrFCount);?>
            </h4>
        </div>
    </div>
    <div class="row">

    <div id="tableMini2">

        <?
        foreach ($schoolArr as $item):
        if($item['PROPERTY_MASTER_ID_VALUE']!='false'):

        ?>
            <div class="col-md-4" style="margin-bottom: 20px;">

                <table  class="table table-striped table-bordered table-hover dataTable no-footer">
                    <thead>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td>
                            <div class="row">

                                <div class="col-md-4">
                                    <a class="btn btn-primary"  onclick="changeSchoolConfrim(<?=$item['ID']?>)" id="addSchool"><i class="gemicon-small-key gemicon-small-white"></i></a>
                                </div>
                                <div class="col-md-8">
                                    <strong>Наименование школы: </strong>
                                </div>
                            </div>

                        </td>
                        <td>
                            <input type="text" value="<?=$item['NAME']?>" id="schoolName" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled="">

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        <?
        endif;
        endforeach;
        ?>
    </div>
    </div>
<div class="row">

<div id="tableMax2" style="display: none;">
            <?
            foreach ($schoolArr as $item):
            if($item['PROPERTY_MASTER_ID_VALUE']!='false'):
            ?>
            <div class="col-md-4"  style="margin-bottom: 20px;">

                <table  class="table table-striped table-bordered table-hover dataTable no-footer">
                    <thead>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td>
                            <div class="row">

                                <div class="col-md-2">
                                    <a class="btn btn-primary"  onclick="changeSchoolConfrim(<?=$item['ID']?>)" id="addSchool"><i class="gemicon-small-key gemicon-small-white"></i></a>
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-warning"  onclick="editSchool(this.parentNode.parentNode.parentNode.parentNode.parentNode)" id="addSchool"><i class="gemicon-small-pen gemicon-small-white"></i></a>
                                </div>
                                <div class="col-md-8">
                                    <strong>Наименование школы: </strong>
                                </div>
                            </div>

                        </td>
                        <td>
                            <input type="text" value="<?=$item['NAME']?>" name="schoolName"  class="form-control ui-wizard-content" disabled="">

                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="visib">
                            <strong>Адрес школы:</strong>
                        </td>
                        <td class="visib">
                            <input type="text" value="<?=$item['PROPERTY_ADDRESS_VALUE']?>" name="schoolAddress"  class="form-control ui-wizard-content" disabled="">


                        </td>
            </tr>
            <tr role="row" class="odd">
                <td class="visib">
                    <strong>Телефон школы:</strong>
                </td>
                <td class="visib">
                    <input type="text" value="<?=$item['PROPERTY_PHONE_VALUE']?>" name="schoolPhone"  class="form-control ui-wizard-content" disabled="">


                </td>
            </tr>
            <tr role="row" class="odd">
                <td class="visib">
                    <strong>E-mail школы:</strong>
                </td>
                <td class="visib">
                    <input type="text" value="<?=$item['PROPERTY_EMAIL_VALUE']?>" name="schoolEmail"  class="form-control ui-wizard-content" disabled="">


                </td>
            </tr>
            <tr role="row" class="odd">
                <td colspan="2" class="visib">
                    <strong>Контактные данные владельца школы:</strong>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td class="visib">
                    <strong>ФИО владельца школы:</strong>
                </td>
                <td class="visib">
                    <input type="text" value="<?=$item['PROPERTY_MASTER_FIO_VALUE']?>" name="schoolFioPerson"  class="form-control ui-wizard-content" disabled="">


                </td>
            </tr>
            <tr role="row" class="odd">
                <td class="visib">
                    <strong>Телефон владельца школы:</strong>
                </td>
                <td class="visib">
                    <input type="text" value="<?=$item['PROPERTY_MASTER_PHONE_VALUE']?>" name="schoolPhonePerson"  class="form-control ui-wizard-content" disabled="">


                </td>
            </tr>
            <tr role="row" class="odd">
                <td class="visib">
                    <strong>E-mail владельца школы:</strong>
                </td>
                <td class="visib">
                    <input type="text" value="<?=$item['PROPERTY_MASTER_EMAIL_VALUE']?>" name="schoolEmailPerson"  class="form-control ui-wizard-content" disabled="">


                </td>
            </tr>
            <?if($privilege!==5):?>

                <tr role="row" class="odd">
                    <td class="visib">
                        <div class="text-right">
                            <button class="btn btn-danger" onClick="deleteSchoolConfrim(<?=$item['ID']?>)">Удалить</button>

                            <?if($item['PROPERTY_BLOCK_VALUE']==1):?>
                                <button class="btn btn-success" onClick="blockSchool(<?=$item['ID']?>, false)">Разблокировать</button>

                            <?else:?>
                                <button class="btn btn-warning" onClick="blockSchool(<?=$item['ID']?>, true)">Заблокировать</button>

                            <?endif;?>
                        </div>
                    </td>
                    <td class="visib">
                        <div class="text-right">
                            <button class="btn btn-success editButton"  disabled onClick="editSchoolProc(<?=$item['ID']?>, this.parentNode.parentNode.parentNode.parentNode)">Редактировать</button>

                        </div>
                    </td>
                </tr>
            <?endif;?>
            </tbody>
            </table>

        </div>
    <?
    endif;
    endforeach;
    ?>

    </div>
</div>


    <div id="addSchool-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;">

        <div class="modal-backdrop  in" style="height: 833px;"></div>
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onClick="hideCreateSchoolPopup()" data-dismiss="modal">×</button>
                    <h4>Создание школы</h4>
                </div>
                <div class="modal-body">



                    <table class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                        </thead>
                        <tbody>
                        <tr role="row" class="odd">
                            <td colspan="2">
                                <input type="text" placeholder="Введите название школы" value="" id="schoolNameAdd" name="example-advanced-firstname" class="form-control ui-wizard-content">

                            </td>
                        </tr>
                        <tr role="row" class="odd">
                            <td colspan="2">
                                <input type="text" placeholder="Введите адрес школы" value="" id="schoolAddressAdd" name="example-advanced-firstname" class="form-control ui-wizard-content">

                            </td>
                        </tr>
                        <tr role="row" class="odd">
                            <td colspan="2">
                                <input type="text" placeholder="Введите телефон школы" value="" id="schoolPhoneAdd" name="example-advanced-firstname" class="form-control ui-wizard-content">

                            </td>
                        </tr>
                        <tr role="row" class="odd">
                            <td colspan="2">
                                <input type="text" placeholder="Введите e-mail школы" value="" id="schoolEmailAdd" name="example-advanced-firstname" class="form-control ui-wizard-content">

                            </td>
                        </tr>

                        <tr role="row" class="odd">
                            <td colspan="2">
                                <input type="text" placeholder="Введите ФИО владельца школы" value="" id="schoolFioPersonAdd" name="example-advanced-firstname" class="form-control ui-wizard-content">

                            </td>
                        </tr>
                        <tr role="row" class="odd">

                            <td>
                                <input type="text" placeholder="E-mail владельца школы" value="" id="schoolEmailPersonAdd" name="example-advanced-firstname" class="form-control ui-wizard-content">

                            </td>
                            <td>
                                <input type="text" placeholder="Номер телефона владельца школы" value="" id="schoolPhonePersonAdd" name="example-advanced-firstname" class="form-control ui-wizard-content">

                            </td>
                        </tr>
                        <tr role="row" class="odd">

                            <td>
                                <div class="checkbox">
                                    <label for="example-checkbox1">
                                        <input class="discount_checkbox" type="radio" checked id="schoolFilialType1" data-id="10" name="choolFilialType" value="option1"> Собственный филиал                            </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label for="example-checkbox1">
                                        <input class="discount_checkbox" id="schoolFilialType2" type="radio" data-id="10" name="choolFilialType" value="option1"> Франчайзинговый филиал                            </label>
                                </div>
                            </td>
                        </tr>


                        <tr role="row" class="odd" >
                            <td colspan="2">
                                <div class="form-group" id="selectFranch" style="display: none;">
                                    <label class="control-label col-md-6" for="val_credit_card">Выберите пользователя:</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div><label>
                                                    <select name="example-datatables2_length" id="franchUserSelect" class="form-control">
                                                        <?foreach ($franchuUserArr as $user):?>
                                                        <option data-id="<?=$user['ID']?>" value="Y"><?=$user['NAME']?> <?=$user['LAST_NAME']?></option>
                                                        <?endforeach;?>
                                                    </select></label></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onClick="addSchoolProcess()">Создать</button>

                    <button class="btn btn-danger" onClick="hideCreateSchoolPopup()">Закрыть</button>
                </div>
            </div>
        </div>
        <!-- END Modal Content -->
    </div>


    <script>
        taggleButton = document.querySelector('#taggleButton')
        taggleButton2 = document.querySelector('#taggleButton2')

        hideCreateSchoolPopupModal= document.querySelector('#addSchool-modal')
        schoolFilialType2= document.querySelector('#schoolFilialType2')
        schoolFilialType1= document.querySelector('#schoolFilialType1')
        selectFranch = document.querySelector('#selectFranch')
        franchUserSelect = document.querySelector('#franchUserSelect')
        schoolFilialType2.addEventListener('click', ()=>{
            selectFranch.style.display = 'block'
        })
        schoolFilialType1.addEventListener('click', ()=>{
            selectFranch.style.display = 'none'
        })

        taggleButton.addEventListener('click', ()=>{

            arrowIcon = document.querySelector('#arrowIcon')

            console.log('taggle')
           tbMax =  document.querySelector('#tableMax')
            if(tbMax.style.display=='none'){
                arrowIcon.classList.remove("fa-arrow-down");
                arrowIcon.classList.add("fa-arrow-up");
            tbMax.style.display = 'block'}
            else{
                arrowIcon.classList.remove("fa-arrow-up");
                arrowIcon.classList.add("fa-arrow-down");
                tbMax.style.display = 'none'
            }
            tbMini =  document.querySelector('#tableMini')
            if(tbMini.style.display=='none'){
                tbMini.style.display = 'block'}
            else{
                tbMini.style.display = 'none'
            }
        })
        taggleButton2.addEventListener('click', ()=>{

            arrowIcon = document.querySelector('#arrowIcon2')

            console.log('taggle')
            tbMax =  document.querySelector('#tableMax2')
            if(tbMax.style.display=='none'){
                arrowIcon.classList.remove("fa-arrow-down");
                arrowIcon.classList.add("fa-arrow-up");
                tbMax.style.display = 'block'}
            else{
                arrowIcon.classList.remove("fa-arrow-up");
                arrowIcon.classList.add("fa-arrow-down");
                tbMax.style.display = 'none'
            }
            tbMini =  document.querySelector('#tableMini2')
            if(tbMini.style.display=='none'){
                tbMini.style.display = 'block'}
            else{
                tbMini.style.display = 'none'
            }
        })
        hideCreateSchoolPopup = ()=>{
            hideCreateSchoolPopupModal.style.display = 'none'

        }

        showCreateSchoolPopup = ()=>{
            hideCreateSchoolPopupModal.style.display = 'block'

        }

        editSchool = (table)=>{
            console.log(table)
            inps = table.querySelectorAll('input')
butn = table.querySelector('.editButton')
            butn.disabled= false
            inps.forEach((el)=>{
                console.log(el)
                el.disabled=false
            })
        }

        editSchoolProc = (id, table)=>{
            name = table.querySelector('input[name="schoolName"]').value
            address = table.querySelector('input[name="schoolAddress"]').value
            phone = table.querySelector('input[name="schoolPhone"]').value
            email = table.querySelector('input[name="schoolEmail"]').value
            fioPerson = table.querySelector('input[name="schoolFioPerson"]').value
            phonePerson = table.querySelector('input[name="schoolPhonePerson"]').value
            emailPerson = table.querySelector('input[name="schoolEmailPerson"]').value
if(name &&
address &&
phone &&
email &&
fioPerson &&
phonePerson &&
emailPerson){

    BX.ajax({
        url: '/api.php',
        data: {
            sessid: BX.bitrix_sessid(),
            type: 'editSchool',
            id: id,
            name: name,
            phone: phone,
            address: address,
            email: email,
            fioperson: fioPerson,
            phoneperson: phonePerson,
            emailperson: emailPerson

        },
        method: 'POST',
        dataType: 'json',
        timeout: 30,
        async: true,
        processData: true,
        scriptsRunFirst: true,
        emulateOnload: true,
        start: true,
        cache: false,
        onsuccess: function (data) {
            console.log(data)
            if(data=='Success'){
                Swal(
                    'Готово!',
                    'Школа изменена',
                    'success'
                )
                window.location.reload();
            }
            else{
                console.log("error");
            }
        },
        onfailure: function () {
            console.log("error");

        }
    });
}
else{
    Swal(
        'Не заполнены данные!',
        '',
        'warning'
    )
}

            console.log(name)
        }
        deleteSchool=(id)=>{
            BX.ajax({
                url: '/api.php',
                data: {
                    sessid: BX.bitrix_sessid(),
                    type: 'deleteSchool',
                    id: id

                },
                method: 'POST',
                dataType: 'json',
                timeout: 30,
                async: true,
                processData: true,
                scriptsRunFirst: true,
                emulateOnload: true,
                start: true,
                cache: false,
                onsuccess: function (data) {
                    console.log(data)
                    if(data=='Success'){
                        Swal(
                            'Готово!',
                            'Школа удалена',
                            'success'
                        )
                        window.location.reload();
                    }
                    else{
                        console.log("error");
                    }
                },
                onfailure: function () {
                    console.log("error");

                }
            });
        }
        blockSchool=(id, add)=>{
            BX.ajax({
                url: '/api.php',
                data: {
                    sessid: BX.bitrix_sessid(),
                    type: 'blockSchool',
                    id: id,
                    add: add

                },
                method: 'POST',
                dataType: 'json',
                timeout: 30,
                async: true,
                processData: true,
                scriptsRunFirst: true,
                emulateOnload: true,
                start: true,
                cache: false,
                onsuccess: function (data) {
                    console.log(data)
                    if(data=='Success'){
                        Swal(
                            'Готово!',
                            '',
                            'success'
                        )
                        window.location.reload();
                    }
                    else{
                        console.log("error");
                    }

                },
                onfailure: function () {
                    console.log("error");

                }
            });
        }
        changeSchool=(id)=>{

            BX.ajax({
                url: '/api.php',
                data: {
                    sessid: BX.bitrix_sessid(),
                    type: 'changeSchool',
                    id: id

                },
                method: 'POST',
                dataType: 'json',
                timeout: 30,
                async: true,
                processData: true,
                scriptsRunFirst: true,
                emulateOnload: true,
                start: true,
                cache: false,
                onsuccess: function (data) {
                    console.log(data)
                    if(data=='success'){
                        Swal(
                            'Готово!',
                            '',
                            'success'
                        )
                        window.location.href='/schedule.php';
                    }
                    else{
                        console.log("error");
                    }

                },
                onfailure: function () {
                    console.log("error");

                }
            });
        }

        addSchoolProcess=()=>{

            schoolNameAdd = document.querySelector('#schoolNameAdd')
            schoolAddressAdd = document.querySelector('#schoolAddressAdd')
            schoolPhoneAdd = document.querySelector('#schoolPhoneAdd')
            schoolEmailAdd = document.querySelector('#schoolEmailAdd')
            schoolFioPersonAdd = document.querySelector('#schoolFioPersonAdd')
            schoolEmailPersonAdd = document.querySelector('#schoolEmailPersonAdd')
            schoolPhonePersonAdd = document.querySelector('#schoolPhonePersonAdd')


            if(schoolNameAdd.value &&
                schoolAddressAdd.value &&
                schoolPhoneAdd.value &&
                schoolEmailAdd.value &&
                schoolFioPersonAdd.value &&
                schoolEmailPersonAdd.value &&
                schoolPhonePersonAdd.value ){


                BX.ajax({
                    url: '/api.php',
                    data: {
                        sessid: BX.bitrix_sessid(),
                        type: 'createSchool',
                        franchid: schoolFilialType2.checked && franchUserSelect.options[franchUserSelect.options.selectedIndex].dataset.id ?
                            franchUserSelect.options[franchUserSelect.options.selectedIndex].dataset.id : false,
                        schoolname:schoolNameAdd.value,
                        schooladdress:schoolAddressAdd.value,
                        schoolphone:schoolPhoneAdd.value,
                        schoolemail:schoolEmailAdd.value,
                        schoolfioperson:schoolFioPersonAdd.value,
                        schoolemailperson:schoolEmailPersonAdd.value,
                        schoolphoneperson:schoolPhonePersonAdd.value

                    },
                    method: 'POST',
                    dataType: 'json',
                    timeout: 30,
                    async: true,
                    processData: true,
                    scriptsRunFirst: true,
                    emulateOnload: true,
                    start: true,
                    cache: false,
                    onsuccess: function (data) {
                        console.log(data)
                        if(data=='Success'){
                            Swal(
                                'Готово!',
                                'Школа создана',
                                'success'
                            )
                            window.location.reload();
                        }
                        else{
                            console.log("error");
                        }

                    },
                    onfailure: function () {
                        console.log("error");

                    }
                });





                console.log(schoolFilialType2.checked)
                console.log(franchUserSelect.options[franchUserSelect.options.selectedIndex].dataset.id);
            }

            else{

                alert("Не заполнены поля!")
            }




        }

        changeSchoolConfrim = (id)=>{
            console.log(id)
            Swal({
                title: 'Вы уверены?',
                text: "Вы точно хотите сменить школу?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5cb85c',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Отмена',
                confirmButtonText: 'Сменить'
            }).then((result) => {
                if (result.value) {
                    changeSchool(id)

                }
            })
        }

        deleteSchoolConfrim = (id)=>{
            console.log(id)
            Swal({
                title: 'Вы уверены?',
                text: "Вы точно хотите удалить школу?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5cb85c',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Отмена',
                confirmButtonText: 'Удалить'
            }).then((result) => {
                if (result.value) {
                    deleteSchool(id)

                }
            })
        }
    </script>


<? }
else if($privilege===2){?>
Вы методист
<?} else if($privilege===3){?>
Вы учитель
<?}
else if($privilege===6){?>
    Вы Администратор
<?}
else if($privilege===4){?>
    <div class="row">
        <!-- First Column | Image and menu -->
        <div class="col-md-3">
            <div class="text-center">
<? $arResult["arUser"]["PERSONAL_PHOTO_HTML"] = CFile::ShowImage($arResult["arUser"]["PERSONAL_PHOTO"], 200, 200, "border=0", "class='img-responsive'", true);?>
                            <?=$arResult["arUser"]["PERSONAL_PHOTO_HTML"];?>
            </div>
            <div class="list-group">
                <a href="javascript:void(0)" onclick="window.location.reload()" class="list-group-item">Главная</a>
                <a href="javascript:void(0)" onclick="historyPay()" class="list-group-item">История платежей</a>
                <a href="javascript:void(0)" onclick="historyVisit()" class="list-group-item">История посещений</a>
                <a href="javascript:void(0)" onclick="feedback()" class="list-group-item">Обратная связь</a>
                <a href="javascript:void(0)" onclick="changePassword()" class="list-group-item">Сменить пароль</a>
            </div>
            <div class="list-group">
                <a href="javascript:void(0)" class="list-group-item">Выход</a>
            </div>
<!--            <div class="dash-tile dash-tile-leaf clearfix animation-pullDown">-->
<!--                <div class="dash-tile-header">-->
<!--                                    <span class="dash-tile-options">-->
<!--                                    </span>-->
<!--                    Скидки                   </div>-->
<!--                -->
<!--            </div>-->
        </div>
        <!-- END First Column | Image and menu -->

        <!-- Second Column | Main content -->
        <div id="changePassword-content">
            <div class="col-md-6 push">
                <script type="text/javascript">
                    <!--
                    var opened_sections = [<?
                        $arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
                        $arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
                        if (strlen($arResult["opened"]) > 0)
                        {
                            echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
                        }
                        else
                        {
                            $arResult["opened"] = "reg";
                            echo "'reg'";
                        }
                        ?>];
                    //-->

                    var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
                </script>
                <form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
                    <?=$arResult["BX_SESSION_CHECK"]?>
                    <input type="hidden" name="lang" value="<?=LANG?>" />
                    <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
                <div class="form-group">
                    <div class="col-md-12">
                        <p class="form-control-static"><h3 class="page-header-top"><? echo $arResult["arUser"]["NAME"]?> <? echo $arResult["arUser"]["LAST_NAME"]?></h3></p>
                    </div>
                </div>
                    <div class="row">
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="password" name="NEW_PASSWORD" maxlength="50" placeholder="<?=GetMessage('NEW_PASSWORD_REQ')?>" value="" autocomplete="off" id="user-pass" class="form-control">
                    </div>
                </div>
                    </div>
                    <div class="row">
                    <div class="form-group">
                    <div class="col-md-6">
                        <input type="password" name="NEW_PASSWORD_CONFIRM" placeholder="<?=GetMessage('NEW_PASSWORD_CONFIRM')?>" maxlength="50" value="" autocomplete="off" id="user-newpass"
                               class="form-control">
                    </div>
                </div>
                    </div>
                    <div class="row">

                    <div class="form-group">
                    <div class="col-md-6">
                        <div class="modal-footer remove-margin">
                            <input type="submit" class="btn btn-success" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">
                        </div>
                    </div>
                </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="feedback-content">
            <div class="col-md-6 push">
                <div class="form-group">
                    <label class="control-label col-md-2" for="example-textarea-large">Письмо:</label>
                    <div class="col-md-10">
                        <textarea id="example-textarea-large" name="example-textarea-large" class="form-control" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-10 col-md-offset-2">
                        <button class="btn btn-success">Отправить</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="historyVisit-content">
            <div class="col-md-6 push">
                <div id="example-datatables2_wrapper" class="">
                    <table id="profile-visit"
                           class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
                           aria-describedby="example-datatables3_info">
                        <thead>
                        <tr role="row">
                            <th class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2"
                                rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="#: activate to sort column descending" style="width: 71px;">#
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                                aria-label=" Username: activate to sort column ascending" style="width: 252px;">Дата:
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                                aria-label=" Username: activate to sort column ascending" style="width: 252px;">Название:
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                                aria-label=" Status: activate to sort column ascending" style="width: 326px;">Статус:
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div id="historyPay-content">
            <div class="col-md-6 push">

                <div id="example-datatables2_wrapper" class="">
                    <table id="profile-transaction"
                           class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
                           aria-describedby="example-datatables3_info">
                        <thead>
                        <tr role="row">
                            <th class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2"
                                rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="#: activate to sort column descending" style="width: 71px;">#
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                                aria-label=" Username: activate to sort column ascending" style="width: 252px;">Дата:
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                                aria-label=" Status: activate to sort column ascending" style="width: 326px;">Описание:
                            </th>
                        </tr>
                        </thead>
                            <tbody>
                            <?
                            CModule::IncludeModule("sale");
$res = CSaleUserTransact::GetList(Array("ID" => "DESC"), array("USER_ID" => $USER->GetID()));
while ($arFields = $res->Fetch())
{?>
    <tr role="row" class="odd">
        <td class="text-center sorting_1"><?=$arFields["ID"]?></td>
        <td><?=$arFields["TRANSACT_DATE"]?></td>
        <td><span class="label <?=($arFields["DEBIT"]=="Y")?"label-success":"label-primary"?>"><?=($arFields["DEBIT"]=="Y")?"+":"-"?><?=SaleFormatCurrency($arFields["AMOUNT"], $arFields["CURRENCY"])?>(<?=($arFields["DEBIT"]=="Y")?"на счет":"со счета"?>)<br /><small>  <?=$arFields["NOTES"]?></small></span></td>
    </tr>
<?}?>
                           </tbody>
                    </table>

                </div>
            </div>
            </div>
        <div id="main-content">
        <div class="col-md-3 text-center">
            <div id="first-study">

            </div>
                    <!-- END Total Users Tile -->
<!--            <div class="dash-tile dash-tile-balloon clearfix animation-pullDown">-->
<!--                <div class="dash-tile-header">-->
<!--                    <div class="dash-tile-options">-->
<!--                    </div>-->
<!--                    Отработка-->
<!--                </div>-->
<!--                <div class="dash-tile-icon"></div>-->
<!--                <br>-->
<!--                <br>-->
<!--                <div class=""><span class="label label-primary">Kids Box 23</span> <p><h4 class="text-active">Четверг 23.12 13:00-13:45</h4></p></div>-->
<!--            </div>-->


            <?
            $studentid=0;
            $studentbalance=0;
            if (CModule::IncludeModule("iblock")):
                # show url my elements
                $my_elements = CIBlockElement::GetList (
                    Array("ID" => "ASC"),
                    Array("IBLOCK_CODE" => 'STUDENTS', "PROPERTY_USERID" => $USER->GetID()),
                    false,
                    false,
                    Array('ID', 'PROPERTY_LESSON_BALANCE')
                );

                while($ar_fields = $my_elements->GetNext())
                {
                    $studentid = $ar_fields['ID'];
                    $studentbalance = $ar_fields['PROPERTY_LESSON_BALANCE_VALUE'];
                }
            endif;
            $groupid=0;
            if (CModule::IncludeModule("iblock")):
                # show url my elements
                $my_elements = CIBlockElement::GetList (
                    Array("ID" => "ASC"),
                    Array("IBLOCK_CODE" => 'GROUP_STRUCTURE', "PROPERTY_STUDENT_ID" => $studentid),
                    false,
                    false,
                    Array('ID', 'PROPERTY_GROUP_ID')
                );

                while($ar_fields = $my_elements->GetNext())
                {
                    $groupid = $ar_fields['PROPERTY_GROUP_ID_VALUE'];
                }
            endif;
            $costid=0;
            if (CModule::IncludeModule("iblock")):
                # show url my elements
                $my_elements = CIBlockElement::GetList (
                    Array("ID" => "ASC"),
                    Array("IBLOCK_CODE" => 'GROUP', "ID" => $groupid),
                    false,
                    false,
                    Array('ID', 'PROPERTY_LESSON_COST')
                );

                while($ar_fields = $my_elements->GetNext())
                {
                    $costid = $ar_fields['PROPERTY_LESSON_COST_VALUE'];
                }
            endif;
            ?>

        </div>
            <div class="col-md-3 text-center">
                <!-- Total Profit Tile -->
                <div class="dash-tile dash-tile-leaf clearfix animation-pullDown">
                    <div class="dash-tile-header">
                                    <span class="dash-tile-options">
                                    </span>
                        Кол-во доступных занятий                    </div>
                    <h4 class="text-active"><?=$studentbalance?></h4>

                </div>
        </div>
        </div>
        <!-- END Second Column | Main content -->


        <div class="col-md-3 text-center">
            <h5 class="page-header-sub">Оплата:</h5>
<!--            <div class="input-group">-->
<!--                <input type="number" id="example-input-append-btn2" name="example-input-append-btn2" class="form-control" placeholder="Сумма">-->
<!--                <span class="input-group-btn">-->
<!--                                            <button class="btn btn-success">Пополнить</button>-->
<!--                                        </span>-->
<!--            </div>-->

            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.element",
                ".default",
                array(
                    "ACTION_VARIABLE" => "action",
                    "ADD_DETAIL_TO_SLIDER" => "N",
                    "ADD_ELEMENT_CHAIN" => "N",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "ADD_TO_BASKET_ACTION" => array(
                        0 => "BUY",
                    ),
                    "ADD_TO_BASKET_ACTION_PRIMARY" => array(
                        0 => "BUY",
                    ),
                    "BACKGROUND_IMAGE" => "-",
                    "BASKET_URL" => "/profile/basket.php",
                    "BRAND_USE" => "N",
                    "BROWSER_TITLE" => "-",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "N",
                    "CHECK_SECTION_ID_VARIABLE" => "N",
                    "COMPATIBLE_MODE" => "Y",
                    "CONVERT_CURRENCY" => "N",
                    "DETAIL_PICTURE_MODE" => array(
                        0 => "POPUP",
                        1 => "MAGNIFIER",
                    ),
                    "DETAIL_URL" => "",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                    "DISPLAY_COMPARE" => "N",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PREVIEW_TEXT_MODE" => "E",
                    "ELEMENT_CODE" => "lesson",
                    "ELEMENT_ID" => $costid,
                    "GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
                    "GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
                    "GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "4",
                    "GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
                    "GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
                    "GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
                    "GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",
                    "GIFTS_MESS_BTN_BUY" => "Выбрать",
                    "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
                    "GIFTS_SHOW_IMAGE" => "Y",
                    "GIFTS_SHOW_NAME" => "Y",
                    "GIFTS_SHOW_OLD_PRICE" => "Y",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "IBLOCK_ID" => "9",
                    "IBLOCK_TYPE" => "school",
                    "IMAGE_RESOLUTION" => "16by9",
                    "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
                    "LINK_IBLOCK_ID" => "",
                    "LINK_IBLOCK_TYPE" => "",
                    "LINK_PROPERTY_SID" => "",
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_COMMENTS_TAB" => "Комментарии",
                    "MESS_DESCRIPTION_TAB" => "Описание",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "MESS_PRICE_RANGES_TITLE" => "Цены",
                    "MESS_PROPERTIES_TAB" => "Характеристики",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_LIMIT" => "0",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array(
                        0 => "lesson",
                    ),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRICE_VAT_SHOW_VALUE" => "N",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
                    "PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "PRODUCT_SUBSCRIPTION" => "Y",
                    "SECTION_CODE" => "",
                    "SECTION_ID" => $_REQUEST["SECTION_ID"],
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_URL" => "",
                    "SEF_MODE" => "N",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_CANONICAL_URL" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "Y",
                    "SET_VIEWED_IN_COMPONENT" => "N",
                    "SHOW_404" => "N",
                    "SHOW_CLOSE_POPUP" => "N",
                    "SHOW_DEACTIVATED" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "Y",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "N",
                    "STRICT_SECTION_CHECK" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_COMMENTS" => "N",
                    "USE_ELEMENT_COUNTER" => "Y",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_GIFTS_DETAIL" => "Y",
                    "USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "Y",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "USE_RATIO_IN_RANGES" => "N",
                    "USE_VOTE_RATING" => "N",
                    "COMPONENT_TEMPLATE" => ".default",
                    "ADD_PICT_PROP" => "-",
                    "LABEL_PROP" => array(
                    ),
                    "DISCOUNT_PERCENT_POSITION" => "top-right"
                ),
                false
            );?>
            <h5 class="page-header-sub"><i class="fa fa-certificate"></i> Занятия</h5>
            <table class="table table-borderless" id="study-list-table">
                <tbody>
                </tbody>
            </table>
            <h5 class="page-header-sub"><i class="fa fa-certificate"></i> Отработки</h5>
            <table class="table table-borderless" id="adj-list-table">
                <tbody>
                </tbody>
            </table>
            <div class="text-center">
            <h4><i class="fa fa-book"></i>Контакты</h4>
            <address>
                <div id="father-contact"></div>
                <div id="mother-contact"></div>
                <div id="student-contact"></div>
            </address>
            </div>
            <h5 class="page-header-sub"><i class="fa fa-certificate"></i> Контакты школы</h5>
            <address>
                <div>
                    Контакты: СПб ул. Пулковская д. 2 корп 3 рядом с 9 роддомом
                </div>
                <div>
                    тел. +7(951)663552
                </div>
                <div>
                    e-mail: zvezdnaya@lingvitan.ru
                </div>
                <div>
                    <a href="https://vk.com/topic-97089486_34413234?offset=0"> оставить отзыв о нашей работе </a>
                </div>
            </address>
        </div>
        <!-- END Third Column | Right Sidebar -->
    </div>

    <!-- END Profile -->
<?}
else{?>
Ваш статус не определен
<?}?>
<script>


    function ajaxRequest() {

        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'getProfileInfo'
            },
            method: 'POST',
            dataType: 'json',
            timeout: 30,
            async: true,
            processData: true,
            scriptsRunFirst: true,
            emulateOnload: true,
            start: true,
            cache: false,
            onsuccess: function (data) {
                console.log(data)
                if(data.STUDENT){
                    fatherString="";
                    motherString="";
                    if(data.STUDENT['PROPERTY_FATHER__NAME_VALUE']){
                        fatherString+= data.STUDENT['PROPERTY_FATHER__NAME_VALUE']
                    }
                    if(data.STUDENT['PROPERTY_FATHER_NAME_VALUE']){
                        fatherString+=data.STUDENT['PROPERTY_FATHER_NAME_VALUE'];
                    }
                    if(data.STUDENT['PROPERTY_FATHER_SECOND_NAME_VALUE']){
                        fatherString+=data.STUDENT['PROPERTY_FATHER_SECOND_NAME_VALUE'];
                    }
                    if(data.STUDENT['PROPERTY_FATHER_TEL_VALUE']){
                        fatherString+=' <br>' + data.STUDENT['PROPERTY_FATHER_TEL_VALUE'] + '<br>'
                    }
                        $('#father-contact').append('Отец : ' + fatherString)
                    if(data.STUDENT['PROPERTY_MOTHER__NAME_VALUE']){
                        motherString+= data.STUDENT['PROPERTY_MOTHER__NAME_VALUE']
                    }
                    if(data.STUDENT['PROPERTY_MOTHER_NAME_VALUE']){
                        motherString+=data.STUDENT['PROPERTY_MOTHER_NAME_VALUE'];
                    }
                    if(data.STUDENT['PROPERTY_MOTHER_SECOND_NAME_VALUE']){
                        motherString+=data.STUDENT['PROPERTY_MOTHER_SECOND_NAME_VALUE'];
                    }
                    if(data.STUDENT['PROPERTY_MOTHER_TEL_VALUE']){
                        motherString+=' <br>' + data.STUDENT['PROPERTY_MOTHER_TEL_VALUE'] + '<br>'
                    }
                    $('#mother-contact').append('Мать : '+ motherString)
                    if(data.STUDENT['PROPERTY_TEL_VALUE']){
                        $('#student-contact').append('Личный номер : '+data.STUDENT['PROPERTY_TEL_VALUE'])
                    }

                }
                if(data.STUDY.length!==0){

                    data.STUDY.map(function (item) {
                        dateFrom=item['PROPERTY_FROM_VALUE'].split(' ');
                        dateTo=item['PROPERTY_TO_VALUE'].split(' ');
                        $('#study-list-table').append('<tr>\n' +
                            '                    <td class="cell-small"><span class="label" style="background:'+item['COLOR']+'">Kids Box 1</span></td>\n' +
                            '                    <td>\n' +
                            '                        '+item['DAY']+'('+dateFrom[0]+') '+dateFrom[1]+'-'+dateTo[1]+'\n' +
                            '                    </td>\n' +
                            '                </tr>')
                    })

                    dateFrom=data.STUDY[0]['PROPERTY_FROM_VALUE'].split(' ');
                    dateTo=data.STUDY[0]['PROPERTY_TO_VALUE'].split(' ');
                    $('#first-study').append('<div class="dash-tile dash-tile-ocean clearfix animation-pullDown">\n' +
                    '                <div class="dash-tile-header">\n' +
                    '                    <div class="dash-tile-options">\n' +
                    '                        <div class="btn-group">\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                    Ближайшее занятие\n' +
                    '                </div>\n' +
                    '                <div class="dash-tile-icon"></div>\n' +
                    '                <br>\n' +
                    '                <br>\n' +
                    '                <div class=""><span class="label" style="background:'+data.STUDY[0]['COLOR']+'">'+data.GROUP[0]['NAME']+'</span>\n' +
                    '                    <p><h4 class="text-active">'+data.STUDY[0]['DAY']+' '+dateFrom[0]+' '+dateFrom[1]+'-'+dateTo[1]+'</h4></p></div>\n' +
                        '                <p><h4 class="text-active">'+data.STUDY[0]['TEACHER']['PROPERTY_NAME_VALUE']+' '+data.STUDY[0]['TEACHER']['PROPERTY_LAST_NAME_VALUE']+'</h4></p></div>\n' +
                        '            </div>')
            }

                if(data.ADJUSTMENT.length!==0){

                    data.ADJUSTMENT.map(function (item) {
                        dateFrom=item.LESSON['PROPERTY_FROM_VALUE'].split(' ');
                        dateTo=item.LESSON['PROPERTY_TO_VALUE'].split(' ');
                        $('#adj-list-table').append('<tr>\n' +
                            '                    <td>\n' +
                            '                        '+item.LESSON['NAME']+' ('+dateFrom[0]+') '+dateFrom[1]+'-'+dateTo[1]+'\n' +
                            '                    </td>\n' +
                            '                </tr>')
                    })
                }

if(data.JOURNAL.BE.length!==0){
number=0;
    data.JOURNAL.BE.forEach(function (item) {
        date=item['DATE_CREATE'].split(' ')
        $('#profile-visit tbody').append(' <tr role="row" class="odd">\n' +
            '                            <td class="text-center sorting_1">'+number+'</td>\n' +
            '                            <td>'+date[0]+'</td>\n' +
            '                            <td><span class="label label-default">'+item['NAME']+'</span></td>\n' +
            '                            <td><span class="label label-success">Был</span></td>\n' +
            '                        </tr>')
    number++
    })
    data.JOURNAL.NOTBE.forEach(function (item) {
        date=item['DATE_CREATE'].split(' ')
        $('#profile-visit tbody').append(' <tr role="row" class="odd">\n' +
            '                            <td class="text-center sorting_1">'+number+'</td>\n' +
            '                            <td>'+date[0]+'</td>\n' +
            '                            <td><span class="label label-default">'+item['NAME']+'</span></td>\n' +
            '                            <td><span class="label label-danger">Не был</span></td>\n' +
            '                        </tr>')
        number++
    })
    data.JOURNAL.DISEASE.forEach(function (item) {
        date=item['DATE_CREATE'].split(' ')
        $('#profile-visit tbody').append(' <tr role="row" class="odd">\n' +
            '                            <td class="text-center sorting_1">'+number+'</td>\n' +
            '                            <td>'+date[0]+'</td>\n' +
            '                            <td><span class="label label-default">'+item['NAME']+'</span></td>\n' +
            '                            <td><span class="label label-warning">Болел</span></td>\n' +
            '                        </tr>')
        number++
    })
    $('#profile-visit').dataTable();

}
            }
        });

    }
    ajaxRequest();


    console.log('<?=$arResult["ID"]?>')
    function closeAllContent(){
        $('#feedback-content').hide();
        $('#historyVisit-content').hide();
        $('#historyPay-content').hide();
        $('#main-content').hide();
        $('#changePassword-content').hide();


    }
    $('#changePassword-content').hide();
    $('#feedback-content').hide();
    $('#historyVisit-content').hide();
    $('#historyPay-content').hide();
    function historyPay() {
        closeAllContent()
        $('#historyPay-content').show()
        $('#historyPay-content').show().ready(readyFn)

        function readyFn(){
            $(function () {
                /* Initialize Datatables */
                $('#profile-transaction').dataTable();
                $('.dataTables_filter input').attr('placeholder', 'Поиск');
            });
        }

}
function historyVisit() {
    closeAllContent()
    $('#historyVisit-content').show();
}
    function feedback() {
        closeAllContent()
        $('#feedback-content').show();
    }
    function changePassword() {
        closeAllContent()
        $('#changePassword-content').show();
    }





</script>
