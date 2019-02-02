<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?

CModule::IncludeModule('Sale');
if(!CSaleUserAccount::GetByUserID($arResult["DISPLAY_PROPERTIES"]['USERID']['VALUE'], "RUB")){
    $arFields = Array("USER_ID" => $arResult["DISPLAY_PROPERTIES"]['USERID']['VALUE'], "CURRENCY" => "RUB", "CURRENT_BUDGET" => 0);
 CSaleUserAccount::Add($arFields);
echo "Для пользователя ".$arResult["DISPLAY_PROPERTIES"]['USERID']['VALUE']." создан рублевый счет";
}
$ar = CSaleUserAccount::GetByUserID($arResult["DISPLAY_PROPERTIES"]['USERID']['VALUE'], "RUB");



?>
<h3 class="page-header page-header-top"><i class="fa fa-user"></i><?=$arResult["DISPLAY_PROPERTIES"]['LAST_NAME']['VALUE']?> <?=$arResult["DISPLAY_PROPERTIES"]['NAME']['VALUE']?> <?=$arResult["DISPLAY_PROPERTIES"]['SECOND_NAME']['VALUE']?>
    <?if($arResult["DISPLAY_PROPERTIES"]['STATUS']['VALUE']==0):?>
    <small class="text-danger"> Заблокирован</small>
    <?elseif($arResult["DISPLAY_PROPERTIES"]['STATUS']['VALUE']==1):?>
        <small class="text-success">Активен</small>
        <?elseif($arResult["DISPLAY_PROPERTIES"]['STATUS']['VALUE']==2):?>
        <small class="text-warning">Болеет</small>
<?endif;?>
</h3>

<div class="row">
    <!-- First Column | Image and menu -->
    <div class="col-md-3">
