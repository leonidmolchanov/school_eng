<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Создание комнат");
?>

    <form action="page_form_components.html" method="post" class="form-horizontal form-box" onsubmit="return false;">
        <h4 class="form-box-header">Создание комнат</h4>
        <div class="form-box-content">
            <!-- Colorpicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://www.eyecon.ro/bootstrap-colorpicker/ -->
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Имя: </label>
                <div class="col-md-2">
                    <input type="text" id="room-name" name="example-input-colorpicker" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-colorpicker">Цвет: </label>
                <div class="col-md-2">
                    <div class="input-group input-colorpicker color" data-color="#db4a39">
                        <input type="hidden" id="room-color" name="example-input-colorpicker2" class="form-control">
                        <span class="input-group-addon"><i style="background-color: #db4a39"></i></span>
                    </div>
                </div>
            </div>
            <!-- END Colorpicker -->

            <div class="form-group form-actions">
                <div class="col-md-10 col-md-offset-2">
                    <button class="btn btn-success" onclick="createRoom()"><i class="fa fa-floppy-o"></i>Создать</button>
                </div>
            </div>
        </div>
    </form>

<script>
    function createRoom() {
        if($("#room-name").val() && $("#room-color").val()){
            console.log('ok');

            BX.ajax({
                url: '/api.php',
                data: {
                    sessid: BX.bitrix_sessid(),
                    type: 'createRoom',
                    name: $("#room-name").val(),
                    color: $("#room-color").val()
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

                    if(data=='Success'){
                        window.location.reload();
                    }

                },
                onfailure: function () {
                    console.log("error");

                }
            });



        }
        else{
            alert("Не заполнена фома!")
        }
    }

</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>