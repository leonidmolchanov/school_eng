<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Создание учителей");
?>
<div id="content">
    <form action="page_form_components.html" method="post" class="form-horizontal form-box" onsubmit="return false;">
        <h4 class="form-box-header">Создание франчайзи</h4><div id="debug"></div>
        <div class="form-box-content">
            <!-- Colorpicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://www.eyecon.ro/bootstrap-colorpicker/ -->
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Логин: </label>
                <div class="col-md-2">
                    <input type="text" id="teacher-login" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">email: </label>
                <div class="col-md-2">
                    <input type="text" id="teacher-email" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Имя: </label>
                <div class="col-md-2">
                    <input type="text" id="teacher-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Отчество: </label>
                <div class="col-md-2">
                    <input type="text" id="teacher-second-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Фамилия: </label>
                <div class="col-md-2">
                    <input type="text" id="teacher-last-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Дата рождения: </label>
                <div class="col-md-2">
                    <input type="date" id="teacher-birth" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Номер телефона: </label>
                <div class="col-md-2">
                    <input type="text" id="teacher-tel" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Пароль: </label>
                <div class="col-md-2">

                    <input type="password" id="teacher-password" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Подтверждение пароля: </label>
                <div class="col-md-2">
                    <input type="password" id="teacher-password-confirm" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-md-10 col-md-offset-2">
                    <button class="btn btn-success" onclick="createTeacher()"><i class="fa fa-floppy-o"></i>Создать</button>
                </div>
            </div>
        </div>
    </form>
</div>

    <script>
        function createTeacher() {
            if($("#teacher-login").val()  && $("#teacher-name").val()  && $("#teacher-last-name").val() && $("#teacher-birth").val() && $("#teacher-password").val() && $("#teacher-password-confirm").val()) {
                if($("#teacher-password-confirm").val()==$("#teacher-password").val()) {
                    console.log('ok')

                    BX.ajax({
                        url: '/api.php',
                        data: {
                            sessid: BX.bitrix_sessid(),
                            type: 'createFranchisee',
                            login: $("#teacher-login").val(),
                            name: $("#teacher-name").val(),
                            email: $("#teacher-email").val(),
                            secondName: $("#teacher-second-name").val(),
                            lastName: $("#teacher-last-name").val(),
                            birth: $("#teacher-birth").val(),
                            tel: $("#teacher-tel").val(),
                            password: $("#teacher-password").val(),
                            passwordConfirm: $("#teacher-password-confirm").val()

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
                                    '            <div class="dash-tile-text text-center">Франчайзи успешно создан!</div>\n' +
                                    '        </div>\n')
                            }
                            else{
                                $('#debug').html(data);
                            }

                        },
                        onfailure: function () {
                            console.log("error");

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