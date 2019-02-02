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
        <? $number=0;?>
        <? $studentCount=0;
        $studentLowBalance=0;
        $studentBlock=0;?>
        <?foreach($arResult["ITEMS"] as $arItem):
            $studentCount++;
        if($arItem["DISPLAY_PROPERTIES"]['STATUS']['VALUE']=='0'){
            $studentBlock++;
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
            ">
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
                        <?=$userBalance[$arItem["DISPLAY_PROPERTIES"]['USERID']['VALUE']];
                        if($userBalance[$arItem["DISPLAY_PROPERTIES"]['USERID']['VALUE']]<0){
                            $studentLowBalance++;
                        }
                        ?>
                        <?else:?>
                       Счет не заведен!
                        <?endif;?>
                        </span>
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
            <strong>Итого со статусом не достаточно средств: <?=$studentLowBalance?></strong>
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
            $('#example-datatables').dataTable({columnDefs: [{orderable: false, targets: [0]}]});
            $('#example-datatables2').dataTable();
            $('#example-datatables3').dataTable();
            $('.dataTables_filter input').attr('placeholder', 'Поиск');
        });
    });
</script>
<!---->
<?//if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
<!--	--><?//=$arResult["NAV_STRING"]?>
<?//endif;?>
<!--        <div class="row">-->
<!--            <div class="col-sm-4 hidden-xs">-->
<!--                <div class="dataTables_info" id="example-datatables2_info" role="status" aria-live="polite">-->
<!--                    <strong>Итого (без учета со статусом "занимается"):</strong>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-sm-4 hidden-xs">-->
<!--                <div class="dataTables_info" id="example-datatables2_info" role="status" aria-live="polite">-->
<!--                    <strong>Итого (всех студентов):</strong>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-sm-4 hidden-xs">-->
<!--                <div class="dataTables_info" id="example-datatables2_info" role="status" aria-live="polite">-->
<!--                    <strong>Итого (со статусом заморожен или закончился):</strong>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-md-6 push text-center">-->
<!--        <table id="example-datatables" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example-datatables_info">-->
<!--            <thead>-->
<!--            <tr role="row">-->
<!--                <th rowspan="1" colspan="2" class="sorting" tabindex="0" aria-controls="example-datatables" aria-label=" Status: activate to sort column ascending" style="width: 324px;">-->
<!--                    Карточка студента-->
<!--                </th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            <tr role="row" class="odd">-->
<!--                <td>-->
<!--                    <strong>Имя Фамилия студента</strong>-->
<!--                </td>-->
<!--                <td>-->
<!--                    Илья Попов-->
<!--                </td>-->
<!--            </tr>-->
<!--            <tr role="row" class="odd">-->
<!--                <td>-->
<!--                    <strong>Возраст студента</strong>-->
<!--                </td>-->
<!--                <td>-->
<!--                    8.08.2006 12 лет-->
<!--                </td>-->
<!--            </tr>-->
<!--            <tr role="row" class="odd">-->
<!--                <td>-->
<!--                    <strong>Номер договора</strong>-->
<!--                </td>-->
<!--                <td>-->
<!--                    160-->
<!--                </td>-->
<!--            </tr>-->
<!--            <tr role="row" class="odd">-->
<!--                <td>-->
<!--                    <strong>Имя Фамилия родителя (Мама)</strong>-->
<!--                </td>-->
<!--                <td>-->
<!--                    Попова Ирина-->
<!--                </td>-->
<!--            </tr>-->
<!--            <tr role="row" class="odd">-->
<!--                <td>-->
<!--                    <strong>Имя Фамилия родителя (Папа)</strong>-->
<!--                </td>-->
<!--                <td>-->
<!--                    Попов Павел-->
<!--                </td>-->
<!--            </tr>-->
<!--            <tr role="row" class="odd">-->
<!--                <td>-->
<!--                    <strong>Дата старта обучения</strong>-->
<!--                </td>-->
<!--                <td>-->
<!--                    1.1.2000-->
<!--                </td>-->
<!--            </tr>-->
<!--            </tbody>-->
<!--        </table>-->
<!--    </div>-->
<!--</div>-->
