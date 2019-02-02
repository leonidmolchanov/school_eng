<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
use Bitrix\Main\Page\Asset;

?>
<!-- END Tiles -->
</div>
<!-- END Page Content -->

<!-- Footer -->
<footer>
    <span id="year-copy"></span> &copy; <strong><a href="#">English School</a></strong> - Crafted  by <strong><a href="http://leonidmolchanov.com" target="_blank">leonidmolchanov</a></strong>
</footer>
<!-- END Footer -->
</div>
<!-- END Inner Container -->
</div>
<!-- END Page Container -->

<!--&lt;!&ndash; Scroll to top link, check main.js - scrollToTop() &ndash;&gt;-->
<a href="javascript:void(0)" id="to-top"><i class="fa fa-chevron-up"></i></a>

<?$APPLICATION->IncludeComponent("bitrix:main.profile", "profile_popup", Array(
    "CHECK_RIGHTS" => "N",	// Проверять права доступа
    "SEND_INFO" => "N",	// Генерировать почтовое событие
    "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
    "USER_PROPERTY" => "",	// Показывать доп. свойства
    "USER_PROPERTY_NAME" => "",	// Название закладки с доп. свойствами
),
    false
);?>



<!-- Excanvas for canvas support on IE8 -->
<script src="<?=SITE_TEMPLATE_PATH?>/js/helpers/excanvas.min.js"></script><![endif]-->
<!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL) -->
<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.min.js"></script>
<script>!window.jQuery && document.write(decodeURI('%3Cscript src="<?=SITE_TEMPLATE_PATH?>/js/vendor/jquery-1.11.1.min.js"%3E%3C/script%3E'));</script>

<!-- Bootstrap.js -->
<script src="<?=SITE_TEMPLATE_PATH?>/js/vendor/bootstrap.min.js"></script>

<!-- Jquery plugins and custom javascript code -->
<script src="<?=SITE_TEMPLATE_PATH?>/js/plugins.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/main.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/ion.sound.min.js"></script>

<script src="<?=SITE_TEMPLATE_PATH?>/js/sweetalert2.all.min.js"></script>
<!--<script src="--><?//=SITE_TEMPLATE_PATH?><!--/js/moment-with-locales.min.js"></script>-->
<!-- Javascript code only for this page -->
</body>
</html>