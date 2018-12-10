<?
ob_start(); //стартуем буферизацию
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
ob_end_clean(); //очищаем буфер
ob_end_flush(); //закрываем его
//Далее код использующий функционал Битрикс
global $USER;
use Bitrix\Main\Page\Asset;
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
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/bootstrap.css">

    <!-- Related styles of various javascript plugins -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/plugins.css">

    <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/main.css">
    <!-- END Stylesheets -->

    <!-- Modernizr (browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support it, eg IE8) -->
    <script src="<?=SITE_TEMPLATE_PATH?>/js/vendor/modernizr-respond.min.js"></script>
</head>
<body class="login">
<!-- Login Container -->
<div id="login-container">


    <div id="login-logo">
        <a href="">
            <img src="<?=SITE_TEMPLATE_PATH?>/img/template/uadmin_logo.png" alt="logo">
        </a>
    </div>
    <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "global_auth", Array(

    ),
        false
    );?>

</div>
<!-- END Login Container -->

<!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL) -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>!window.jQuery && document.write(decodeURI('%3Cscript src="<?=SITE_TEMPLATE_PATH?>/js/vendor/jquery-1.11.1.min.js"%3E%3C/script%3E'));</script>

<!-- Bootstrap.js -->
<script src="<?=SITE_TEMPLATE_PATH?>/js/vendor/bootstrap.min.js"></script>

<!-- Jquery plugins and custom javascript code -->
<script src="<?=SITE_TEMPLATE_PATH?>/js/plugins.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/main.js"></script>

<!-- Javascript code only for this page -->
<script>
    $(function () {
        var loginButtons = $('#login-buttons');
        var loginForm = $('#login-form');

        // Reveal login form
        $('#login-btn-email').click(function () {
            loginButtons.slideUp(600);
            loginForm.slideDown(450);
        });

        // Hide login form
        $('.login-back').click(function () {
            loginForm.slideUp(450);
            loginButtons.slideDown(600);
        });
    });
</script>
</body>
</html>