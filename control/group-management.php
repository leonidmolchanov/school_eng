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
                    <div class="col-md-2">
                        <input type="text"  id="createGroupName" name="example-input-small" class="form-control input-sm">
                    </div>
                    <div class="col-md-2">
<select class="form-control input-sm" id="teacherSelect">
</select>
                </div>
                    <div class="col-md-2">
                        <select class="form-control input-sm" id="costSelect">
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

function confrimChange(item, change) {
    item = item.parentNode.parentNode
    nameGroup = item.querySelector('input[name="name"]')
    teacherGroup = item.querySelector('select[name="teacher"]')
   costGroup = item.querySelector('select[name="cost"]')
    buttonGroup = item.querySelector('input[name="buttonWrite"]')
    console.log(buttonGroup.dataset.id)
buttonGroup.value = "Сохранить";
    nameGroup.disabled=false;
    teacherGroup.disabled=false;
    costGroup.disabled=false;
if(buttonGroup.dataset.confrim=='true'){
    request={
        id: buttonGroup.dataset.id,
        name: nameGroup.value,
        lesson: $(costGroup).find('option:selected').attr('data-lesson'),
        teacher:$(teacherGroup).find('option:selected').attr('data-user-id')
    }
    console.log(buttonGroup.dataset.id)

    Swal({
        title: 'Вы уверены?',
        text: "Вы точно хотите изменить группу?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Изменить'
    }).then((result) => {
        if (result.value) {
            changeGroup(request)

        }
    })
}
    buttonGroup.dataset.confrim = 'true'

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

                data.lessoncost.map(function (item) {
                    newContent='<option data-lessoncost-id="'+item["ID"]+'">'+item["NAME"]+'</option>'
                    $("#costSelect").append(newContent);

                })
                data.group.map(function (row) {
                    teacherArr="";
                data.teacher.map(function (item) {
                 if(item["ID"]==row["PROPERTY_TEACHER_VALUE"]){
                     teacherArr+='<option selected data-user-id="'+item["ID"]+'">'+item["NAME"]+'</option>'
                 }
                 else{
                     teacherArr+='<option data-user-id="'+item["ID"]+'">'+item["NAME"]+'</option>'

                 }
                })

                    costGroupArr="";
                    data.lessoncost.map(function (item) {
                        if(item["ID"]==row["PROPERTY_LESSON_COST_VALUE"]){
                            costGroupArr+='<option selected data-lesson="'+item["ID"]+'">'+item["NAME"]+'</option>'
                        }
                        else{
                            costGroupArr+='<option data-lesson="'+item["ID"]+'">'+item["NAME"]+'</option>'

                        }
                    })
                    newContent = ' <div class="form-group">\n' +
                        '                <div class="col-md-3">\n' +
                        '<input type="radio" onclick="confrimWrite(this)" name="radios" value="write">'+
                        '</label>'+
                        '                <label class="control-label" for="example-input-small"><strong>Имя группы:</strong></label>\n' +
                        '                    <input type="text" name="name"  class="form-control input-sm" value = "'+row["NAME"]+'" disabled>\n' +
                        '                </div>\n' +
                        '                <div class="col-md-2">\n' +
                        '                    <label class="control-label " for="example-input-small"><strong>Учитель:</strong></label>\n' +
                        '                    <select disabled name="teacher" class="form-control input-sm">'+teacherArr+'</select>\n' +
                        '                </div>\n' +
                        '\n' +
                        '                <div class="col-md-2">\n' +
                        '                    <label class="control-label " for="example-input-small"><strong>Стоимость:</strong></label>\n' +
                        '                    <select disabled name="cost" class="form-control input-sm">'+costGroupArr+'</select>\n' +
                        '                </div>\n' +
                        '\n' +
                        '                <div class="col-md-2">\n' +
                        '                    <input type="button" class="btn btn-danger" id="'+row["ID"]+'" name = "buttonDelete" style="display: none" onclick="confrimDelete(this.id)" value="Удалить">\n' +
                        '                </div>\n' +
                        '                <div class="col-md-2">\n' +
                        '                    <input type="button" class="btn btn-warning" data-id="'+row["ID"]+'" data-confrim="false" style="display: none"  name = "buttonWrite" onclick="confrimChange(this)" value="Редактировать">\n' +
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

function confrimWrite(item) {
    item=item.parentNode.parentNode
item.querySelector('[name="buttonWrite"]').style.display= 'block'
    item.querySelector('[name="buttonDelete"]').style.display= 'block'

}
function changeGroup(arr) {
    console.log(arr)
    BX.ajax({
        url: '/api.php',
        data: {
            sessid: BX.bitrix_sessid(),
            type: 'editGroup',
            nameGroup: arr.name,
            teacherGroup: Number(arr.teacher),
            lessoncost: Number(arr.lesson),
            id: Number(arr.id)
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
                window.location.reload();
            }

        },
        onfailure: function () {
            console.log("error");

        }
    });
}
function createGroup(form) {
if($("#createGroupName").val() && $("#teacherSelect option:selected").attr('data-user-id')){
    BX.ajax({
        url: '/api.php',
        data: {
            sessid: BX.bitrix_sessid(),
            type: 'createGroup',
            nameGroup: $("#createGroupName").val(),
            teacherGroup: $("#teacherSelect option:selected").attr('data-user-id'),
            lessoncost: Number($("#costSelect option:selected").attr('data-lessoncost-id'))
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