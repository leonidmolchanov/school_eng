<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="nav-dash">

<?
$previousLevel = 0;
foreach($arResult as $arItem):?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
            <li>
                <a href="<?=$arItem["LINK"]?>" data-toggle="tooltip" title="<?=$arItem["TEXT"]?>" class="animation-fadeIn">
                    <i class="fa fa-user"></i>
                </a>
            </li>
        <?else:?>
            <li>
                <a href="<?=$arItem["LINK"]?>" data-toggle="tooltip" title="<?=$arItem["TEXT"]?>" class="animation-fadeIn">
                    <i class="fa fa-user"></i>
                </a>
            </li>
        <?endif?>
	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
                <li>
                    <a href="<?=$arItem["LINK"]?>" data-toggle="tooltip" title="<?=$arItem["TEXT"]?>" class="animation-fadeIn">
                        <i class="fa <?if($arItem["PARAMS"]["label"]):?>fa-<?=$arItem["PARAMS"]["label"]?><?endif;?>"></i>
                    </a>
                </li>
			<?else:?>
                <li>
                    <a href="<?=$arItem["LINK"]?>" data-toggle="tooltip" title="<?=$arItem["TEXT"]?>" class="animation-fadeIn">
                        <i class="fa fa-user"></i>
                    </a>
                </li>
			<?endif?>
		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
<div class="menu-clear-left"></div>
<?endif?>