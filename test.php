
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$days=[];
?>
<script>
    days=[];
    weekends=[]
  let  selector='global'
</script>
<?
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'SCHEDULE'),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_MON','PROPERTY_TUE','PROPERTY_WEN','PROPERTY_THU','PROPERTY_FRI','PROPERTY_SAT','PROPERTY_SUN', 'PROPERTY_TYPE', 'PROPERTY_TEACHER_ID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        if($ar_fields['PROPERTY_TYPE_VALUE']=="GLOBAL"){
        $days['GLOBAL'] =  $ar_fields;


        ?>
            <script>
                days["global"]={
                    Mon: <?=$ar_fields['PROPERTY_MON_VALUE']?>,
                    Tue: <?=$ar_fields['PROPERTY_TUE_VALUE']?>,
                    Wed: <?=$ar_fields['PROPERTY_WEN_VALUE']?>,
                    Thu: <?=$ar_fields['PROPERTY_THU_VALUE']?>,
                    Fri: <?=$ar_fields['PROPERTY_FRI_VALUE']?>,
                    Sat: <?=$ar_fields['PROPERTY_SAT_VALUE']?>,
                    Sun: <?=$ar_fields['PROPERTY_SUN_VALUE']?>}
            </script>

            <?

        }

        else{
            $days[$ar_fields['ID']] =  $ar_fields;
?>
<script>
    days[<?=$ar_fields['PROPERTY_TEACHER_ID_VALUE']?>]={
        Mon: <?=$ar_fields['PROPERTY_MON_VALUE']?>,
        Tue: <?=$ar_fields['PROPERTY_TUE_VALUE']?>,
        Wed: <?=$ar_fields['PROPERTY_WEN_VALUE']?>,
        Thu: <?=$ar_fields['PROPERTY_THU_VALUE']?>,
        Fri: <?=$ar_fields['PROPERTY_FRI_VALUE']?>,
        Sat: <?=$ar_fields['PROPERTY_SAT_VALUE']?>,
        Sun: <?=$ar_fields['PROPERTY_SUN_VALUE']?>}
</script>
<?
        }
    }

