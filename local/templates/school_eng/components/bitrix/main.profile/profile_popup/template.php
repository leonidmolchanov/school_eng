<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<div class="bx-auth-profile">

    <?ShowError($arResult["strProfileError"]);?>
    <?
    if ($arResult['DATA_SAVED'] == 'Y')
        ShowNote(GetMessage('PROFILE_DATA_SAVED'));
    ?>
    <script type="text/javascript">
        <!--
        var opened_sections = [<?
            $arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
            $arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
            if (strlen($arResult["opened"]) > 0)
            {
                echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
            }
            else
            {
                $arResult["opened"] = "reg";
                echo "'reg'";
            }
            ?>];
        //-->

        var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
    </script>
<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
    <?=$arResult["BX_SESSION_CHECK"]?>
    <input type="hidden" name="lang" value="<?=LANG?>" />
    <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />

<div id="modal-user-settings" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4><?=GetMessage('profile_settings')?></h4>
            </div>
            <div class="modal-body">
                <ul id="example-user-tabs" class="nav nav-tabs" data-toggle="tabs">
                    <li class="active"><a href="#example-user-tabs-account"><i class="fa fa-cogs"></i><?=GetMessage('account')?></a></li>
                    <li><a href="#example-user-tabs-profile"><i class="fa fa-user"></i><?=GetMessage('profile')?></a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="example-user-tabs-account">
<!--                        <div class="alert alert-success">-->
<!--                            <button type="button" class="close" data-dismiss="alert">&times;</button>-->
<!--                            <strong>Success!</strong> Password changed!-->
<!--                        </div>-->
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-md-3"><br></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><br></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <p class="form-control-static"><? echo $arResult["arUser"]["LOGIN"]?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="password" name="NEW_PASSWORD" maxlength="50" placeholder="<?=GetMessage('NEW_PASSWORD_REQ')?>" value="" autocomplete="off" id="example-user-pass" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="password" name="NEW_PASSWORD_CONFIRM" placeholder="<?=GetMessage('NEW_PASSWORD_CONFIRM')?>" maxlength="50" value="" autocomplete="off" id="example-user-newpass"
                                           class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane" id="example-user-tabs-profile">
                        <h4 class="page-header-sub"><?=GetMessage("USER_PHOTO");?></h4>
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <?=$arResult["arUser"][PERSONAL_PHOTO_HTML];?>
                                </div>
                                <div class="col-md-6">

                                        <div class="fallback">
                                            <input name="PERSONAL_PHOTO" class="typefile" size="20" type="file">                                        </div>
                                </div>
                            </div>
                        </div>
                        <form class="form-horizontal">
                            <h4 class="page-header-sub"><?=GetMessage("detail");?></h4>
                        <?if($arResult["arUser"]["NAME"]):?>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="example-user-firstname"><?=GetMessage('NAME')?></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?=$arResult["arUser"]["NAME"]?></p>
                                </div>
                            </div>
                            <?endif;?>
                            <?if($arResult["arUser"]["SECOND_NAME"]):?>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="example-user-firstname"><?=GetMessage('SECOND_NAME')?></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?=$arResult["arUser"]["SECOND_NAME"]?></p>
                                </div>
                            </div>
                            <?endif;?>
                            <?if($arResult["arUser"]["LAST_NAME"]):?>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="example-user-lastname"><?=GetMessage('LAST_NAME')?></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?=$arResult["arUser"]["LAST_NAME"]?></p>
                                </div>
                            </div>
                            <?endif;?>
                            <?if($arResult["arUser"]["PERSONAL_GENDER"]):?>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="example-user-gender"><?=GetMessage('USER_GENDER')?></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?=$arResult["arUser"]["PERSONAL_GENDER"]?></p>
                                </div>
                            </div>
                            <?endif;?>
                            <?if($arResult["arUser"]["PERSONAL_NOTES"]):?>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="example-user-bio"><?=GetMessage("USER_NOTES")?></label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><?=$arResult["arUser"]["PERSONAL_NOTES"]?></p>
                                </div>
                            </div>
                            <?endif;?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer remove-margin">
                <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><?=GetMessage('close')?></button>
                <input type="submit" class="btn btn-success" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">
            </div>
        </div>
    </div>
</div>
</form>
</div>


