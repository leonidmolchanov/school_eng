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
$userGroup=[];
$userStructure=[];

CModule::IncludeModule('Sale');

// Выберем все счета (в разных валютах) пользователя с кодом 21
$dbAccountCurrency = CSaleUserAccount::GetList(
    array(),
    array(),
    false,
    false,
    array()
);
while ($arAccountCurrency = $dbAccountCurrency->Fetch())
{
    $userBalance[$arAccountCurrency["USER_ID"]] = SaleFormatCurrency($arAccountCurrency["CURRENT_BUDGET"],
        $arAccountCurrency["CURRENCY"]);
}

if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'GROUP'),
        false,
        false,
        Array('ID', 'NAME','PROPERTY_TEACHER')
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

<div class="checkbox">
    <label for="example-checkbox1">
        <input  type="checkbox" id="filter_checkbox"> Показать всех                            </label>
</div>

<div id="example-datatables_wrapper" class="">
    <table id="user_table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example-datatables2_info">
        <thead>
        <tr role="row">
            <th rowspan="1" colspan="1" class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 80px;">
                #
            </th>
            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Username: activate to sort column ascending" style="width: 269px;">
                <i class="fa fa-user"></i> Номер договора
            </th>
            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                 Фамилия Имя студента
            </th>
            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                Название Группы
            </th>
            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                Примечание
            </th>
            <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                 Баланс занятий
            </th>
        </tr>
        </thead>
        <tbody>
        <? $number=1;?>
        <? $studentCount=0;
        $studentLowBalance=0;
        $studentBlock=0;?>
        <?foreach($arResult["ITEMS"] as $arItem):
            $studentCount++;
        if($arItem["DISPLAY_PROPERTIES"]['STATUS']['VALUE']=='0'){
            $studentBlock++;
        }
            if((int)$arItem["DISPLAY_PROPERTIES"]['LESSON_BALANCE']['VALUE']<0){
                $studentLowBalance++;
            }?>

<!--        --><?// print_r($arItem["DISPLAY_PROPERTIES"]['NAME']['VALUE'] ) ;?>
            <tr role="row" class="odd
            <? if($arItem["DISPLAY_PROPERTIES"]['STATUS']['VALUE']=='0'):?>
            danger
            <? elseif($arItem["DISPLAY_PROPERTIES"]['STATUS']['VALUE']=='1'):?>
            success
            <? elseif($arItem["DISPLAY_PROPERTIES"]['STATUS']['VALUE']=='2'):?>
            warning
            <?endif;?>
            "
            >
                <td class="text-center sorting_1">
                    <?=$number;?>
                </td>
                <td>
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["DISPLAY_PROPERTIES"]['DOGOVOR']['VALUE']?></a>
                </td>
                <td>
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["DISPLAY_PROPERTIES"]['LAST_NAME']['VALUE']?> <?=$arItem["DISPLAY_PROPERTIES"]['NAME']['VALUE']?></a>
                </td>
                <td>
                    <span class="label label-default"><?=$userStructure[$arItem['ID']]?></span>
                </td>
                <td>
                    <span class="label label-default"><?=$arItem["DISPLAY_PROPERTIES"]['COMMENTS']['VALUE']?></span>
                </td>
                <td>

                        <?if($arItem["DISPLAY_PROPERTIES"]['LESSON_BALANCE']['VALUE']):?>
                        <?=$arItem["DISPLAY_PROPERTIES"]['LESSON_BALANCE']['VALUE']; ?>
                        <?else:?>
                       0
                        <?endif;?>

                </td>
            </tr>
        <?$number++;?>
        <?endforeach;?>
        </tbody>
    </table>

</div>
<div class="row">
    <div class="col-sm-12 hidden-xs">
        <div>
            <strong>Итого: <?=$studentCount?></strong>
        </div>
    </div>
    <div class="col-sm-12 hidden-xs">
        <div>
            <strong>Итого со статусом не купленных занятий: <?=$studentLowBalance?></strong>
        </div>
    </div>
    <div class="col-sm-12 hidden-xs">
        <div>
            <strong>Итого со статусом заморожен: <?=$studentBlock?></strong>
        </div>
    </div>
</div>
<script>
    BX.ready(function() {
        $(function () {
            /* Initialize Datatables */
            $('#user_table').dataTable({columnDefs: [{orderable: false, targets: [0]}]});
            $('.dataTables_filter input').attr('placeholder', 'Поиск');
        });
    });

    document.querySelector('#filter_checkbox').addEventListener('click', function (evt) {
       elem =  $('#user_table tbody tr')
        console.log(elem)


    })
</script>

