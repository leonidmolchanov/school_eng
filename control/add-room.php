<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Создание комнат");
?>

    <form action="page_form_components.html" method="post" class="form-horizontal form-box" onsubmit="return false;">
        <h4 class="form-box-header">Создание Аудиторий</h4>
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
    <div  class="form-horizontal form-box" >
        <h4 class="form-box-header">Список Аудиторий</h4>
        <div class="form-box-content" id="room-list">
        </div>
    </div>

    <div id="edit-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;"><div class="modal-backdrop  in" style="height: 833px;"></div>
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onClick="hideEditPopup()" data-dismiss="modal">×</button>
                    <h4>Поиск свободного времени</h4>
                </div>
                <div class="modal-body">

                    <form action="#" method="post" class="form-horizontal form-box" onsubmit="return false;">                         <!-- Timepicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://jdewit.github.io/bootstrap-timepicker/ -->
                        <div class="form-group">
                            <label class="control-label col-md-2" for="example-input-colorpicker">Цвет: </label>
                            <div class="col-md-2">
                                <div class="input-group input-colorpicker color" id="room-color-edit-div" data-color="#db4a39">
                                    <input type="hidden" id="room-color-edit" name="example-input-colorpicker2" class="form-control">
                                    <span class="input-group-addon"><i style="background-color: #db4a39"></i></span>
                                </div>
                                <input type="hidden" id="room-edit-id">

                            </div>
                        </div>

                        <!-- END Timepicker -->

                        <!-- Datepicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://eternicode.github.io/bootstrap-datepicker -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" onClick="hideEditPopup()">Закрыть</button>
                    <button class="btn btn-success" onclick="editRoom()">Редактировать</button>
                </div>
            </div>
        </div>
        <!-- END Modal Content -->
    </div>
<script>

    // Делаем аякс запрос
    BX.ready(function() {
        ajaxRequest();
    });

    function ajaxRequest() {
    BX.ajax({
        url: '/api.php',
        data: {
            sessid: BX.bitrix_sessid(),
            type: 'getRoom'
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

            data.map(function (row) {
                newContent = ' <div class="form-group">\n' +
                    '                <div class="col-md-3">\n' +
                    '                <label class="control-label" for="example-input-small"><strong>Имя Аудитории:</strong></label>\n' +
                    '                    <label class="control-label " for="example-input-small">'+row["NAME"]+'</label>\n' +
                    '                </div>\n' +
                    '                <div class="col-md-6">\n' +
                    '                    <label class="control-label " for="example-input-small"><strong>Цвет:</strong></label>\n' +
                    '                    <label class="control-label "  data-color="'+row["PROPERTY_COLOR_VALUE"]+'" id="'+row["ID"]+'" onclick="showModal(this.id,this.dataset.color )" style="background:'+row["PROPERTY_COLOR_VALUE"]+'; cursor: pointer;" for="example-input-small">'+row["PROPERTY_COLOR_VALUE"]+'</label>\n' +
                    '                </div>\n' +
                    '\n' +
                    '                <div class="col-md-3">\n' +
                    '                    <input type="button" class="btn btn-danger" id="'+row["ID"]+'" onclick="confrimDelete(this.id)" value="Удалить">\n' +
                    '                </div>\n' +
                    '                </div> '
                $("#room-list").append(newContent);
            });
        },
        onfailure: function () {
            console.log("error");

        }
    });
    }
function showModal(id, color) {
    $('#edit-modal').show()
    $('#room-color-edit').val(color)
    $('#room-edit-id').val(id)

    $('#room-color-edit-div').attr('data-color', '#000')
}
function hideEditPopup() {
    $('#edit-modal').hide()
}
    function editRoom() {


        BX.ajax({
                url: '/api.php',
                data: {
                    sessid: BX.bitrix_sessid(),
                    type: 'editRoom',
                    id: $('#room-edit-id').val(),
                    color: $('#room-color-edit').val()
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
                        Swal({
                            title: 'Готово!',
                            text: "Цвет комнаты изменен!",
                            type: 'warning',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Завершить'
                        }).then((result) => {
                            window.location.reload();
                        })
                    }

                },
                onfailure: function () {
                    console.log("error");

                }
            });

    }
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

    function confrimDelete(id) {
        Swal({
            title: 'Вы уверены?',
            text: "Вы точно хотите удалить Аудиторию?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Удалить'
        }).then((result) => {
            if (result.value) {
                deleteRoom(id)

            }
        })

    }

    function deleteRoom(id) {
        console.log(id)
        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'deleteRoom',
                idRoom: id,
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
                if(data=='Success'){
                    Swal(
                        'Удалено!',
                        'Аудитория была удалена',
                        'success'
                    )
                    window.location.reload();
                }

            },
            onfailure: function () {
                console.log("error");

            }
        });

    }
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>