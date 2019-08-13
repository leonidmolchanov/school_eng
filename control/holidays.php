
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$days=[];
?>
<script>
    let  selector='holidays'
    holidays=[]
</script>

<form action="#" method="post" class="form-horizontal form-box" onsubmit="return false;">
    <h4 class="form-box-header">Праздники</h4>

    <div class="form-box-content">

        <!-- Datepicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://eternicode.github.io/bootstrap-datepicker -->
        <div class="form-group">
            <label class="control-label col-md-2" for="example-input-datepicker">Дата:</label>
            <div class="col-md-2">
                <input type="date" id="date-target" name="date-target">
            </div>
            <div class="col-md-8">
                <span class="help-block">                <button class="btn btn-success select-add">Добавить в годовой календарь</button>
</span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="example-select-multiple">Выходные и праздники</label>
            <div class="col-md-2">
                <select id="date-select" name="date-select" class="form-control" multiple="">
                    <?
                    if (CModule::IncludeModule("iblock")):
                        # show url my elements
                        $my_elements = CIBlockElement::GetList (
                            Array("ID" => "ASC"),
                            Array("IBLOCK_CODE" => 'WEEKENDS',
                                'PROPERTY_SCHOOL_ID'=>$schoolID),
                            false,
                            false,
                            Array('ID', 'NAME','PROPERTY_DATE', 'PROPERTY_TYPE', 'PROPERTY_TEACHER_ID')
                        );

                        while($ar_fields = $my_elements->GetNext())
                        {
                            if($ar_fields['PROPERTY_TYPE_VALUE']=="HOLIDAYS") {
                                ?>
                                <option
                                value="<?= date('d.m', strtotime($ar_fields['PROPERTY_DATE_VALUE'])) ?>" ><?= date('d.m', strtotime($ar_fields['PROPERTY_DATE_VALUE'])) ?></option><?

                           ?>
                                <script>
if(!holidays['global']){
    holidays['global']=[]
}
holidays['global'].push('<?= date('d.m', strtotime($ar_fields['PROPERTY_DATE_VALUE'])) ?>')
                                </script>
                    <?
                            }
                            }
                    endif;
                    ?>
                    ?>
                </select>
            </div>
            <div class="col-md-8">
                <span class="help-block">                <button data-remove="" style="display: none" class="btn btn-danger select-remove">Удалить из списка</button>
</span>
            </div>
        </div>
        <div class="form-group form-actions">
            <div class="col-md-10 col-md-offset-2">
                <button class="btn btn-success proc" id="submitProcess"><i class="fa fa-floppy-o"></i> Сохранить</button>
            </div>
        </div>
    </div>
</form>
<script>

let   btnSelect =  document.querySelector('.select-add');
let Select = document.querySelector('#date-select');
let btnRemove = document.querySelector('.select-remove')
let   btnProccess =  document.querySelector('#submitProcess');

btnSelect.addEventListener('click', function (e) {
let dateTarget = document.querySelector('#date-target');
if(dateTarget.value) {
    console.log(moment(dateTarget.value).format('DD.MM'))
    let dateSelect = document.querySelector('#date-select').getElementsByTagName('option');
    console.log(dateSelect)

    let findElement = function (dateSelect, dateTarget) {

        for (let i = 0; i < dateSelect.length; i++) {
            if (dateSelect[i].value == moment(dateTarget.value).format('DD.MM')) {
                return true
            }

        }
        return false
    }

    if(!findElement(dateSelect, dateTarget)){
        Select.options[Select.options.length]= new Option(moment(dateTarget.value).format('DD.MM'), moment(dateTarget.value).format('DD.MM'));
    }
}
})


Select.addEventListener('change', function (e) {

    console.log(Select.options[Select.options.selectedIndex].value)
    btnRemove.dataset.remove = Select.options.selectedIndex
    btnRemove.style.display = 'block'
    // Select.options[Select.options.selectedIndex].remove()
})
btnRemove.addEventListener('click', function (e) {

    Select.options[btnRemove.dataset.remove].remove()
})
btnProccess.addEventListener('click', function (e) {
  let result=[];
    let SelectRes = document.querySelector('#date-select').getElementsByTagName('option');
    for (let i = 0; i < SelectRes.length; i++) {
        result.push(SelectRes[i].value)
        }
console.log(result)

        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'setSchedule',
                action: selector,
                data: JSON.stringify(result)
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
                        'Настройки сохранены',
                        'success'
                    )
                    window.location.reload();
                }
            },
            onfailure: function () {
                console.log("error");

            }
        });
    }
)
</script>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