<!--        <div class="text-center">-->
<!--            <img src="img/placeholders/image_light_900x700.png" class="img-responsive" alt="image">-->
<!--        </div>-->
        <div class="list-group">
            <a href="#" onclick="visitShow()" class="list-group-item"><i class="fa fa-coffee"></i>История посещений</a>
            <a href="#" onclick="paymentShow()" class="list-group-item"><i class="fa fa-paperclip"></i> История оплат</a>
        </div>

        <h5 class="page-header-sub">Скидки</h5>
        <?
        function GetGroup ()
        {
            $rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ());

            while($arGroups = $rsGroups->Fetch())
            {
                if(strpos($arGroups['STRING_ID'], 'discount') !== false) {
                    $arUsersGroups[] = $arGroups;
                }
            }
            return $arUsersGroups;
        }
        ?>
        <?

        function checkUser($userid,$id){
            $arUsers = CGroup::GetGroupUser($id);
            if(in_array($userid, $arUsers)){
                return true;
            }
            return false;
        }

        ?>
        <form id="form-validation"  method="post" class="form-horizontal form-box remove-margin" novalidate="novalidate">
            <!-- Form Content -->
            <div class="form-box-content">
                <?foreach (GetGroup() as $item):?>

                <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label for="example-checkbox1">
                                <input class="discount_checkbox" type="checkbox"
                                       <?if(checkUser($arResult["DISPLAY_PROPERTIES"]['USERID']['DISPLAY_VALUE'],$item['ID'])):?>
                                        checked
                                       <?endif;?>
                                       data-id="<?=$item['ID']?>" name="example-checkbox1" value="option1"> <?=$item['NAME']?>
                            </label>
                        </div>
                    </div>
                </div>
                <?endforeach;?>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input  onclick="discountProc()" class="btn btn-success ui-wizard-content ui-formwizard-button" id="cashe" value="Применить">
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Form Content -->
        </form>
    </div>
    <!-- END First Column | Image and menu -->

    <!-- Second Column | Main content -->
    <div class="col-md-6">
        <h4>Карточка студента
            <input type="submit" onclick="editCard()" class="btn btn-primary ui-wizard-content ui-formwizard-button" id="disease" value="Редактировать">
            <input type="submit" onclick="editStudent('false')" class="btn btn-success ui-wizard-content ui-formwizard-button" id="edit-student-button" value="Сохранить">

        </h4>

        <table  class="table table-striped table-bordered table-hover dataTable no-footer">
            <thead>
            </thead>
            <tbody>
            <tr role="row" class="odd">
                <td>
                    <strong>Номер договора</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['DOGOVOR']['VALUE']?>" id="dogovor" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>

                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Имя студента</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['NAME']['VALUE']?>" id="name" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>


                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Отчество студента</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['SECOND_NAME']['VALUE']?>" id="second-name" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>

                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong> Фамилия студента</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['LAST_NAME']['VALUE']?>" id="last-name" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Телефон студента</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['TEL']['VALUE']?>" id="tel" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Дата Рождения</strong>
                </td>
                <td>
                    <?$date = date('Y-m-d', date(strtotime($arResult["DISPLAY_PROPERTIES"]['BIRTHDAY']['VALUE'])));?>
                    <input type="date"  value="<?=$date?>" id="date" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Имя родителя (Мама)</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['MOTHER_NAME']['VALUE']?>" id="mother-name" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Отчество родителя (Мама)</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['MOTHER_SECOND_NAME']['VALUE']?>" id="mother-second-name" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Фамилия родителя (Мама)</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['MOTHER_LAST_NAME']['VALUE']?>" id="mother-last-name" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Телефон родителя (Мама)</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['MOTHER_TEL']['VALUE']?>" id="mother-tel" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Имя родителя (Папа)</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['FATHER_NAME']['VALUE']?>" id="father-name" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Отчество родителя (Папа)</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['FATHER_SECOND_NAME']['VALUE']?>" id="father-second-name" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Фамилия родителя (Папа)</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['FATHER_LAST_NAME']['VALUE']?>" id="father-last-name" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Телефон родителя (Папа)</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['FATHER_TEL']['VALUE']?>" id="father-tel" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Дата старта обучения</strong>
                </td>
                <td>
                    -
                </td>
            </tr>
            <tr role="row" class="odd">
                <td>
                    <strong>Комментарии</strong>
                </td>
                <td>
                    <input type="text"  value="<?=$arResult["DISPLAY_PROPERTIES"]['COMMENTS']['VALUE']?>" id="comments" name="example-advanced-firstname" class="form-control ui-wizard-content" disabled>
                    <input type="hidden"  value="<?=$arResult["DISPLAY_PROPERTIES"]['USERID']['VALUE']?>" id="userid" name="example-advanced-firstname" class="form-control ui-wizard-content">
                    <input type="hidden"  value="<?=$arResult['IBLOCK_ID']?>" id="iblockid" name="example-advanced-firstname" class="form-control ui-wizard-content">
                    <input type="hidden"  value="<?=$arResult['NAME']?>" id="elementname" name="example-advanced-firstname" class="form-control ui-wizard-content">
                    <input type="hidden"  value="<?=$arResult['ID']?>" id="elementid" name="example-advanced-firstname" class="form-control ui-wizard-content">
                    <input type="hidden"  value="<?=$arResult["DISPLAY_PROPERTIES"]['STATUS']['VALUE']?>" id="status" name="example-advanced-firstname" class="form-control ui-wizard-content">


                </td>
            </tr>
            </tbody>
        </table>


    </div>
    <!-- END Second Column | Main content -->

    <!-- Third Column | Right Sidebar -->
    <div class="col-md-3">
        <h5 class="page-header-sub">Действия</h5>
        <div class="btn-group push">
        </div>
        <div class="row">
        <?if($arResult["DISPLAY_PROPERTIES"]['STATUS']['VALUE']==2):?>
            <button class="btn btn-success" onclick="editStudent(1)" > Выздоровил</button>
         <?else:?>
            <button class="btn btn-warning" onclick="editStudent(2)" > Болеет</button>
        <?endif;?>

        <?if($arResult["DISPLAY_PROPERTIES"]['STATUS']['VALUE']==1):?>
            <button class="btn btn-danger" onclick="editStudent(0)" > Заблокировать</button>
         <?else:?>
            <button class="btn btn-primary" onclick="editStudent(1)" > Разблокировать</button>
         <?endif;?>

        </div>
        <h5 class="page-header-sub"><i class="fa fa-bolt"></i> Баланс</h5>
            <?if(round($ar["CURRENT_BUDGET"])>0):?>
        <div class="alert alert-success">
<?else:?>
            <div class="alert alert-danger">
<?endif;?>
        <?=SaleFormatCurrency($ar["CURRENT_BUDGET"], $ar["CURRENCY"])?>
        </div>



            <div class="form-group">
                <div class="col-md-3">
                </div>
                <div class="col-md-3">
                </div>
                <div class="col-md-3">
            </div>

        <h5 class="page-header-sub">Пополнение счета</h5>
            <form id="form-validation"  method="post" class="form-horizontal form-box remove-margin" novalidate="novalidate">
                <!-- Form Content -->
                <div class="form-box-content">
                    <div class="form-group">
                        <label class="control-label col-md-2" for="val_credit_card">Сумма:</label>

                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="number" min="0" value="0" id="amount" name="example-advanced-firstname" class="form-control ui-wizard-content">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2" for="val_credit_card">Уроки:</label>

                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="number" min="0" value="0" id="lessonBalance" name="example-advanced-firstname" class="form-control ui-wizard-content">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="val_credit_card">Комментарий:</label>

                        <div class="col-md-8">
                            <div class="input-group">

                            <textarea id="commentsPay" name="example-textarea" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2" for="val_credit_card">Режим:</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div><label>
                                        <select
                                                name="example-datatables2_length" id="debit"
                                                class="form-control">
                                            <option  selected value="Y">Пополнение</option>
                                            <option  value="N">Списание</option>
                                        </select></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input  onclick="createPayment()" class="btn btn-success ui-wizard-content ui-formwizard-button" id="cashe" value="Пополнить">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Form Content -->
            </form>
    </div>
    <!-- END Third Column | Right Sidebar -->


