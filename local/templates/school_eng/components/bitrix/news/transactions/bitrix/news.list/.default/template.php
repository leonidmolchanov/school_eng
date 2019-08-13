
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
require($_SERVER["DOCUMENT_ROOT"]."/local/include/school_id.php");

?>

<div class="col-md-12 push">
    <div id="example-datatables2_wrapper" class="">
        <table id="transactions-table"
               class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
               aria-describedby="example-datatables3_info">
            <thead>
            <tr role="row">
                <th class="text-center sorting_asc" tabindex="0" aria-controls="journal-table"
                    rowspan="1" colspan="1" aria-sort="ascending"
                    aria-label="#: activate to sort column descending" style="width: 71px;">#
                </th>
                <th class="sorting" tabindex="0" aria-controls="journal-table" rowspan="1" colspan="1"
                    aria-label=" Username: activate to sort column ascending" style="width: 252px;">Дата:
                </th>
                <th class="sorting" tabindex="0" aria-controls="journal-table" rowspan="1" colspan="1"
                    aria-label=" Username: activate to sort column ascending" style="width: 252px;">Номер:
                </th>
                <th class="sorting" tabindex="0" aria-controls="journal-table" rowspan="1" colspan="1"
                    aria-label=" Username: activate to sort column ascending" style="width: 252px;">Сумма:
                </th>
                <th class="sorting" tabindex="0" aria-controls="journal-table" rowspan="1" colspan="1"
                    aria-label=" Username: activate to sort column ascending" style="width: 252px;">Статус:
                </th>
            </tr>
            </thead>
            <tbody>
            <?$number=1;?>
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
//                if($schoolID && $schoolID!=$arItem["DISPLAY_PROPERTIES"]["SCHOOL_ID"]["DISPLAY_VALUE"]):
//                    continue;
//                endif;
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <tr role="row" class="odd">
                    <?if($arItem["DISPLAY_PROPERTIES"]["STATUS"]["DISPLAY_VALUE"]==0):?>
                    <td><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?=$number?></a></td>
                    <td><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"]?></a></td>
                    <td><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["DISPLAY_PROPERTIES"]["NUMBER"]["DISPLAY_VALUE"]?></a></td>
                    <td><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["DISPLAY_PROPERTIES"]["SUM"]["DISPLAY_VALUE"]?> рублей</a></td>
                    <td><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>">Не проведен</a></td>
<?else:?>
                        <td><?=$number?></td>
                        <td><?echo $arItem["DISPLAY_PROPERTIES"]["DATE"]["DISPLAY_VALUE"]?></td>
                        <td><?echo $arItem["DISPLAY_PROPERTIES"]["NUMBER"]["DISPLAY_VALUE"]?></td>
                        <td><?echo $arItem["DISPLAY_PROPERTIES"]["SUM"]["DISPLAY_VALUE"]?> рублей</td>
                        <td>Проведен</td>
                    <?endif;?>
                </tr>
                <?
                $number++;?>
            <?endforeach;?>
            </tbody>
        </table>
    </div>

</div>
<script>
    $( document ).ready(function() {
        $(function () {
            /* Initialize Datatables */
            $('#transactions-table').dataTable();
            $('.dataTables_filter input').attr('placeholder', 'Поиск');
        });
    });


</script>
