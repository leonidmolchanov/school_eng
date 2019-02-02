<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
// Определение групп пользователей
$isAdmin=1;
$isMethodist=9;
$isTeacher=8;
$isStudent=7;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
global $USER;
$privilege=0;
$arGroups = $USER->GetUserGroupArray();
foreach ($arGroups as $state){
    if($state==$isAdmin){
        $privilege=1;
    }
    else if($state==$isMethodist){
        $privilege=2;
    }
    else if($state==$isTeacher){
        $privilege=3;
    }
    else if($state==$isStudent){
        $privilege=4;
    }
}
    ?>
    <!-- Profile -->
    <h3 class="page-header page-header-top"><i class="fa fa-user"></i> <?=$arResult["arUser"]["NAME"]?> <?=$arResult["arUser"]["SECOND_NAME"]?> <?=$arResult["arUser"]["LAST_NAME"]?>  <small><?=$arResult["arUser"]["LOGIN"]?></small></h3>
<?if($privilege===1){?>
Вы администратор
<? }
else if($privilege===2){?>
Вы методист
<?} else if($privilege===3){?>
Вы учитель
<?}
else if($privilege===4){?>
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
<!--            <div class="dash-tile dash-tile-leaf clearfix animation-pullDown">-->
<!--                <div class="dash-tile-header">-->
<!--                                    <span class="dash-tile-options">-->
<!--                                    </span>-->
<!--                    Скидки                   </div>-->
<!--                -->
<!--            </div>-->
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
                        <input type="password" name="NEW_PASSWORD" maxlength="50" placeholder="<?=GetMessage('NEW_PASSWORD_REQ')?>" value="" autocomplete="off" id="user-pass" class="form-control">
                    </div>
                </div>
                    </div>
                    <div class="row">
                    <div class="form-group">
                    <div class="col-md-6">
                        <input type="password" name="NEW_PASSWORD_CONFIRM" placeholder="<?=GetMessage('NEW_PASSWORD_CONFIRM')?>" maxlength="50" value="" autocomplete="off" id="user-newpass"
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

                <div id="example-datatables2_wrapper" class="">
                    <table id="profile-transaction"
                           class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
                           aria-describedby="example-datatables3_info">
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
                                aria-label=" Status: activate to sort column ascending" style="width: 326px;">Описание:
                            </th>
                        </tr>
                        </thead>
                            <tbody>
                            <?
                            CModule::IncludeModule("sale");
$res = CSaleUserTransact::GetList(Array("ID" => "DESC"), array("USER_ID" => $USER->GetID()));
while ($arFields = $res->Fetch())
{?>
    <tr role="row" class="odd">
        <td class="text-center sorting_1"><?=$arFields["ID"]?></td>
        <td><?=$arFields["TRANSACT_DATE"]?></td>
        <td><span class="label <?=($arFields["DEBIT"]=="Y")?"label-success":"label-primary"?>"><?=($arFields["DEBIT"]=="Y")?"+":"-"?><?=SaleFormatCurrency($arFields["AMOUNT"], $arFields["CURRENCY"])?>(<?=($arFields["DEBIT"]=="Y")?"на счет":"со счета"?>)<br /><small>  <?=$arFields["NOTES"]?></small></span></td>
    </tr>
<?}?>
                           </tbody>
                    </table>

                </div>
            </div>
            </div>
        <div id="main-content">
        <div class="col-md-3 text-center">
            <div id="first-study">

            </div>
                    <!-- END Total Users Tile -->
<!--            <div class="dash-tile dash-tile-balloon clearfix animation-pullDown">-->
<!--                <div class="dash-tile-header">-->
<!--                    <div class="dash-tile-options">-->
<!--                    </div>-->
<!--                    Отработка-->
<!--                </div>-->
<!--                <div class="dash-tile-icon"></div>-->
<!--                <br>-->
<!--                <br>-->
<!--                <div class=""><span class="label label-primary">Kids Box 23</span> <p><h4 class="text-active">Четверг 23.12 13:00-13:45</h4></p></div>-->
<!--            </div>-->




        </div>
            <?$APPLICATION->IncludeComponent("bitrix:sale.personal.account", "sale.count", Array(
                "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
            ),
                false
            );?>
        </div>
        </div>
        <!-- END Second Column | Main content -->


        <div class="col-md-3 text-center">
            <h5 class="page-header-sub">Оплата:</h5>
            <div class="input-group">
                <input type="number" id="example-input-append-btn2" name="example-input-append-btn2" class="form-control" placeholder="Сумма">
                <span class="input-group-btn">
                                            <button class="btn btn-success">Пополнить</button>
                                        </span>
            </div>


            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.element",
                ".default",
                array(
                    "ACTION_VARIABLE" => "action",
                    "ADD_DETAIL_TO_SLIDER" => "N",
                    "ADD_ELEMENT_CHAIN" => "N",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "ADD_TO_BASKET_ACTION" => array(
                        0 => "BUY",
                    ),
                    "ADD_TO_BASKET_ACTION_PRIMARY" => array(
                        0 => "BUY",
                    ),
                    "BACKGROUND_IMAGE" => "-",
                    "BASKET_URL" => "/profile/order.php",
                    "BRAND_USE" => "N",
                    "BROWSER_TITLE" => "-",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "N",
                    "CHECK_SECTION_ID_VARIABLE" => "N",
                    "COMPATIBLE_MODE" => "Y",
                    "CONVERT_CURRENCY" => "N",
                    "DETAIL_PICTURE_MODE" => array(
                        0 => "POPUP",
                        1 => "MAGNIFIER",
                    ),
                    "DETAIL_URL" => "",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                    "DISPLAY_COMPARE" => "N",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PREVIEW_TEXT_MODE" => "E",
                    "ELEMENT_CODE" => "lesson",
                    "ELEMENT_ID" => "29",
                    "GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
                    "GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
                    "GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "4",
                    "GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
                    "GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
                    "GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
                    "GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",
                    "GIFTS_MESS_BTN_BUY" => "Выбрать",
                    "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
                    "GIFTS_SHOW_IMAGE" => "Y",
                    "GIFTS_SHOW_NAME" => "Y",
                    "GIFTS_SHOW_OLD_PRICE" => "Y",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "IBLOCK_ID" => "3",
                    "IBLOCK_TYPE" => "products",
                    "IMAGE_RESOLUTION" => "16by9",
                    "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
                    "LINK_IBLOCK_ID" => "",
                    "LINK_IBLOCK_TYPE" => "",
                    "LINK_PROPERTY_SID" => "",
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_COMMENTS_TAB" => "Комментарии",
                    "MESS_DESCRIPTION_TAB" => "Описание",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "MESS_PRICE_RANGES_TITLE" => "Цены",
                    "MESS_PROPERTIES_TAB" => "Характеристики",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_LIMIT" => "0",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array(
                        0 => "lesson",
                    ),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRICE_VAT_SHOW_VALUE" => "N",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
                    "PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "PRODUCT_SUBSCRIPTION" => "Y",
                    "SECTION_CODE" => "",
                    "SECTION_ID" => $_REQUEST["SECTION_ID"],
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_URL" => "",
                    "SEF_MODE" => "N",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_CANONICAL_URL" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "Y",
                    "SET_VIEWED_IN_COMPONENT" => "N",
                    "SHOW_404" => "N",
                    "SHOW_CLOSE_POPUP" => "N",
                    "SHOW_DEACTIVATED" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "N",
                    "STRICT_SECTION_CHECK" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_COMMENTS" => "N",
                    "USE_ELEMENT_COUNTER" => "Y",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_GIFTS_DETAIL" => "Y",
                    "USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "Y",
                    "USE_PRODUCT_QUANTITY" => "Y",
                    "USE_RATIO_IN_RANGES" => "N",
                    "USE_VOTE_RATING" => "N",
                    "COMPONENT_TEMPLATE" => ".default",
                    "ADD_PICT_PROP" => "-",
                    "LABEL_PROP" => array(
                    )
                ),
                false
            );?>

            <h5 class="page-header-sub"><i class="fa fa-certificate"></i> Занятия</h5>
            <table class="table table-borderless" id="study-list-table">
                <tbody>
                </tbody>
            </table>
            <h5 class="page-header-sub"><i class="fa fa-certificate"></i> Отработки</h5>
            <table class="table table-borderless">
                <tbody>
                </tbody>
            </table>
            <div class="text-center">
            <h4><i class="fa fa-book"></i>Контакты</h4>
            <address>
                <div id="father-contact"></div>
                <div id="mother-contact"></div>
                <div id="student-contact"></div>
            </address>
            </div>
        </div>
        <!-- END Third Column | Right Sidebar -->
    </div>

    <!-- END Profile -->
