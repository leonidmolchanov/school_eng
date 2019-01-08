<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Создание методистов");
?>
    <div id="content">
    <form action="page_form_components.html" method="post" class="form-horizontal form-box" onsubmit="return false;">
        <h4 class="form-box-header">Создание методистов</h4><div id="debug"></div>
        <div class="form-box-content">
            <!-- Colorpicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://www.eyecon.ro/bootstrap-colorpicker/ -->
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Логин: </label>
                <div class="col-md-2">
                    <input type="text" id="methodist-login" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">email: </label>
                <div class="col-md-2">
                    <input type="text" id="methodist-email" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Имя: </label>
                <div class="col-md-2">
                    <input type="text" id="methodist-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Отчество: </label>
                <div class="col-md-2">
                    <input type="text" id="methodist-second-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Фамилия: </label>
                <div class="col-md-2">
                    <input type="text" id="methodist-last-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Дата рождения: </label>
                <div class="col-md-2">
                    <input type="date" id="methodist-birth" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Номер телефона: </label>
                <div class="col-md-2">
                    <input type="text" id="methodist-tel" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Пароль: </label>
                <div class="col-md-2">

                    <input type="password" id="methodist-password" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Подтверждение пароля: </label>
                <div class="col-md-2">
                    <input type="password" id="methodist-password-confirm" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-md-10 col-md-offset-2">
                    <button class="btn btn-success" onclick="createMethodist()"><i class="fa fa-floppy-o"></i>Создать</button>
                </div>
            </div>
        </div>
    </form>
</div>

    <script>
        function createMethodist() {
            if($("#methodist-login").val()  && $("#methodist-name").val()  && $("#methodist-last-name").val() && $("#methodist-birth").val() && $("#methodist-password").val() && $("#methodist-password-confirm").val()) {
                if($("#methodist-password-confirm").val()==$("#methodist-password").val()) {
                    console.log('ok')

                    BX.ajax({
                        url: '/api.php',
                        data: {
                            sessid: BX.bitrix_sessid(),
                            type: 'createMethodist',
                            login: $("#methodist-login").val(),
                            name: $("#methodist-name").val(),
                            email: $("#methodist-email").val(),
                            secondName: $("#methodist-second-name").val(),
                            lastName: $("#methodist-last-name").val(),
                            birth: $("#methodist-birth").val(),
                            tel: $("#methodist-tel").val(),
                            password: $("#methodist-password").val(),
                            passwordConfirm: $("#methodist-password-confirm").val()

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
                            if(data=='success'){
                                $('#content').html('<div class="dash-tile dash-tile-ocean clearfix animation-pullDown">\n' +
                                    '            <div class="dash-tile-header">\n' +
                                    '                <div class="dash-tile-options">\n' +
                                    '                    <div class="btn-group">\n' +
                                    '                    </div>\n' +
                                    '                </div>\n' +
                                    '            </div>\n' +
                                    '\n' +
                                    '            <div class="dash-tile-text text-center">Методист успешно создан!</div>\n' +
                                    '        </div>\n')
                            }
                            else{
                                $('#debug').html(data);
                            }

                        }
                    });

                }
                else{
                    alert("Пароли не совпадают!")
                }
            }

            else{
                alert("Не заполнена фома!")
            }
        }
    </script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>