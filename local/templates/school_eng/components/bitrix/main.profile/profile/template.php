<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
    ?>
    <!-- Profile -->
    <h3 class="page-header page-header-top"><i class="fa fa-user"></i> <?=$arResult["arUser"]["NAME"]?> <?=$arResult["arUser"]["SECOND_NAME"]?> <?=$arResult["arUser"]["LAST_NAME"]?>  <small><?=$arResult["arUser"]["LOGIN"]?></small></h3>

    <div class="row">
        <!-- First Column | Image and menu -->
        <div class="col-md-3">
            <div class="text-center">
<? $arResult["arUser"]["PERSONAL_PHOTO_HTML"] = CFile::ShowImage($arResult["arUser"]["PERSONAL_PHOTO"], 200, 200, "border=0", "class='img-responsive'", true);?>
                            <?=$arResult["arUser"]["PERSONAL_PHOTO_HTML"];?>
            </div>
            <div class="list-group">
                <a href="javascript:void(0)" onclick="historyPay()" class="list-group-item">История платежей</a>
                <a href="javascript:void(0)" onclick="historyVisit()" class="list-group-item">История посещений</a>
                <a href="javascript:void(0)" onclick="feedback()" class="list-group-item">Обратная связь</a>
                <a href="javascript:void(0)" onclick="changePassword()" class="list-group-item">Сменить пароль</a>
            </div>
            <div class="list-group">
                <a href="javascript:void(0)" class="list-group-item">Выход</a>
            </div>
        </div>
        <!-- END First Column | Image and menu -->

        <!-- Second Column | Main content -->
        <div id="changePassword-content">
            <div class="col-md-6 push">
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
                <div class="form-group">
                    <div class="col-md-12">
                        <p class="form-control-static"><h3 class="page-header-top"><? echo $arResult["arUser"]["NAME"]?> <? echo $arResult["arUser"]["LAST_NAME"]?></h3></p>
                    </div>
                </div>
                    <div class="row">
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="password" name="NEW_PASSWORD" maxlength="50" placeholder="<?=GetMessage('NEW_PASSWORD_REQ')?>" value="" autocomplete="off" id="example-user-pass" class="form-control">
                    </div>
                </div>
                    </div>
                    <div class="row">
                    <div class="form-group">
                    <div class="col-md-6">
                        <input type="password" name="NEW_PASSWORD_CONFIRM" placeholder="<?=GetMessage('NEW_PASSWORD_CONFIRM')?>" maxlength="50" value="" autocomplete="off" id="example-user-newpass"
                               class="form-control">
                    </div>
                </div>
                    </div>
                    <div class="row">

                    <div class="form-group">
                    <div class="col-md-6">
                        <div class="modal-footer remove-margin">
                            <input type="submit" class="btn btn-success" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">
                        </div>
                    </div>
                </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="feedback-content">
            <div class="col-md-6 push">
                <div class="form-group">
                    <label class="control-label col-md-2" for="example-textarea-large">Письмо:</label>
                    <div class="col-md-10">
                        <textarea id="example-textarea-large" name="example-textarea-large" class="form-control" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-10 col-md-offset-2">
                        <button class="btn btn-success">Отправить</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="historyVisit-content">
            <div class="col-md-6 push">
                <div id="example-datatables2_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <table id="example-datatables2"
                           class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
                           aria-describedby="example-datatables2_info">
                        <thead>
                        <tr role="row">
                            <th class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2"
                                rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="#: activate to sort column descending" style="width: 71px;">#
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                                aria-label=" Username: activate to sort column ascending" style="width: 252px;">Дата:
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                                aria-label=" Status: activate to sort column ascending" style="width: 326px;">Статус:
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr role="row" class="odd">
                            <td class="text-center sorting_1">1</td>
                            <td>14.12.2018 16:35</td>
                            <td><span class="label label-success">Был</span></td>
                        </tr><tr role="row" class="even">
                            <td class="text-center sorting_1">2</td>
                            <td>14.12.2018 16:35</td>
                            <td><span class="label label-danger">Не был</span></td>
                        </tr><tr role="row" class="even">
                            <td class="text-center sorting_1">3</td>
                            <td>14.12.2018 16:35</td>
                            <td><span class="label label-primary">Болезнь</span></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-5 hidden-xs">
                            <div class="dataTables_info" id="example-datatables2_info" role="status" aria-live="polite">
                                <strong>1</strong>-<strong>10</strong> из <strong>30</strong></div>
                        </div>
                        <div class="col-sm-7 col-xs-12 clearfix">
                            <div class="dataTables_paginate paging_bootstrap" id="example-datatables2_paginate">
                                <ul class="pagination pagination-sm remove-margin">
                                    <li class="prev disabled"><a href="javascript:void(0)"><i
                                                    class="fa fa-chevron-left"></i> </a></li>
                                    <li class="active"><a href="javascript:void(0)">1</a></li>
                                    <li><a href="javascript:void(0)">2</a></li>
                                    <li><a href="javascript:void(0)">3</a></li>
                                    <li class="next"><a href="javascript:void(0)"> <i
                                                    class="fa fa-chevron-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div id="historyPay-content">
            <div class="col-md-6 push">

                <div id="example-datatables2_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <table id="example-datatables2"
                           class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
                           aria-describedby="example-datatables2_info">
                        <thead>
                        <tr role="row">
                            <th class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2"
                                rowspan="1" colspan="1" aria-sort="ascending"
                                aria-label="#: activate to sort column descending" style="width: 71px;">#
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                                aria-label=" Username: activate to sort column ascending" style="width: 252px;">Дата:
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                                aria-label=" Status: activate to sort column ascending" style="width: 326px;">Действие:
                            </th>
                        </tr>
                        </thead>
                            <tbody>
                            <tr role="row" class="odd">
                                <td class="text-center sorting_1">1</td>
                                <td>14.12.2018 16:35</td>
                                <td><span class="label label-default">Зачисленно через Банк 300 000 рублей</span></td>
                            </tr><tr role="row" class="even">
                                <td class="text-center sorting_1">2</td>
                                <td>14.12.2018 16:35</td>
                                <td><span class="label label-default">Зачисленно через Банк 1 рубль</span></td>
                            </tr><tr role="row" class="even">
                                <td class="text-center sorting_1">3</td>
                                <td>14.12.2018 16:35</td>
                                <td><span class="label label-default">Списано за занятие 200 000 рублей</span></td>
                            </tr><tr role="row" class="even">
                                <td class="text-center sorting_1">4</td>
                                <td>4.12.2018 16:35</td>
                                <td><span class="label label-default">Зачисленно через кассира</span></td>
                            </tr>
                           </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-5 hidden-xs">
                            <div class="dataTables_info" id="example-datatables2_info" role="status" aria-live="polite">
                                <strong>1</strong>-<strong>10</strong> из <strong>30</strong></div>
                        </div>
                        <div class="col-sm-7 col-xs-12 clearfix">
                            <div class="dataTables_paginate paging_bootstrap" id="example-datatables2_paginate">
                                <ul class="pagination pagination-sm remove-margin">
                                    <li class="prev disabled"><a href="javascript:void(0)"><i
                                                    class="fa fa-chevron-left"></i> </a></li>
                                    <li class="active"><a href="javascript:void(0)">1</a></li>
                                    <li><a href="javascript:void(0)">2</a></li>
                                    <li><a href="javascript:void(0)">3</a></li>
                                    <li class="next"><a href="javascript:void(0)"> <i
                                                    class="fa fa-chevron-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        <div id="main-content">
        <div class="col-md-3 text-center">

                    <div class="dash-tile dash-tile-ocean clearfix animation-pullDown">
                        <div class="dash-tile-header">
                            <div class="dash-tile-options">
                                <div class="btn-group">
                                </div>
                            </div>
                            Ближайшее занятие
                        </div>
                        <div class="dash-tile-icon"></div>
                        <br>
                        <br>
                        <div class=""><span class="label label-primary">Kids Box 23</span> <p><h4 class="text-active">Четверг 23.12 13:00-13:45</h4></p></div>

                    </div>
                    <!-- END Total Users Tile -->
            <div class="dash-tile dash-tile-balloon clearfix animation-pullDown">
                <div class="dash-tile-header">
                    <div class="dash-tile-options">
                    </div>
                    Отработка
                </div>
                <div class="dash-tile-icon"></div>
                <br>
                <br>
                <div class=""><span class="label label-primary">Kids Box 23</span> <p><h4 class="text-active">Четверг 23.12 13:00-13:45</h4></p></div>
            </div>




        </div>
        <div class="col-md-3 text-center">
            <!-- Total Profit Tile -->
            <div class="dash-tile dash-tile-leaf clearfix animation-pullDown">
                <div class="dash-tile-header">
                                    <span class="dash-tile-options">
                                    </span>
                    Баланс:
                </div>
                <div class="dash-tile-icon"><i class="fa fa-money"></i></div>
                <div class="dash-tile-text">800 рублей</div>
            </div>
            <!-- END Total Profit Tile -->
            <!-- END Column 1 of Row 1 -->


        </div>
        </div>
        <!-- END Second Column | Main content -->

        <!-- Third Column | Right Sidebar -->
        <div class="col-md-3">
            <h5 class="page-header-sub">Оплата:</h5>
            <div class="input-group">
                <input type="number" id="example-input-append-btn2" name="example-input-append-btn2" class="form-control" placeholder="Сумма">
                <span class="input-group-btn">
                                            <button class="btn btn-success">Пополнить</button>
                                        </span>
            </div>            <h5 class="page-header-sub"><i class="fa fa-certificate"></i> Занятия</h5>
            <table class="table table-borderless">
                <tbody>
                <tr>
                    <td class="cell-small"><span class="label label-primary">Kids Box 1</span></td>
                    <td>
                        Четверг(1.12) 18:30-19:20
                    </td>
                </tr>
                <tr>
                    <td class="cell-small"><span class="label label-success">Kids Box 2</span></td>
                    <td>
                        Четверг(15.12) 17:30-19:20
                    </td>
                </tr>
                </tbody>
            </table>
            <h5 class="page-header-sub"><i class="fa fa-certificate"></i> Отработки</h5>
            <table class="table table-borderless">
                <tbody>
                <tr>
                    <td class="cell-small"><span class="label label-primary">Kids Box 1</span></td>
                    <td>
                        Четверг(1.12) 18:30-19:20
                    </td>
                </tr>
                <tr>
                    <td class="cell-small"><span class="label label-success">Kids Box 2</span></td>
                    <td>
                        Четверг(15.12) 17:30-19:20
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="text-center">
            <h4><i class="fa fa-book"></i> Телефон</h4>
            <address>
                <?=$arResult["arUser"]["PERSONAL_PHONE"]?><br>
            </address>
            <h4><i class="fa fa-book"></i> Адрес</h4>
            <address>
                Город: <?=$arResult["arUser"]["PERSONAL_CITY"]?><br>
                Адрес: <?=$arResult["arUser"]["PERSONAL_STREET"]?><br>
            </address>
            </div>
        </div>
        <!-- END Third Column | Right Sidebar -->
    </div>
    <!-- END Profile -->


<script>
    function closeAllContent(){
        $('#feedback-content').hide();
        $('#historyVisit-content').hide();
        $('#historyPay-content').hide();
        $('#main-content').hide();
        $('#changePassword-content').hide();


    }
    $('#changePassword-content').hide();
    $('#feedback-content').hide();
    $('#historyVisit-content').hide();
    $('#historyPay-content').hide();
    function historyPay() {
        closeAllContent()
        $('#historyPay-content').show();
}
function historyVisit() {
    closeAllContent()
    $('#historyVisit-content').show();
}
    function feedback() {
        closeAllContent()
        $('#feedback-content').show();
    }
    function changePassword() {
        closeAllContent()
        $('#changePassword-content').show();
    }
</script>