<?
$userGroup=[];
$userLesson=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP'),
        false,
        false,
        Array('ID', 'NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $userGroup[$ar_fields['ID']]=$ar_fields['NAME'];
    }
endif;
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'LESSON'),
        false,
        false,
        Array('ID', 'NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $userLesson[$ar_fields['ID']]=$ar_fields['NAME'];
    }
endif;
$userJournal=[];
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'JOURNAL'),
        false,
        false,
        Array()
    );

    while($ar_fields = $my_elements->GetNextElement()) {
        $fields = $ar_fields->GetFields();
        $props = $ar_fields->GetProperties();
        if (in_array($arResult['ID'], $props['NOTBE']['VALUE'])) {
           $arr=Array(
                   'TYPE'=>0,
                    'LESSON' => $fields['TIMESTAMP_X'],
               'GROUP' => $userGroup[$props['GROUPID']['VALUE']],
           );
            array_push($userJournal, $arr);
        }
    }
endif;
    ?>






<div id="visit-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;"><div class="modal-backdrop  in" style="height: 833px;"></div>
    <!-- Modal Dialog -->
    <div class="modal-dialog">
        <!-- Modal Content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onClick="visitShow()" data-dismiss="modal">×</button>
                <h4>Детальная информация</h4>
            </div>
            <div class="modal-body">

                <div id="vizit_div">
                    <table id="vizit-datatables" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example-datatables2_info">
                        <thead>
                        <tr role="row">
                            <th rowspan="1" colspan="1" class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 80px;">
                                #
                            </th>
                            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Username: activate to sort column ascending" style="width: 269px;">
                                Дата
                            </th>
                            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                                Группа            </th>
                            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                                Статус            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? $number=0;?>
                        <?foreach($userJournal as $arItem):?>
                            <!--        --><?// print_r($arItem["DISPLAY_PROPERTIES"]['NAME']['VALUE'] ) ;?>
                            <tr role="row" class="odd">
                                <td class="text-center sorting_1">
                                    <?=$number;?>
                                </td>
                                <td>
                                    <?=$arItem['LESSON']?>

                                </td>
                                <td>
                                    <?=$arItem['GROUP']?>

                                </td>
                                <td>
                                    <?if($arItem['TYPE']===0):?>
                                        Не был
                                    <?elseif($arItem['TYPE']===1):?>:
                                        Был
                                    <?elseif($arItem['TYPE']===2):?>:
                                        Болел
                                    <?endif;?>
                                </td>

                            </tr>
                            <?$number++;?>
                        <?endforeach;?>
                        </tbody>
                    </table>
                </div>

                <div id="payment_div">

                    <table id="payment-datatables" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example-datatables2_info">
                        <thead>
                        <tr role="row">
                            <th rowspan="1" colspan="1" class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 80px;">
                                #
                            </th>
                            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Username: activate to sort column ascending" style="width: 269px;">
                                Дата
                            </th>
                            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                                Сумма            </th>
                            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                                Описание            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? $number=0;?>
                        <?
                        $res = CSaleUserTransact::GetList(Array("ID" => "DESC"), array("USER_ID" => $arResult["DISPLAY_PROPERTIES"]['USERID']['VALUE']));
                        while ($arFields = $res->Fetch())
                        {

                            ?>
                            <tr role="row" class="odd">
                                <td class="text-center sorting_1">
                                    <?=$number;?>
                                </td>
                                <td>
                                    <?=$arFields["TRANSACT_DATE"]?>
                                </td>
                                <td>
                                    <?=($arFields["DEBIT"]=="Y")?"+":"-"?><?=SaleFormatCurrency($arFields["AMOUNT"], $arFields["CURRENCY"])?><br /><small>(<?=($arFields["DEBIT"]=="Y")?"на счет":"со счета"?>)</small>
                                </td>
                                <td>
                                    <?=$arFields["DESCRIPTION"]?>
                                </td>

                            </tr>
                            <?$number++;?>
                        <?};?>
                        </tbody>
                    </table>

                </div>

            <div class="modal-footer">
                <button class="btn btn-danger" onClick="visitShow()">Закрыть</button>
            </div>
        </div>
    </div>
    <!-- END Modal Content -->
