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
$students=[];
CModule::IncludeModule("iblock");
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'STUDENTS'),
        false,
        false,
        Array('ID','PROPERTY_USERID', 'PROPERTY_DOGOVOR','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($students, $ar_fields);
    }
endif;

?>
<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
    <h3 class="page-header page-header-top"><?=$arResult["NAME"]?> № <?=$arResult["DISPLAY_PROPERTIES"]['NUMBER']['VALUE']?></h3>
<?endif;?>
<table class="table table-striped table-bordered table-hover dataTable no-footer" id="transaction-users-table">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th>№ договора</th>
        <th class="hidden-xs hidden-sm">Имя</th>
        <th class="hidden-xs hidden-sm">Фамилия</th>
        <th class="hidden-xs hidden-sm">Действие</th>
    </tr>
    </thead>
    <tbody>
    <?
    $i=1;
    foreach($students as $item):
?>
        <tr>
            <td class="text-center"><?=$i?></td>
            <td><a href="javascript:void(0)"><?=$item["PROPERTY_DOGOVOR_VALUE"]?></a></td>
            <td class="hidden-xs hidden-sm"><?=$item["PROPERTY_NAME_VALUE"]?></td>
            <td class="hidden-xs hidden-sm"><?=$item["PROPERTY_LAST_NAME_VALUE"]?></td>
            <td class="hidden-xs hidden-sm"><a href="#" data-userid = "<?=$item["PROPERTY_USERID_VALUE"]?>" onclick="openTransactionPopup(this)" class="transaction-popup">Провести</a></td>
        </tr>
    <?
    $i++;
    endforeach;
    ?>
    </tbody>
</table>
<script>
    function openTransactionPopup(event){
        console.log(event.dataset.userid)
        document.querySelector('#popup-transaction-modal').style.display='block'
        document.querySelector('#transaction-userid').value = event.dataset.userid
    }
    function popupTransactionModalClose() {
        document.querySelector('#popup-transaction-modal').style.display='none'

    }
</script>
    <div id="popup-transaction-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;"><div class="modal-backdrop  in" style="height: 833px;"></div>
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onClick="editPopup('close')" data-dismiss="modal">×</button>
                    <h4>Назначение платежа</h4>
                </div>
                <div class="modal-body">
                    <form action="page_form_components.html" method="post" class="form-horizontal form-box" onsubmit="return false;">                         <!-- Timepicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://jdewit.github.io/bootstrap-timepicker/ -->
                        <div class="form-group payTypeMoney">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Cумма:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" value="<?=$arResult["DISPLAY_PROPERTIES"]['SUM']['VALUE']?>" class="form-control" id="transaction-amount">
                                </div>
                            </div>
                        </div>
                        <div class="form-group payTypeLesson">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Кол-во уроков:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="number" min="0" value="1" class="form-control" id="transaction-lesson">
                                </div>
                            </div>
                        </div>
                        <input type="hidden"  value=""  id="transaction-userid">

                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Комментарий:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <textarea id="transaction-description"  class="form-control" rows="3"></textarea>                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Рублевый счет:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input class="payType_checkbox" class="form-control" type="checkbox"  name="payType">
                          </div>
                        </div>
                </div>
                <input type="hidden" id="edit-idLesson">
                </form>
                <div class="modal-footer">
                    <button class="btn btn-danger" onClick="popupTransactionModalClose()">Закрыть</button>
                    <button class="btn btn-success" onclick="createPayment()">Создать</button>
                </div>
            </div>
        </div>
        <!-- END Modal Content -->
    </div>
    <script>
        document.querySelector('.payTypeMoney').style.display='none'
        payType = document.querySelector('.payType_checkbox');
payType.addEventListener('click', ()=>{
if(payType.checked){
    document.querySelector('.payTypeMoney').style.display='block'
    document.querySelector('.payTypeLesson').style.display='none'

}
else{
    document.querySelector('.payTypeMoney').style.display='none'
    document.querySelector('.payTypeLesson').style.display='block'

}
})
        function createPayment() {
sum = $("#transaction-amount").val().replace(/,/, '.').replace(' ', '')
            console.log(Number(<?=$arResult["ID"]?>))

            BX.ajax({
                url: '/api.php',
                data: {
                    sessid: BX.bitrix_sessid(),
                    type: 'createPayment',
                    debit: 'Y',
                    amount: payType.checked ? sum : 0,
                    comments: $("#transaction-description").val(),
                    lessonBalance: payType.checked ? 0 : Number($("#transaction-lesson").val()),
                    userid: $("#transaction-userid").val(),
                    transactionid: Number(<?=$arResult["ID"]?>),
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
                            window.location='https://erperp.ru/transactions/';
                        })
                    }

                },
                onfailure: function () {
                    console.log("error");

                }
            });


        }


        $( document ).ready(function() {
            $(function () {
                /* Initialize Datatables */
                $('#transaction-users-table').dataTable();
                $('.dataTables_filter input').attr('placeholder', 'Поиск');
            });
        });


    </script>
    <?


