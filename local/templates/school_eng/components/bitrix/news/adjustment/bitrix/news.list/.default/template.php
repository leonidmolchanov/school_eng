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
    Array("IBLOCK_CODE" => 'GROUP_STRUCTURE'),
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
    <table id="example-datatables2" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example-datatables2_info">
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
                 Баланс
            </th>
        </tr>
        </thead>
        <tbody>
        <? $number=1;?>
        <?foreach($arResult["ITEMS"] as $arItem):?>
<!--        --><?// print_r($arItem["DISPLAY_PROPERTIES"]['NAME']['VALUE'] ) ;?>
            <? if($arItem["DISPLAY_PROPERTIES"]['STATUS']['VALUE']!=='0'):?>
                <tr role="row" class="odd">
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
                    <span class="label label-default">
                        <?if($userBalance[$arItem["DISPLAY_PROPERTIES"]['USERID']['VALUE']]):?>
                        <?=$userBalance[$arItem["DISPLAY_PROPERTIES"]['USERID']['VALUE']];?>
                        <?else:?>
                       Счет не заведен!
                        <?endif;?>
                        </span>
                </td>
            </tr>
        <?$number++;?>
        <?endif;?>
        <?endforeach;?>
        </tbody>
    </table>

</div>
<script>
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

