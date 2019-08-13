<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Создание учителей");
?>
<div id="content">
    <form action="page_form_components.html" method="post" class="form-horizontal form-box" onsubmit="return false;">
        <h4 class="form-box-header">Создание сотрудника</h4><div id="debug"></div>
        <div class="form-box-content">
            <!-- Colorpicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://www.eyecon.ro/bootstrap-colorpicker/ -->
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Тип: </label>
                <div class="col-md-8">
                    <label>
                        <select name="example-datatables2_length" id="worker-type" class="form-control">
                            <option selected="" value="createTeacher">Учитель</option>
                            <option  value="createMethodist">Методист</option>
                            <option  value="createAdministrator">Администратор</option>
                        </select></label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Логин: </label>
                <div class="col-md-2">
                    <input type="text" id="worker-login" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">email: </label>
                <div class="col-md-2">
                    <input type="text" id="worker-email" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Имя: </label>
                <div class="col-md-2">
                    <input type="text" id="worker-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Отчество: </label>
                <div class="col-md-2">
                    <input type="text" id="worker-second-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Фамилия: </label>
                <div class="col-md-2">
                    <input type="text" id="worker-last-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Дата рождения: </label>
                <div class="col-md-2">
                    <input type="date" id="worker-birth" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Номер телефона: </label>
                <div class="col-md-2">
                    <input type="text" id="worker-tel" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Пароль: </label>
                <div class="col-md-2">

                    <input type="password" id="worker-password" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Подтверждение пароля: </label>
                <div class="col-md-2">
                    <input type="password" id="worker-password-confirm" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-md-10 col-md-offset-2">
                    <button class="btn btn-success" onclick="createWorker()"><i class="fa fa-floppy-o"></i>Создать</button>
                </div>
            </div>
        </div>
    </form>
</div>

    <script>
        function createWorker() {
            console.log($("#worker-type").val())
            if($("#worker-login").val()  && $("#worker-name").val()  && $("#worker-last-name").val() && $("#worker-birth").val() && $("#worker-password").val() && $("#worker-password-confirm").val()) {
                if($("#worker-password-confirm").val()==$("#worker-password").val()) {
                    console.log('ok')

                    BX.ajax({
                        url: '/api.php',
                        data: {
                            sessid: BX.bitrix_sessid(),
                            type: $("#worker-type").val(),
                            login: $("#worker-login").val(),
                            name: $("#worker-name").val(),
                            email: $("#worker-email").val(),
                            secondName: $("#worker-second-name").val(),
                            lastName: $("#worker-last-name").val(),
                            birth: $("#worker-birth").val(),
                            tel: $("#worker-tel").val(),
                            password: $("#worker-password").val(),
                            passwordConfirm: $("#worker-password-confirm").val()

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
                                    '            <div class="dash-tile-text text-center">Сотрудник успешно создан!</div>\n' +
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