<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Создание студентов");
?>
<div id="content">
    <form action="page_form_components.html" method="post" class="form-horizontal form-box" onsubmit="return false;">
        <h4 class="form-box-header">Создание студентов</h4><div id="debug"></div>
        <div class="form-box-content">
            <!-- Colorpicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://www.eyecon.ro/bootstrap-colorpicker/ -->
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Номер договора: </label>
                <div class="col-md-2">
                    <input type="text" id="student-dogovor" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">email: </label>
                <div class="col-md-2">
                    <input type="text" id="student-email" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Имя: </label>
                <div class="col-md-2">
                    <input type="text" id="student-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Отчество: </label>
                <div class="col-md-2">
                    <input type="text" id="student-second-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Фамилия: </label>
                <div class="col-md-2">
                    <input type="text" id="student-last-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Дата рождения: </label>
                <div class="col-md-2">
                    <input type="date" id="student-birth" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Номер телефона: </label>
                <div class="col-md-2">
                    <input type="text" id="student-tel" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Пароль: </label>
                <div class="col-md-2">

                    <input type="password" id="student-password" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <i class="fa fa-asterisk fa-fw"></i>
                <label class="control-label col-md-2" for="example-input-colorpicker">Подтверждение пароля: </label>
                <div class="col-md-2">
                    <input type="password" id="student-password-confirm" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Имя отца: </label>
                <div class="col-md-2">
                    <input type="text" id="student-father-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Отчество отца: </label>
                <div class="col-md-2">
                    <input type="text" id="student-father-second-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Фамилия отца: </label>
                <div class="col-md-2">
                    <input type="text" id="student-father-last-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Номер телефона отца: </label>
                <div class="col-md-2">
                    <input type="text" id="student-tel-father" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Имя матери: </label>
                <div class="col-md-2">
                    <input type="text" id="student-mother-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Отчество матери: </label>
                <div class="col-md-2">
                    <input type="text" id="student-mother-second-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Фамилия матери: </label>
                <div class="col-md-2">
                    <input type="text" id="student-mother-last-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Номер телефона матери: </label>
                <div class="col-md-2">
                    <input type="text" id="student-tel-mother" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Комментарии: </label>
                <div class="col-md-2">
                    <textarea  id="student-comments" name="example-input-colorpicker" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-md-10 col-md-offset-2">
                    <button class="btn btn-success" onclick="createStudent()"><i class="fa fa-floppy-o"></i>Создать</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function createStudent() {
        if($("#student-dogovor").val() && $("#student-email").val() && $("#student-name").val()  && $("#student-last-name").val() && $("#student-birth").val() && $("#student-password").val() && $("#student-password-confirm").val()) {
if($("#student-password-confirm").val()==$("#student-password").val()) {
    console.log('ok')

    BX.ajax({
        url: '/api.php',
        data: {
            sessid: BX.bitrix_sessid(),
            type: 'createStudent',
            dogovor: $("#student-dogovor").val(),
            email: $("#student-email").val(),
            name: $("#student-name").val(),
            secondName: $("#student-second-name").val(),
            lastName: $("#student-last-name").val(),
            birth: $("#student-birth").val(),
            tel: $("#student-tel").val(),
            password: $("#student-password").val(),
            passwordConfirm: $("#student-password-confirm").val(),
            fatherName: $("#student-father-name").val(),
            fatherSecondName: $("#student-father-second-name").val(),
            fatherLastName: $("#student-father-last-name").val(),
            fatherTel: $("#student-tel-father").val(),
            motherName: $("#student-mother-name").val(),
            motherSecondName: $("#student-mother-second-name").val(),
            motherLastName: $("#student-mother-last-name").val(),
            motherTel: $("#student-tel-mother").val(),
            comments: $("#student-comments").val()

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
                    '            <div class="dash-tile-text text-center">Студент успешно создан!</div>\n' +
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