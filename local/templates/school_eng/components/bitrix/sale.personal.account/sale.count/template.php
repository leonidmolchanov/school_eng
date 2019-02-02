<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="col-md-3 text-center">
    <!-- Total Profit Tile -->
    <div class="dash-tile dash-tile-leaf clearfix animation-pullDown">
        <div class="dash-tile-header">
                                    <span class="dash-tile-options">
                                    </span>
            <?=Bitrix\Main\Localization\Loc::getMessage('SPA_BILL_AT')?>
            <?=$arResult["DATE"];?>
        </div>
        <?
        foreach($arResult["ACCOUNT_LIST"] as $accountValue)
        {
        ?>
        <div class="dash-tile-icon"><i class="fa fa-money"></i></div>
        <div class="dash-tile-text"><span id="user-balance"> <?=$accountValue['SUM']?></span></div>
            <?
        }
        ?>
    </div>