<?php
/**
 * Created by PhpStorm.
 * User: leonidmolcanov
 * Date: 03/12/2018
 * Time: 21:46
 */
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Управление группами");
?>



        <!-- Text Inputs -->
        <form method="post" id="createGroupForm" class="form-horizontal form-box">
            <h4 class="form-box-header">Создание группы</h4>
            <div class="form-box-content">

                <div class="form-group">
                    <label class="control-label col-md-2" for="example-input-small">Имя группы</label>
                    <div class="col-md-3">
                        <input type="text"  id="createGroupName" name="example-input-small" class="form-control input-sm">
                    </div>
                    <div class="col-md-4">
<select class="form-control input-sm" id="teacherSelect">
</select>
                </div>
                    <div class="col-md-3">
                        <input type="button" class="btn btn-success" value="Создать" onclick="createGroup(this.form)">
                    </div>


            </div>
        </form>
        <!-- END Text Inputs -->
    <!-- Text Inputs -->
    <div  class="form-horizontal form-box" >
        <h4 class="form-box-header">Список групп</h4>
        <div class="form-box-content" id="groupList">
        </div>
    </div>
    <!-- END Text Inputs -->
</div>
<script>

    // Делаем аякс запрос
    BX.ready(function() {
        ajaxRequest();

    });

function confrimDelete(id) {
    Swal({
        title: 'Вы уверены?',
        text: "Вы точно хотите удалить группу?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Удалить'
    }).then((result) => {
        if (result.value) {
            deleteGroup(id)

        }
    })

}
    function ajaxRequest() {

        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'getGroup'
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
                data.teacher.map(function (item) {
                    newContent='<option data-user-id="'+item["ID"]+'">'+item["NAME"]+'</option>'
                    $("#teacherSelect").append(newContent);

                })
                data.group.map(function (row) {
                    teacher="";
                data.teacher.map(function (item) {
                 if(item["ID"]==row["PROPERTY_TEACHER_VALUE"]){
                     teacher=item["NAME"]
                 }
                })
                    newContent = ' <div class="form-group">\n' +
                        '                <div class="col-md-3">\n' +
                        '                <label class="control-label" for="example-input-small"><strong>Имя группы:</strong></label>\n' +
                        '                    <label class="control-label " for="example-input-small">'+row["NAME"]+'</label>\n' +
                        '                </div>\n' +
                        '                <div class="col-md-6">\n' +
                        '                    <label class="control-label " for="example-input-small"><strong>Учитель:</strong></label>\n' +
                        '                    <label class="control-label " for="example-input-small">'+teacher+'</label>\n' +
                        '                </div>\n' +
                        '\n' +
                        '                <div class="col-md-3">\n' +
                        '                    <input type="button" class="btn btn-danger" id="'+row["ID"]+'" onclick="confrimDelete(this.id)" value="Удалить">\n' +
                        '                </div>\n' +
                        '                </div> '
                    $("#groupList").append(newContent);
                });
            },
            onfailure: function () {
                console.log("error");

            }
        });
    }
function createGroup(form) {
if($("#createGroupName").val() && $("#teacherSelect option:selected").attr('data-user-id')){
    console.log('ok');

    BX.ajax({
        url: '/api.php',
        data: {
            sessid: BX.bitrix_sessid(),
            type: 'createGroup',
            nameGroup: $("#createGroupName").val(),
            teacherGroup: $("#teacherSelect option:selected").attr('data-user-id')
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



    function deleteGroup(id) {
        console.log(id)
        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'deleteGroup',
                idGroup: id,
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
                        'Группа была удалена',
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