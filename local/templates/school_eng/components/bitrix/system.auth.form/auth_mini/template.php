<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::Init();
global $USER;
?>
<form action="<?=$arResult["AUTH_URL"]?>" id="logOutForm">
    <ul id="widgets" class="navbar-nav-custom pull-right">
<!-- User Menu -->
<li class="dropdown pull-right dropdown-user">
    <?
    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
    $rsFile = CFile::GetByID($arUser['PERSONAL_PHOTO']);
    $arFile = $rsFile->Fetch();
    $renderImage = CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], Array());
    ?>
    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
        <?if($renderImage['src']):?>
        <img src="<?=$renderImage['src']?>" width="35" height="35" alt="avatar">
        <?endif;?>
        <b class="caret"></b></a>
    <ul class="dropdown-menu">
        <!-- Just a button demostrating how loading of widgets could happen, check main.js- - uiDemo() -->
        <li class="divider"></li>
        <li>
            <!-- Modal div is at the bottom of the page before including javascript code -->
            <a href="#modal-user-settings" role="button" data-toggle="modal"><i class="fa fa-user"></i><?=GetMessage("AUTH_PROFILE")?></a>
        </li>
        <li class="divider"></li>
        <li>
            <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <input type="hidden" name="logout" value="yes" />
            <a href="#" onclick="document.getElementById('logOutForm').submit()" type="submit"><i class="fa fa-lock"></i><?=GetMessage("AUTH_LOGOUT_BUTTON")?></a>
        </li>
    </ul>
</li>
    </ul>
<!-- END User Menu -->
</form>

