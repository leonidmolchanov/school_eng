<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



<?if (!empty($arResult)):?>
    <nav id="primary-nav">
    <ul>

<?
$previousLevel = 0;
foreach($arResult as $arItem):?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
        <li <?if($arItem["SELECTED"]):?>class="active"<?endif;?>><a href="#" <?if($arItem["SELECTED"]):?>class="active"<?endif;?>><i class="gi <?if($arItem["PARAMS"]["label"]):?>gi-<?=$arItem["PARAMS"]["label"]?><?endif;?>"></i><?=$arItem["TEXT"]?></a>
				<ul>
		<?else:?>
<!--			<li><a href="--><?//=$arItem["LINK"]?><!--" class="parent--><?//if ($arItem["SELECTED"]):?><!-- item-selected--><?//endif?><!--">--><?//=$arItem["TEXT"]?><!--</a>-->
				<ul>
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
                <li <?if($arItem["SELECTED"]):?>class="active"<?endif;?>><a href="<?=$arItem["LINK"]?>" <?if($arItem["SELECTED"]):?>class="active"<?endif;?>><i class="gi <?if($arItem["PARAMS"]["label"]):?>gi-<?=$arItem["PARAMS"]["label"]?><?endif;?>"></i><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li><a href="<?=$arItem["LINK"]?>" <?if($arItem["SELECTED"]):?>class="active"<?endif;?>><i class="fa <?if($arItem["PARAMS"]["label"]):?>fa-<?=$arItem["PARAMS"]["label"]?><?endif;?>"></i><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>

			<?else:?>

            <?endif?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
    </nav>
<?endif?>