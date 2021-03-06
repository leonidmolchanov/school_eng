<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
CJSCore::Init(array("fx"));
require($_SERVER["DOCUMENT_ROOT"]."/local/include/school_id.php");
use Bitrix\Main\Page\Asset;
global $USER;
// Определение групп пользователей
$isAdmin=1;
$isMethodist=9;
$isTeacher=8;
$isStudent=7;
$isFranch=17;
$privilege=0;
$isAdminPortal = 16;

$check=false;
$arGroups = $USER->GetUserGroupArray();
foreach ($arGroups as $state){
    if($state==$isAdmin || $state==$isAdminPortal){
        $check=true;
break;
    }
}
$block=1;
$schoolName="";
if(!$check){

    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'SCHOOL',
                'ID'=>$schoolID),
            false,
            false,
            Array('ID',
                'PROPERTY_BLOCK')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            $block=$ar_fields['PROPERTY_BLOCK_VALUE'];
            $schoolName = $ar_fields['NAME'];
        }
    endif;
        if($block==1) {
            header('Location: /block.php');
        }

}
else{
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'SCHOOL',
                'ID'=>$schoolID),
            false,
            false,
            Array('ID', 'NAME')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            $schoolName = $ar_fields['NAME'];
        }
    endif;
}
    ?>

<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>

        <title><?$APPLICATION->ShowTitle()?></title>
        <?$APPLICATION->ShowHead();?>

        <meta name="viewport" content="width=device-width,initial-scale=1">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/img/favicon.ico">
        <link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/img/icon152.png" sizes="152x152">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/bootstrap.css");?>
        <!-- Related styles of various javascript plugins -->
        <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/plugins.css");?>
        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/main.css");?>
        <!-- Load a specific file here from css/themes/ folder to alter the default theme of the template -->
        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/themes.css");?>
        <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/sweetalert2.css");?>

        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support it, eg IE8) -->
        <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/vendor/modernizr-respond.min.js" );?>
        <script>

            document.addEventListener("DOMContentLoaded", function(event) {
                window.AudioContext = window.AudioContext || window.webkitAudioContext;

                function play(snd) {
                    console.log(snd)
                    var audioCtx = new AudioContext();

                    var request = new XMLHttpRequest();
                    request.open("GET", snd, true);
                    request.responseType = "arraybuffer";
                    request.onload = function () {
                        var audioData = request.response;

                        audioCtx.decodeAudioData(
                            audioData,
                            function (buffer) {
                                var smp = audioCtx.createBufferSource();
                                smp.buffer = buffer;
                                smp.connect(audioCtx.destination);
                                smp.start(0);
                            },
                            function (e) {
                                alert("Error with decoding audio data" + e.err);
                            }
                        );
                    };
                    request.send();
                }

                document.querySelector('button').addEventListener('click', function () {
                    context.resume().then(() => {
                        console.log('Playback resumed successfully');
                    });
                });

                BX.addCustomEvent("onPullEvent", BX.delegate(function (module_id, command, params) {
                    if(module_id!=='message') {
                        console.log(module_id, command, params);
                        if(module_id=='journal'){
                            url = 'https://erperp.ru/<?=SITE_TEMPLATE_PATH?>/sound/journal.mp3';

                        }
                       else if(module_id=='pay'){
                            url = 'https://erperp.ru/<?=SITE_TEMPLATE_PATH?>/sound/pay.mp3';

                        }
                        else{
                            url = 'https://erperp.ru/<?=SITE_TEMPLATE_PATH?>/sound/message.mp3';

                        }
                        play(url)
                        Swal(
                            command,
                            params[0],
                            'success'
                        )
                    }
                }, this))
            });
        </script>
    </head>

    <!-- Add the class .fixed to <body> for a fixed layout on large resolutions (min: 1200px) -->
    <!-- <body class="fixed"> -->
    <body>
<?$APPLICATION->ShowPanel()?>
        <!-- Page Container -->
        <div id="page-container">
            <!-- Header -->
            <!-- Add the class .navbar-fixed-top or .navbar-fixed-bottom for a fixed header on top or bottom respectively -->
            <!-- <header class="navbar navbar-inverse navbar-fixed-top"> -->
            <!-- <header class="navbar navbar-inverse navbar-fixed-bottom"> -->
            <header class="navbar navbar-inverse">
                <!-- Mobile Navigation, Shows up  on smaller screens -->
                <ul class="navbar-nav-custom pull-right hidden-md hidden-lg">
                    <li class="divider-vertical"></li>
                    <li>
                        <!-- It is set to open and close the main navigation on smaller screens. The class .navbar-main-collapse was added to aside#page-sidebar -->
                        <a href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-main-collapse">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                </ul>
                <!-- END Mobile Navigation -->

                <!-- Logo -->
                <a href="/" class="navbar-brand"><img src="<?=SITE_TEMPLATE_PATH?>/img/template/logo.png" alt="logo"></a>

                <!-- Loading Indicator, Used for demostrating how loading of widgets could happen, check main.js - uiDemo() -->
                <div id="loading" class="pull-left"><i class="fa fa-certificate fa-spin"></i></div>
                <div class="row">

                    <div class="col-md-10">
                <!-- Header Widgets -->
<div class="text-center">                        <span class="label text-center" style="padding-top: 10px;"><?=$schoolName?></span>
</div>
                    </div>

                    <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth_mini", Array(

                    ),
                        false
                    );?>
                </div>

                <!-- END Header Widgets -->
            </header>
            <!-- END Header -->

            <!-- Inner Container -->
            <div id="inner-container">
                <!-- Sidebar -->
                <aside id="page-sidebar" class="collapse navbar-collapse navbar-main-collapse">
                    <!-- Sidebar search -->
                    <form id="sidebar-search" action="/search/" method="get">
                        <div class="input-group">
                            <input type="hidden"  name="tags" value="">
                            <input type="hidden"  name="how" value="r">
                            <input type="text" id="sidebar-search-term" name="q" placeholder="<?=GetMessage('search');?>">
                            <button><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                    <!-- END Sidebar search -->
<?if ($USER->IsAuthorized()):?>
                    <!-- Primary Navigation -->
                    <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"vertical_menu", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "vertical_menu"
	),
	false
);?>
     <!-- END Primary Navigation -->
<?else:?>
<script>window.location.replace('/login.php');</script>
<?endif;?>
                </aside>
                <!-- END Sidebar -->

                <!-- Page Content -->
                <div id="page-content">
<?
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();
global $schoolFilter;
$schoolFilter =  array( "PROPERTY_SCHOOL_ID_VALUE"=>1);
$schoolID =  $arUser['UF_SCHOOL_ID'];
?>
    <!-- Navigation info -->
<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "navigate", Array(
    "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
    "SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
    "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
),
    false
);?>
                    <!-- END Navigation info -->

                    <!-- Nav Dash -->
                    <?if ($USER->IsAuthorized()):?>

                    <?//$APPLICATION->IncludeComponent("bitrix:menu", "top_menu", Array(
//                        "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
//                        "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
//                        "DELAY" => "N",	// Откладывать выполнение шаблона меню
//                        "MAX_LEVEL" => "1",	// Уровень вложенности меню
//                        "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
//                            0 => "",
//                        ),
//                        "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
//                        "MENU_CACHE_TYPE" => "N",	// Тип кеширования
//                        "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
//                        "ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
//                        "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
//                    ),
//                        false
//                    );?>
                    <!-- END Nav Dash -->
                    <?endif;?>