</div>

</div>

        </div>
    </div>
<script>
    BX.ready(function() {
        $(function () {
            /* Initialize Datatables */
            $('#vizit-datatables').dataTable();
            $('#payment-datatables').dataTable();
            $('.dataTables_filter input').attr('placeholder', 'Поиск');
            $('select[name="vizit-datatables_length"]').hide();
            $('select[name="payment-datatables_length"]').hide();

        });
    });
</script>

<script>
    function visitShow() {
        if($('#visit-modal').css('display')!=='none'){
            $("#visit-modal").hide()
        }
        else{
            $("#visit-modal").show()
            $("#payment_div").hide()
            $("#vizit_div").show()
        }

    }
    function paymentShow() {
        if($('#visit-modal').css('display')!=='none'){
            $("#visit-modal").hide()
        }
        else{
            $("#visit-modal").show()
            $("#payment_div").show()
            $("#vizit_div").hide()

        }

    }
    function createPayment() {
                console.log('ok')

                BX.ajax({
                    url: '/api.php',
                    data: {
                        sessid: BX.bitrix_sessid(),
                        type: 'createPayment',
                        debit: $("#debit option:selected").val(),
                        amount: $("#amount").val(),
                        comments: $("#commentsPay").val(),
                        lessonBalance: $("#lessonBalance").val(),
                        userid: <?=$arResult["DISPLAY_PROPERTIES"]['USERID']['VALUE']?>

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
                        if(data=="success"){
                            Swal({
                                title: 'Готово!',
                                text: "Средства зачислены на счет!",
                                type: 'warning',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Завершить'
                            }).then((result) => {
                                window.location.reload();
                            })
                        }

                    },
                    onfailure: function () {
                        console.log("error");

                    }
                });

      
    }
function editCard() {
    $("#dogovor").prop('disabled', false);
    $("#name").prop('disabled', false);
    $("#last-name").prop('disabled', false);
    $("#second-name").prop('disabled', false);
    $("#tel").prop('disabled', false);
    $("#date").prop('disabled', false);
    $("#mother-name").prop('disabled', false);
    $("#mother-second-name").prop('disabled', false);
    $("#mother-last-name").prop('disabled', false);
    $("#mother-tel").prop('disabled', false);
    $("#father-name").prop('disabled', false);
    $("#father-last-name").prop('disabled', false);
    $("#father-tel").prop('disabled', false);
    $("#father-second-name").prop('disabled', false);
    $("#comments").prop('disabled', false);

}
    function editStudent(status) {
        console.log('ok')
        if(status=='false'){
            status=$("#status").val();
        }
console.log(status)
        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'editStudent',
                dogovor: $("#dogovor").val(),
                name: $("#name").val(),
                lastname: $("#last-name").val(),
                secondname: $("#second-name").val(),
                tel: $("#tel").val(),
                date: $("#date").val(),
                mothername: $("#mother-name").val(),
                mothersecondname: $("#mother-second-name").val(),
                motherlastname: $("#mother-last-name").val(),
                mothertel: $("#mother-tel").val(),
                fathername: $("#father-name").val(),
                fathersecondname: $("#father-second-name").val(),
                fatherlastname: $("#father-last-name").val(),
                fathertel: $("#father-tel").val(),
                userid: $("#userid").val(),
                iblockid: $("#iblockid").val(),
                elementname: $("#elementname").val(),
                comments: $("#comments").val(),
                elementid: $("#elementid").val(),
                status: status
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
                if(data=="success"){
                    Swal({
                        title: 'Готово!',
                        text: "Изменения сохранены!",
                        type: 'warning',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Завершить'
                    }).then((result) => {
                        window.location.reload();
                    })
                }

            },
            onfailure: function () {
                console.log("error");

            }
        });


    }

    function discountProc() {
        result={
            id: <?=$arResult["DISPLAY_PROPERTIES"]['USERID']['DISPLAY_VALUE'];?>,
            group: []
        }
       checkArr= document.querySelectorAll('.discount_checkbox');
        checkArr.forEach(function (item) {
            if(item.checked) {
                result.group.push({group:item.dataset.id, state:true})
            }
            else{
                result.group.push({group:item.dataset.id, state:false})

            }
        })
    console.log(result)

        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'createDiscount',
                body: JSON.stringify(result)
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
                if(data=="success"){
                    Swal({
                        title: 'Готово!',
                        text: "Изменения сохранены!",
                        type: 'warning',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Завершить'
                    }).then((result) => {
                        window.location.reload();
                    })
                }

            },
            onfailure: function () {
                console.log("error");

            }
        });
    }
</script>