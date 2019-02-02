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
$userBalance=[];
$userStudent=[];
$userLessons=[];

CModule::IncludeModule('Sale');

if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'STUDENTS'),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_NAME','PROPERTY_LAST_NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $userStudent[$ar_fields['ID']]=$ar_fields['PROPERTY_NAME_VALUE']." ".$ar_fields['PROPERTY_LAST_NAME_VALUE'];
    }
endif;

if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'LESSON'),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_FROM')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        $userLessons[$ar_fields['ID']]=Array('NAME'=>$ar_fields['NAME'], 'FROM'=>$ar_fields['PROPERTY_FROM_VALUE']);
    }
endif;
if (CModule::IncludeModule("iblock")):
# show url my elements
$my_elements = CIBlockElement::GetList (
    Array("ID" => "ASC"),
    Array("IBLOCK_CODE" => 'GROUP_STRUCTURE', "PROPERTY_GROUP_ID" => $_REQUEST['groupID']),
    false,
    false,
    Array('ID', 'PROPERTY_STUDENT_ID','PROPERTY_GROUP_ID')
);

while($ar_fields = $my_elements->GetNext())
{
    $userStructure[$ar_fields['PROPERTY_STUDENT_ID_VALUE']]=$userGroup[$ar_fields['PROPERTY_GROUP_ID_VALUE']];
}
endif;
?>


<div id="example-datatables_wrapper" class="">
    <table id="example-datatables3" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example-datatables2_info">
        <thead>
        <tr role="row">
            <th rowspan="1" colspan="1" class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 80px;">
                #
            </th>
            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Username: activate to sort column ascending" style="width: 269px;">
                <i class="fa fa-user"></i> Фамилия Имя студента
            </th>
            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                 Дата отработки
            </th>
            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                Группа отработки
            </th>
            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                Примечание
            </th>
            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                 Статус
            </th>
        </tr>
        </thead>
        <tbody>
        <? $number=0;?>
        <?foreach($arResult["ITEMS"] as $arItem):?>
<!--        --><?// print_r($arItem["DISPLAY_PROPERTIES"]['NAME']['VALUE'] ) ;?>
                <tr role="row" class="odd">
                <td class="text-center sorting_1">
                    <?=$number;?>
                </td>
                <td>
                    <?if($arItem["DISPLAY_PROPERTIES"]['STATUS']['VALUE']==3):?>
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
<?=$userStudent[$arItem["DISPLAY_PROPERTIES"]['USERID']['VALUE']];?>
                    </a>
                    <?else:?>
                        <?=$userStudent[$arItem["DISPLAY_PROPERTIES"]['USERID']['VALUE']];?>

                    <?endif;?>
                </td>
                <td><?if($userLessons[$arItem["DISPLAY_PROPERTIES"]['ALESSONID']['VALUE']]['FROM']):?>
                    <?=date("d.m.Y H:i", strtotime($userLessons[$arItem["DISPLAY_PROPERTIES"]['ALESSONID']['VALUE']]['FROM']));?>
<?else:?>
                    Отработка не назначена
                    <?endif;?>
                </td>
                <td>
                    <?=$userLessons[$arItem["DISPLAY_PROPERTIES"]['ALESSONID']['VALUE']]['NAME']?>

                </td>
                <td>
                    <?=$arItem["DISPLAY_PROPERTIES"]['DESCRIPTION']['VALUE'];?>

                </td>
                <td>
                    <?if($arItem["DISPLAY_PROPERTIES"]['STATUS']['VALUE']==0):?>
Не отработан
                    <?elseif($arItem["DISPLAY_PROPERTIES"]['STATUS']['VALUE']==1):?>
                    Отработан
                    <?elseif($arItem["DISPLAY_PROPERTIES"]['STATUS']['VALUE']==2):?>
                    Пропуск отработки
                    <?elseif($arItem["DISPLAY_PROPERTIES"]['STATUS']['VALUE']==3):?>
                        Ждет назначения
                    <?endif;?>
                    <a href="#" alt="Удалить отработку" onclick="deleteAdjustment(<?=$arItem['ID']?>)" id="delRow30" class="btn btn-xs btn-danger delRow"><i class="fa fa-times"></i></a>

                </td>
            </tr>
        <?$number++;?>
        <?endforeach;?>
        </tbody>
    </table>

</div>
<script>
    function deleteAdjustment(id){
        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'deleteAdjustment',
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
                    Swal({
                        title: 'Готово!',
                        text: "Отработка удалена!",
                        type: 'warning',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Завершить'
                    }).then((result) => {
                        window.location.reload()
                    })                 }
            },
            onfailure: function () {
                console.log("error");

            }
        });
    }
    BX.ready(function() {
        $(function () {
            /* Initialize Datatables */
            $('#example-datatables').dataTable({columnDefs: [{orderable: false, targets: [0]}]});
            $('#example-datatables2').dataTable();
            $('#example-datatables3').dataTable();
            $('.dataTables_filter input').attr('placeholder', 'Поиск');
        });
    });
</script>