endif;
?>
<form action="#" method="post" class="form-horizontal form-box" onsubmit="return false;">
    <h4 class="form-box-header">График выходных</h4>
        <div class="form-group">
            <label class="control-label col-md-2">Выберете тип</label>
            <div class="col-md-4">

            <select class="form-control input-sm" id="actionSelect">
        <option data-id="global">Глобальные</option>
                <?
                if (CModule::IncludeModule("iblock")):
                    # show url my elements
                    $my_elements = CIBlockElement::GetList (
                        Array("ID" => "ASC"),
                        Array("IBLOCK_CODE" => 'TEACHER'),
                        false,
                        false,
                        Array('ID', 'NAME')
                    );

                    while($ar_fields = $my_elements->GetNext())
                    {
                       ?>

                        <option data-id="<?=$ar_fields['ID']?>"><?=$ar_fields['NAME']?></option>

                        <?
                    }
                endif;
                ?>
    </select>
    </div>
        </div>
    <div class="form-box-content">
        <div class="form-group">
            <label class="control-label col-md-2">Выходные на неделе</label>
            <div class="col-md-8">
                <label class="checkbox-inline" for="checkbox-mon">
                    <input type="checkbox" id="checkbox-mon" <?if($days['GLOBAL']['PROPERTY_MON_VALUE']==1):?>checked<?endif;?> name="checkbox-mon" value="1"> Понедельник
                </label>
                <label class="checkbox-inline" for="checkbox-tue">
                    <input type="checkbox" id="checkbox-tue" name="checkbox-tue" <?if($days['GLOBAL']['PROPERTY_TUE_VALUE']==1):?>checked<?endif;?> value="2"> Вторник
                </label>
                <label class="checkbox-inline" for="checkbox-wen">
                    <input type="checkbox" id="checkbox-wen" name="checkbox-wen"  <?if($days['GLOBAL']['PROPERTY_WEN_VALUE']==1):?>checked<?endif;?> value="3"> Среда
                </label>
                <label class="checkbox-inline" for="checkbox-thu">
                    <input type="checkbox" id="checkbox-thu" name="checkbox-thu" <?if($days['GLOBAL']['PROPERTY_THU_VALUE']==1):?>checked<?endif;?> value="4"> Четверг
                </label>
                <label class="checkbox-inline" for="checkbox-fri">
                    <input type="checkbox" id="checkbox-fri" name="checkbox-fri" <?if($days['GLOBAL']['PROPERTY_FRI_VALUE']==1):?>checked<?endif;?> value="5"> Пятница
                </label>
                <label class="checkbox-inline" for="checkbox-sat">
                    <input type="checkbox" id="checkbox-sat" name="checkbox-sat" <?if($days['GLOBAL']['PROPERTY_SAT_VALUE']==1):?>checked<?endif;?> value="6"> Суббота
                </label>
                <label class="checkbox-inline" for="checkbox-sun">
                    <input type="checkbox" id="checkbox-sun" name="checkbox-sun" <?if($days['GLOBAL']['PROPERTY_SUN_VALUE']==1):?>checked<?endif;?> value="7"> Воскресенье
                </label>
            </div>
        </div>
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
                            Array("IBLOCK_CODE" => 'WEEKENDS'),
                            false,
                            false,
                            Array('ID', 'NAME','PROPERTY_DATE', 'PROPERTY_TYPE', 'PROPERTY_TEACHER_ID')
                        );

                        while($ar_fields = $my_elements->GetNext())
                        {
                            if($ar_fields['PROPERTY_TYPE_VALUE']=="GLOBAL") {
                                ?>
                                <option
                                value="<?= date('d.m', strtotime($ar_fields['PROPERTY_DATE_VALUE'])) ?>" ><?= date('d.m', strtotime($ar_fields['PROPERTY_DATE_VALUE'])) ?></option><?

                           ?>
                                <script>
if(!weekends['global']){
    weekends['global']=[]
}
                                    weekends['global'].push('<?= date('d.m', strtotime($ar_fields['PROPERTY_DATE_VALUE'])) ?>')
                                </script>
                    <?
                            }
                            else{

                            ?>
                                <script>
                                    if(!weekends[<?=$ar_fields['PROPERTY_TEACHER_ID_VALUE']?>]){
                                        weekends[<?=$ar_fields['PROPERTY_TEACHER_ID_VALUE']?>]=[]
                                    }
                                weekends[<?=$ar_fields['PROPERTY_TEACHER_ID_VALUE']?>].push('<?= date('d.m', strtotime($ar_fields['PROPERTY_DATE_VALUE'])) ?>')
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

    let actionSelect = document.querySelector('#actionSelect');

    actionSelect.addEventListener('change', (ev)=>{

        console.log(ev.target[actionSelect.selectedIndex].dataset.id)
        selector = ev.target[actionSelect.selectedIndex].dataset.id
        console.log(weekends[ev.target[actionSelect.selectedIndex].dataset.id])
document.querySelector('#date-select').options.length = 0;

        if(days[ev.target[actionSelect.selectedIndex].dataset.id]) {
            document.querySelector('#checkbox-mon').checked=days[ev.target[actionSelect.selectedIndex].dataset.id].Mon
            document.querySelector('#checkbox-tue').checked=days[ev.target[actionSelect.selectedIndex].dataset.id].Tue
            document.querySelector('#checkbox-wen').checked=days[ev.target[actionSelect.selectedIndex].dataset.id].Wed
            document.querySelector('#checkbox-thu').checked=days[ev.target[actionSelect.selectedIndex].dataset.id].Thu
            document.querySelector('#checkbox-fri').checked=days[ev.target[actionSelect.selectedIndex].dataset.id].Fri
            document.querySelector('#checkbox-sat').checked=days[ev.target[actionSelect.selectedIndex].dataset.id].Sat
            document.querySelector('#checkbox-sun').checked=days[ev.target[actionSelect.selectedIndex].dataset.id].Sun
        }
        else{
            document.querySelector('#checkbox-mon').checked=false
            document.querySelector('#checkbox-tue').checked=false
            document.querySelector('#checkbox-wen').checked=false
            document.querySelector('#checkbox-thu').checked=false
            document.querySelector('#checkbox-fri').checked=false
            document.querySelector('#checkbox-sat').checked=false
            document.querySelector('#checkbox-sun').checked=false
        }

        if(weekends[ev.target[actionSelect.selectedIndex].dataset.id]){
i=0;
            weekends[ev.target[actionSelect.selectedIndex].dataset.id].forEach(function (item) {
                document.querySelector('#date-select').options[i] = new Option (item, item);
i++
            })

        }
    })
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
    let result={'schedule':[],
    'weekend':{
        'mon':document.querySelector('#checkbox-mon').checked,
        'tue':document.querySelector('#checkbox-tue').checked,
        'wen':document.querySelector('#checkbox-wen').checked,
        'thu':document.querySelector('#checkbox-thu').checked,
        'fri':document.querySelector('#checkbox-fri').checked,
        'sat':document.querySelector('#checkbox-sat').checked,
        'sun':document.querySelector('#checkbox-sun').checked

    }}
    let SelectRes = document.querySelector('#date-select').getElementsByTagName('option');
    for (let i = 0; i < SelectRes.length; i++) {
        result.schedule.push(SelectRes[i].value)
        }
console.log(selector)

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
                if (data == 'Success') {
                    console.log('good')
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