<?}
else{?>
Ваш статус не определен
<?}?>

<script>
    window.AudioContext = window.AudioContext || window.webkitAudioContext;

    function play( snd ) {
        console.log(snd)
        var audioCtx = new AudioContext();

        var request = new XMLHttpRequest();
        request.open( "GET", snd, true );
        request.responseType = "arraybuffer";
        request.onload = function () {
            var audioData = request.response;

            audioCtx.decodeAudioData(
                audioData,
                function ( buffer ) {
                    var smp = audioCtx.createBufferSource();
                    smp.buffer = buffer;
                    smp.connect( audioCtx.destination );
                    smp.start( 0 );
                },
                function ( e ) {
                    alert( "Error with decoding audio data" + e.err );
                }
            );
        };
        request.send();
    }
    document.querySelector('button').addEventListener('click', function() {
        context.resume().then(() => {
            console.log('Playback resumed successfully');
        });
    });
</script>
<script>


    function ajaxRequest() {

        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'getProfileInfo'
            },
            method: 'POST',
            dataType: 'json',
            timeout: 30,
            async: true,
            processData: true,
            scriptsRunFirst: true,
            emulateOnload: true,
            start: true,
            cache: false,
            onsuccess: function (data) {
                console.log(data)
                if(data.STUDENT){
                    $('#father-contact').append('Отец : '+data.STUDENT['PROPERTY_FATHER_LAST_NAME_VALUE']+' '+data.STUDENT['PROPERTY_FATHER_NAME_VALUE']+' '+data.STUDENT['PROPERTY_FATHER_SECOND_NAME_VALUE']+' <br>'+data.STUDENT['PROPERTY_FATHER_TEL_VALUE']+'<br>')
                    $('#mother-contact').append('Мать : '+data.STUDENT['PROPERTY_MOTHER_LAST_NAME_VALUE']+' '+data.STUDENT['PROPERTY_MOTHER_NAME_VALUE']+' '+data.STUDENT['PROPERTY_MOTHER_SECOND_NAME_VALUE']+' <br>'+data.STUDENT['PROPERTY_MOTHER_TEL_VALUE']+'<br>')
                    $('#student-contact').append('Личный номер : '+data.STUDENT['PROPERTY_TEL_VALUE'])
                }
                if(data.STUDY.length!==0){

                    data.STUDY.map(function (item) {
                        dateFrom=item['PROPERTY_FROM_VALUE'].split(' ');
                        dateTo=item['PROPERTY_TO_VALUE'].split(' ');
                        $('#study-list-table').append('<tr>\n' +
                            '                    <td class="cell-small"><span class="label" style="background:'+item['COLOR']+'">Kids Box 1</span></td>\n' +
                            '                    <td>\n' +
                            '                        '+item['DAY']+'('+dateFrom[0]+') '+dateFrom[1]+'-'+dateTo[1]+'\n' +
                            '                    </td>\n' +
                            '                </tr>')
                    })

                    dateFrom=data.STUDY[0]['PROPERTY_FROM_VALUE'].split(' ');
                    dateTo=data.STUDY[0]['PROPERTY_TO_VALUE'].split(' ');
                    $('#first-study').append('<div class="dash-tile dash-tile-ocean clearfix animation-pullDown">\n' +
                    '                <div class="dash-tile-header">\n' +
                    '                    <div class="dash-tile-options">\n' +
                    '                        <div class="btn-group">\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                    Ближайшее занятие\n' +
                    '                </div>\n' +
                    '                <div class="dash-tile-icon"></div>\n' +
                    '                <br>\n' +
                    '                <br>\n' +
                    '                <div class=""><span class="label" style="background:'+data.STUDY[0]['COLOR']+'">'+data.GROUP[0]['NAME']+'</span>\n' +
                    '                    <p><h4 class="text-active">'+data.STUDY[0]['DAY']+' '+dateFrom[0]+' '+dateFrom[1]+'-'+dateTo[1]+'</h4></p></div>\n' +
                        '                <p><h4 class="text-active">'+data.STUDY[0]['TEACHER']['PROPERTY_NAME_VALUE']+' '+data.STUDY[0]['TEACHER']['PROPERTY_LAST_NAME_VALUE']+'</h4></p></div>\n' +
                        '            </div>')
            }

            }
        });

    }
    ajaxRequest();


    console.log('<?=$arResult["ID"]?>')
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
        $('#historyPay-content').show()
        $('#historyPay-content').show().ready(readyFn)

        function readyFn(){
            $(function () {
                /* Initialize Datatables */
                $('#profile-transaction').dataTable();
                $('.dataTables_filter input').attr('placeholder', 'Поиск');
            });
        }

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



    BX.addCustomEvent("onPullEvent", BX.delegate(function(module_id,command,params){
        console.log(module_id, command, params);
        url = 'https://erperp.ru/<?=SITE_TEMPLATE_PATH?>/js/message.mp3';
        play(url)
        Swal(
            command,
            params[0],
            'success'
        )
    }, this))


</script>
