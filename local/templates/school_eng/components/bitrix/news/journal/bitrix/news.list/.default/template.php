
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
        <table id="journal-table"
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
                    aria-label=" Username: activate to sort column ascending" style="width: 252px;">Название:
                </th>
            </tr>
            </thead>
            <tbody>
            <?$number=1;?>
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
            if($schoolID):

                if($schoolID==$arItem["DISPLAY_PROPERTIES"]["SCHOOL_ID"]["DISPLAY_VALUE"]):
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <tr role="row" class="odd">
                        <td><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?=$number?></a></td>
                        <td><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["TIMESTAMP_X"]?></a></td>
                        <td><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></td>
                    </tr>
                <?

            endif;
                else:

                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <tr role="row" class="odd">
                    <td><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?=$number?></a></td>
                    <td><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["TIMESTAMP_X"]?></a></td>
                    <td><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></td>
                </tr>
                <?
                endif;
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
            $('#journal-table').dataTable();
            $('.dataTables_filter input').attr('placeholder', 'Поиск');
        });
    });


</script>
<div class="news-list">
    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?><br />
    <?endif;?>

    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <br /><?=$arResult["NAV_STRING"]?>
    <?endif;?>
</div>