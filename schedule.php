<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Расписание");
?>
    <script>
        filter='day';
        navigate=<?if($_REQUEST['navigate']):?>Number(<?=$_REQUEST['navigate']?>)<?else:?>0<?endif;?>;
        console.log(navigate)
        dataArr=[];
        // Делаем аякс запрос
        BX.ready(function() {
            moment().localeData('ru');
            ajaxRequest(navigate);
        });

        function confrimDelete(id) {
            Swal({
                title: 'Вы уверены?',
                text: "Вы точно хотите удалить занятие?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Удалить'
            }).then((result) => {
                if (result.value) {
                    deleteLesson(id)

                }
            })

        }
        function confrimEdit() {
            console.log('baf')
            Swal({
                title: 'Вы уверены?',
                text: "Вы точно хотите изменить параметны занятия?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Изменить'
            }).then((result) => {
                if (result.value) {
                    editLesson()()

                }
            })

        }

        function ajaxRequest(navigate) {
            date = moment().add('days', navigate).format('YYYY-MM-DD');
            $("#graphDate").html(moment().add('days', navigate).format("dddd  Do MM YYYY"))
            $("#createLessonDate").val(moment().add('days', navigate).format("YYYY-MM-DD"))
            $("#editLessonDate").val(moment().add('days', navigate).format("YYYY-MM-DD"))
            console.log(date)
            $("#auditoriumSelect").empty();
            $("#groupSelect").empty();
            $("#tblTest thead").empty();
            $("#tblTest tbody").empty();
                BX.ajax({
                    url: '/api.php',
                    data: {
                        sessid: BX.bitrix_sessid(),
                        type: 'getGraph',
                        date: date,
                        filter: filter,
                        navigate: navigate
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
                        $("#tblTest tbody").empty();
                        dataArr = data;
                        console.log(data)
                        data.auditorium.map(function (item) {
                            newContent = '<option data-auditorium-id="' + item["ID"] + '">' + item["NAME"] + '</option>'
                            $("#auditoriumSelect").append(newContent);

                        })
                        data.group.map(function (item) {
                            teacherName = "";
                            data.teacher.map(function (teacher) {
                                if (teacher["ID"] == item["PROPERTY_TEACHER_VALUE"]) {
                                    teacherName = teacher["NAME"]
                                }
                            });
                            newContent = '<option data-group-id="' + item["ID"] + '">' + item["NAME"] + ' (' + teacherName + ')</option>'
                            $("#groupSelect").append(newContent);

                        })
                        length = 0;
                   if(filter=='day') {
                       data.content[0].map(function (row) {
                           len = 0;

                           row["CONTENT"].map(function (item) {
                               len++
                           })

                           if (len > length) {
                               length = len;
                           }
                       });
                       console.log('len' + len)

                       data.content[0].map(function (row) {
                           newBodyContent = '<tr role="row" class="odd">'
                           newBodyContent += ' <td class="text-center" style="vertical-align: middle;"><strong>' + row["NAME"] + '</strong></td>'
                           i = 0;
                           row["CONTENT"].map(function (lessons) {
                               color = "ffffff";
                               data.auditorium.map(function (value) {
                                   if (lessons["PROPERTY_AUDITORIUM_VALUE"] == value["ID"]) {
                                       color = value["PROPERTY_COLOR_VALUE"];
                                   }
                               })
                               console.log(lessons["PROPERTY_REPEAT_VALUE"])
                               if(Number(lessons["PROPERTY_REPEAT_VALUE"])!==0){
                                   newBodyContent += ' <td class="text-center table-hover" bgcolor="' + color + '"><a  class="close" alt="Редактировать" data-lesson-name="' + lessons["NAME"] + '" data-lesson-time-from="' + lessons["PROPERTY_FROM_VALUE"] + '" data-lesson-time-to="' + lessons["PROPERTY_TO_VALUE"] + '" data-lesson-id="' + lessons["ID"] + '" data-lesson-cost="' + lessons["PROPERTY_COST_VALUE"] + '" data-lesson-repeat="' + lessons["PROPERTY_REPEAT_VALUE"] + '" data-group-id="' + lessons["PROPERTY_GROUP_VALUE"] + '" data-auditorium-id="' + lessons["PROPERTY_AUDITORIUM_VALUE"] + '" onclick="editPopup(1, this)" data-dismiss="modal">&#9998;</a><a  class="close" alt="Удалить" id="' + lessons["ID"] + '" onclick="confrimDelete(this.id)" data-dismiss="modal">×</a><div data-lesson-name="' + lessons["NAME"] + '" data-lesson-time-from="' + lessons["PROPERTY_FROM_VALUE"] + '" data-lesson-time-to="' + lessons["PROPERTY_TO_VALUE"] + '" data-lesson-id="' + lessons["ID"] + '" data-lesson-cost="' + lessons["PROPERTY_COST_VALUE"] + '" onclick="showStructure(this)" ondblclick="editPopup(1, this)">' + lessons["NAME"] + '<br>' + lessons["PROPERTY_FROM_VALUE"] + '-' + lessons["PROPERTY_TO_VALUE"] + '</div></td>'

                               }
                               else {
                                   newBodyContent += ' <td class="text-center table-hover" style="background: radial-gradient(#ffffff, ' + color + ');" bgcolor="' + color + '"><a  class="close" alt="Редактировать"  data-lesson-name="' + lessons["NAME"] + '" data-lesson-time-from="' + lessons["PROPERTY_FROM_VALUE"] + '" data-lesson-time-to="' + lessons["PROPERTY_TO_VALUE"] + '" data-lesson-id="' + lessons["ID"] + '" data-lesson-cost="' + lessons["PROPERTY_COST_VALUE"] + '" data-lesson-repeat="' + lessons["PROPERTY_REPEAT_VALUE"] + '" data-group-id="' + lessons["PROPERTY_GROUP_VALUE"] + '" data-auditorium-id="' + lessons["PROPERTY_AUDITORIUM_VALUE"] + '" onclick="editPopup(1, this)" data-dismiss="modal">&#9998;</a><a  class="close" alt="Удалить" id="' + lessons["ID"] + '" data-lesson-cost="' + lessons["PROPERTY_COST_VALUE"] + '" onclick="confrimDelete(this.id)" data-dismiss="modal">×</a><div data-lesson-name="' + lessons["NAME"] + '" data-lesson-time-from="' + lessons["PROPERTY_FROM_VALUE"] + '" data-lesson-time-to="' + lessons["PROPERTY_TO_VALUE"] + '" data-lesson-id="' + lessons["ID"] + '"  data-lesson-cost="' + lessons["PROPERTY_COST_VALUE"] + '" onclick="showStructure(this)" ondblclick="editPopup(1, this)">' + lessons["NAME"] + '<br>' + lessons["PROPERTY_FROM_VALUE"] + '-' + lessons["PROPERTY_TO_VALUE"] + '</div></td>'
                               }
                               i++
                           })
                           if (length - i !== 0) {
                               for (var x = 0; x < (length - i); x++)
                                   newBodyContent += ' <td class=""></td>'
                           }
                           newBodyContent += '</tr>';
                           $("#tblTest tbody").append(newBodyContent);
                       });
                   }
                        else if(filter=='week') {
                       data.content.map(function (block) {

                           block.map(function (row) {
                               len = 0;

                               row["CONTENT"].map(function (item) {
                                   len++
                               })

                               if (len > length) {
                                   length = len;
                               }
                           });
                       });
                       z=0;
                       data.content.map(function (block) {
                           newBodyContentFor="";
                           block.map(function (row) {
                               newBodyContent = '<tr role="row" class="odd">'
                               newBodyContent += ' <td class="text-center" style="vertical-align: middle;"><strong>' + row["NAME"] + '</strong></td>'
                               i = 0;
                               row["CONTENT"].map(function (lessons) {
                                   color = "ffffff";
                                   data.auditorium.map(function (value) {
                                       if (lessons["PROPERTY_AUDITORIUM_VALUE"] == value["ID"]) {
                                           color = value["PROPERTY_COLOR_VALUE"];
                                       }
                                   })
                                   console.log(color)
                                   if(Number(lessons["PROPERTY_REPEAT_VALUE"])!==0){
                                       newBodyContent += ' <td class="text-center table-hover" bgcolor="' + color + '"><a  class="close" alt="Редактировать"  data-lesson-name="' + lessons["NAME"] + '" data-lesson-time-from="' + lessons["PROPERTY_FROM_VALUE"] + '" data-lesson-time-to="' + lessons["PROPERTY_TO_VALUE"] + '" data-lesson-id="' + lessons["ID"] + '" data-lesson-cost="' + lessons["PROPERTY_COST_VALUE"] + '" data-lesson-repeat="' + lessons["PROPERTY_REPEAT_VALUE"] + '"  data-group-id="' + lessons["PROPERTY_GROUP_VALUE"] + '" data-auditorium-id="' + lessons["PROPERTY_AUDITORIUM_VALUE"] + '" onclick="editPopup(1, this)" data-dismiss="modal">&#9998;</a><a  class="close" alt="Удалить" id="' + lessons["ID"] + '" onclick="confrimDelete(this.id)" data-dismiss="modal">×</a><div data-lesson-name="' + lessons["NAME"] + '" data-lesson-time-from="' + lessons["PROPERTY_FROM_VALUE"] + '" data-lesson-time-to="' + lessons["PROPERTY_TO_VALUE"] + '" data-lesson-id="' + lessons["ID"] + '" onclick="showStructure(this)" ondblclick="editPopup(1, this)">' + lessons["NAME"] + '<br>' + lessons["PROPERTY_FROM_VALUE"] + '-' + lessons["PROPERTY_TO_VALUE"] + '</div></td>'

                                   }
                                   else {
                                       newBodyContent += ' <td class="text-center table-hover" style="background: radial-gradient(#ffffff, ' + color + ');" bgcolor="' + color + '"><a  class="close" alt="Редактировать"  data-lesson-name="' + lessons["NAME"] + '" data-lesson-time-from="' + lessons["PROPERTY_FROM_VALUE"] + '" data-lesson-time-to="' + lessons["PROPERTY_TO_VALUE"] + '" data-lesson-id="' + lessons["ID"] + '" data-lesson-cost="' + lessons["PROPERTY_COST_VALUE"] + '" data-lesson-repeat="' + lessons["PROPERTY_REPEAT_VALUE"] + '"  data-group-id="' + lessons["PROPERTY_GROUP_VALUE"] + '" data-auditorium-id="' + lessons["PROPERTY_AUDITORIUM_VALUE"] + '" onclick="editPopup(1, this)" data-dismiss="modal">&#9998;</a><a  class="close" alt="Удалить" id="' + lessons["ID"] + '" onclick="confrimDelete(this.id)" data-dismiss="modal">×</a><div data-lesson-name="' + lessons["NAME"] + '" data-lesson-time-from="' + lessons["PROPERTY_FROM_VALUE"] + '" data-lesson-time-to="' + lessons["PROPERTY_TO_VALUE"] + '" data-lesson-id="' + lessons["ID"] + '" onclick="showStructure(this)" ondblclick="editPopup(1, this)">' + lessons["NAME"] + '<br>' + lessons["PROPERTY_FROM_VALUE"] + '-' + lessons["PROPERTY_TO_VALUE"] + '</div></td>'
                                   }
                                   i++
                               })
                               if (length - i !== 0) {
                                   for (var x = 0; x < (length - i); x++)
                                       newBodyContent += ' <td class=""></td>'
                               }
                               newBodyContent += '</tr>';
                               newBodyContentFor+=newBodyContent;
                           });
                           $("#tblTest tbody").append('<tr><td colspan="'+length+1+'"><strong>'+moment().add('days', (navigate+z)).format('dddd YYYY-MM-DD')+'</strong></td></tr>');
                           $("#tblTest tbody").append(newBodyContentFor);
z++;
                       });


                        }

                    },
                    onfailure: function () {
                        console.log("error");

                    }
                });


        }
        
        function createLesson() {
            if($("#createLessonName").val() && $("#createLessonFrom").val() && $("#createLessonTo").val() && $("#createLessonDate").val() && $("#groupSelect option:selected").attr('data-group-id') && $("#auditoriumSelect option:selected").attr('data-auditorium-id')){

                BX.ajax({
                    url: '/api.php',
                    data: {
                        sessid: BX.bitrix_sessid(),
                        type: 'createLesson',
                        name: $("#createLessonName").val(),
                        from: $("#createLessonFrom").val(),
                        to: $("#createLessonTo").val(),
                        date: $("#createLessonDate").val(),
                        group: $("#groupSelect option:selected").attr('data-group-id'),
                        auditorium: $("#auditoriumSelect option:selected").attr('data-auditorium-id'),
                        repeat: $("#repeatLesson").prop("checked"),
                        cost: $("#cost").val()
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
                            window.location.href += '?navigate='+navigate+'';
                        }
                    },
                    onfailure: function () {
                        console.log("error");

                    }
                });

            }
            else{
            alert('Не введены данные формы!')
            }
        }

        function deleteLesson(id) {
            console.log(id)

            console.log(id)
            BX.ajax({
                url: '/api.php',
                data: {
                    sessid: BX.bitrix_sessid(),
                    type: 'deleteLesson',
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

                    if(data=='Success'){
                        window.location.href += '?navigate='+navigate+'';
                    }

                },
                onfailure: function () {
                    console.log("error");

                }
            });

        }

        function editLesson() {
            if($("#editLessonName").val() && $("#editLessonFrom").val() && $("#editLessonTo").val() && $("#editLessonDate").val() && $("#editGroupSelect option:selected").attr('data-group-id') && $("#editAuditoriumSelect option:selected").attr('data-auditorium-id')) {

console.log($("#edit-idLesson").val())
                BX.ajax({
                    url: '/api.php',
                    data: {
                        sessid: BX.bitrix_sessid(),
                        type: 'editLesson',
                        name: $("#editLessonName").val(),
                        from: $("#editLessonFrom").val(),
                        to: $("#editLessonTo").val(),
                        date: $("#editLessonDate").val(),
                        group: $("#editGroupSelect option:selected").attr('data-group-id'),
                        auditorium: $("#editAuditoriumSelect option:selected").attr('data-auditorium-id'),
                        idLesson: $("#edit-idLesson").val(),
                        repeat: $("#editRepeatLesson").prop("checked"),
                        cost: $("#edit-cost").val()

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
                        if (data == 'Success') {
                            window.location.href += '?navigate='+navigate+'';
                        }
                    },
                    onfailure: function () {
                        console.log("error");

                    }
                });
            }
            else{
                alert('Не введены данные формы!')
            }
        }

        function nav(state) {
            if(state=='up'){
                navigate+=1
            }
            else if(state=='down'){
                navigate-=1
            }
            else if(state=='now'){
                navigate=0
            }
            console.log(navigate)
            ajaxRequest(navigate)
        }

        function editPopup(state, obj,data) {
            if(state=='close'){
                document.getElementById('edit-modal').style.display='none';
            }
            else if(state==1){
                $("#editAuditoriumSelect").empty();
                $("#editGroupSelect").empty();
                dataArr.auditorium.map(function (item) {
                    if($(obj).attr('data-auditorium-id')==item["ID"]) {
                        newContent = '<option selected data-auditorium-id="' + item["ID"] + '">' + item["NAME"] + '</option>'
                    }
                    else{
                        newContent = '<option data-auditorium-id="' + item["ID"] + '">' + item["NAME"] + '</option>'

                    }
                    $("#editAuditoriumSelect").append(newContent);

                })
                dataArr.group.map(function (item) {
                    if($(obj).attr('data-group-id')==item["ID"]) {
                        newContent = '<option selected data-group-id="' + item["ID"] + '">' + item["NAME"] + '</option>'
                    }
                    else{
                        newContent = '<option data-group-id="' + item["ID"] + '">' + item["NAME"] + '</option>'
                    }
                    $("#editGroupSelect").append(newContent);

                })
                $("#editLessonName").val($(obj).attr('data-lesson-name'));
                $("#edit-idLesson").val($(obj).attr('data-lesson-id'));
                $("#editLessonTo").val($(obj).attr('data-lesson-time-to'));
                $("#editLessonFrom").val($(obj).attr('data-lesson-time-from'));
                cost=$(obj).attr('data-lesson-cost')
                repeat=$(obj).attr('data-lesson-repeat')
                console.log(obj)
                if(repeat!=='null'){
                    $("#editRepeatLesson").prop('checked', true)
                }
                $("#edit-cost").val(Number(cost));
                document.getElementById('edit-modal').style.display='block';
            }
        }
function changeFilter(state) {
            if(state=='day'){
                filter='day';
                ajaxRequest(navigate)
            }
    else if(state=='week'){
        filter='week';
                ajaxRequest(navigate)

            }

}


        function showSearchPopup(){
            $('#search-modal').show()
        }


        function searchFreeTime() {
            BX.ajax({
                url: '/api.php',
                data: {
                    sessid: BX.bitrix_sessid(),
                    type: 'searchFreeTime',
                    dateFrom: $('#SearchDateFrom').val(),
                    dateTo: $('#SearchDateTo').val(),
                    timeFrom: $('#SearchTimeFrom').val(),
                    timeTo: $('#SearchTimeTo').val(),
                    interval: $("#timeInterval option:selected").val()

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
                    console.log(data['AUDITORIUM'])
                    $('#search-modal').hide()
                    $('#free-time-result-modal').show()
                    $('#free-time-result-list tbody').empty();
                    data['FREETIME'].forEach(function (item) {
                        content='<tr><td>'+item['FROM']+'</td><td>'+item['TO']+'</td><td>'+data["AUDITORIUM"][item["AUDITORIUM"]][0]['NAME']+'</td><td><a href="#example-modal" data-from ="'+item['FROM']+'" data-to ="'+item['TO']+'" onclick="addAfterSearch(this)" data-toggle="modal">Создать урок</a></td></tr>'
                        $('#free-time-result-list tbody').append(content)
                    })

                },
                onfailure: function () {
                    console.log("error");

                }
            });
        }
function showStructure(elem) {
    console.log(elem.dataset.lessonId)
    BX.ajax({
        url: '/api.php',
        data: {
            sessid: BX.bitrix_sessid(),
            type: 'getLessonStructure',
            id: elem.dataset.lessonId
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
            $('#structure-modal').show()
            data['STUDENTS'].forEach(function (item) {
                console.log(item)
                adjustment=""
;                if(item['PROPERTY_STATUS_VALUE']==0){
                    status='Заблокирован'
                }
                else if(item['PROPERTY_STATUS_VALUE']==1){
                    status='Активен'
                }
                else if(item['PROPERTY_STATUS_VALUE']==2){
                    status='Болеет'
                }
                else{
                    status='-'
                }
                if(item['ADJUSTMENT']){
                    adjustment='(отработка)'
                }
                row = '<tr><td><a href="student-card.php?ELEMENT_ID='+item['ID']+'">'+item['PROPERTY_DOGOVOR_VALUE']+'</a></td><td><a href="student-card.php?ELEMENT_ID='+item['ID']+'">'+item['PROPERTY_LAST_NAME_VALUE']+' '+item['PROPERTY_NAME_VALUE']+'</a>' +adjustment+'</td><td>'+status+'</td></tr>'
                $("#structure-lesson-list tbody").append(row);
            })
        },
        onfailure: function () {
            console.log("error");

        }
    });
}
        function hideStructurePopup() {
            $('#structure-lesson-list tbody').empty()
            $('#structure-modal').hide()

        }
        function hideSearchPopup() {
            $('#search-modal').hide()

        }
        function hidefreeTimeResultPopup() {
            $('#free-time-result-modal').hide()

        }

        function addAfterSearch(item) {
            console.log(item.dataset.to)
            from=item.dataset.from
            to=item.dataset.to
            from=from.split(" ")
            to=to.split(" ")

            $('#search-modal').hide()
            $('#free-time-result-modal').hide()
            $('#createLessonFrom').val(from[1])
            $('#createLessonTo').val(to[1])
            $('#createLessonDate').val(from[0])

        }
    </script>
    <div id="example-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;"><div class="modal-backdrop  in" style="height: 833px;"></div>
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4>Создание занятия</h4>
                </div>
                <div class="modal-body">
                    <form action="page_form_components.html" method="post" class="form-horizontal form-box" onsubmit="return false;">                         <!-- Timepicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://jdewit.github.io/bootstrap-timepicker/ -->
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6">Название урока:</label>
                                <div class="input-group">
                                    <input type="text" id="createLessonName" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6"  for="example-input-timepicker">С:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="time" id="createLessonFrom" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-timepicker">До:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="time" id="createLessonTo" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- END Timepicker -->

                        <!-- Datepicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://eternicode.github.io/bootstrap-datepicker -->
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Дата:</label>
                                <div class="input-group bootstrap-timepicker">
                                <input type="date" id="createLessonDate" name="example-input-datepicker"
                                       class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Группа:</label>
                                <div class="input-group bootstrap-timepicker">
                                <select class="form-control input-sm" id="groupSelect">
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Аудитория:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <select class="form-control input-sm" id="auditoriumSelect">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-timepicker">Стоимость:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="number" id="cost" value ='1.00' min="1.00" max="10000.00" step="0.01" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Повторять занятие:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="checkbox" checked="true" id="repeatLesson">
                                </div>
                            </div>
                        </div>
                        </div>
                    </form>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                    <button class="btn btn-success" onclick="createLesson()">Создать</button>
                </div>
                </div>
            </div>
            <!-- END Modal Content -->
        </div>


    <div id="edit-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;"><div class="modal-backdrop  in" style="height: 833px;"></div>
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onClick="editPopup('close')" data-dismiss="modal">×</button>
                    <h4>Редактирование занятия</h4>
                </div>
                <div class="modal-body">
                    <form action="page_form_components.html" method="post" class="form-horizontal form-box" onsubmit="return false;">                         <!-- Timepicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://jdewit.github.io/bootstrap-timepicker/ -->
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6">Название урока:</label>
                                <div class="input-group">
                                    <input type="text" id="editLessonName" class="form-control">
                                    <input type ="hidden" id="edit-idLesson" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6"  for="example-input-timepicker">С:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="time" id="editLessonFrom" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-timepicker">До:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="time" id="editLessonTo" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- END Timepicker -->

                        <!-- Datepicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://eternicode.github.io/bootstrap-datepicker -->
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Дата:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="date" id="editLessonDate" name="example-input-datepicker"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Группа:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <select class="form-control input-sm" id="editGroupSelect">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Аудитория:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <select class="form-control input-sm" id="editAuditoriumSelect">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-timepicker">Стоимость:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="number"  id="edit-cost" value="1.00" min="1.00" max="10000.00" step="0.01" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Повторять занятие:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="checkbox"  id="editRepeatLesson">
                                </div>
                            </div>
                        </div>
                </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-danger" onClick="editPopup('close')">Закрыть</button>
                    <button class="btn btn-success" onclick="confrimEdit()">Изменить</button>
                </div>
            </div>
        </div>
        <!-- END Modal Content -->
    </div>


    <div id="structure-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;"><div class="modal-backdrop  in" style="height: 833px;"></div>
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onClick="hideStructurePopup()" data-dismiss="modal">×</button>
                    <h4>Состав группы</h4>
                </div>
                <div class="modal-body">
<table id="structure-lesson-list" class="table table-striped table-bordered table-hover dataTable no-footer">
    <thead>
    <th>Номер договора</th><th>Имя</th><th>Статус</th></thead>
    <tbody></tbody>
</table>                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" onClick="hideStructurePopup()">Закрыть</button>
                </div>
            </div>
        </div>
        <!-- END Modal Content -->
    </div>

    <div id="free-time-result-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;"><div class="modal-backdrop  in" style="height: 833px;"></div>
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onClick="hidefreeTimeResultPopup()" data-dismiss="modal">×</button>
                    <h4>Результат поиска</h4>
                </div>
                <div class="modal-body">
                    <table id="free-time-result-list" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                        <th>С</th><th>До</th><th>Аудитория</th><th>Действие</th></thead>
                        <tbody></tbody>
                    </table>                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" onClick="hidefreeTimeResultPopup()">Закрыть</button>
                </div>
            </div>
        </div>
        <!-- END Modal Content -->
    </div>
    <div id="search-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;"><div class="modal-backdrop  in" style="height: 833px;"></div>
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onClick="hideSearchPopup()" data-dismiss="modal">×</button>
                    <h4>Поиск свободного времени</h4>
                </div>
                <div class="modal-body">

                    <form action="page_form_components.html" method="post" class="form-horizontal form-box" onsubmit="return false;">                         <!-- Timepicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://jdewit.github.io/bootstrap-timepicker/ -->
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6"  for="example-input-timepicker">С:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="date" id="SearchDateFrom" name="example-input-datepicker"
                                           class="form-control"><input type="time" id="SearchTimeFrom" value="10:00" name="example-input-datepicker"
                                                                       class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-timepicker">До:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="date" id="SearchDateTo" name="example-input-datepicker"
                                           class="form-control"><input type="time" id="SearchTimeTo" value="21:00" name="example-input-datepicker"
                                                                       class="form-control">
                                </div>
                            </div>
                        </div>
                        <script>
                            document.getElementById('SearchDateFrom').valueAsDate = new Date();
                            document.getElementById('SearchDateTo').valueAsDate = new Date();

                        </script>
                        <!-- END Timepicker -->

                        <!-- Datepicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://eternicode.github.io/bootstrap-datepicker -->


                        <div class="form-group">
                            <div class="col-md-8">
                                <label class="control-label col-md-6" for="example-input-datepicker">Промежуток:</label>
                                <div class="input-group bootstrap-timepicker">
                                    <select class="form-control input-sm" id="timeInterval">
                                        <option value="30">30 Минут</option>
                                        <option value="40">40 Минут</option>
                                        <option value="50">50 Минут</option>
                                        <option value="60" selected>60 Минут</option>
                                        <option value="70">70 Минут</option>
                                        <option value="80">80 Минут</option>
                                        <option value="90">90 Минут</option>
                                        <option value="100">100 Минут</option>
                                        <option value="110">110 Минут</option>
                                        <option value="120">120 Минут</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                                 </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" onClick="hideSearchPopup()">Закрыть</button>
                    <button class="btn btn-success" onclick="searchFreeTime()">Поиск</button>
                </div>
            </div>
        </div>
        <!-- END Modal Content -->
    </div>



    <!-- END Modal Dialog -->
    <div class="fc-toolbar">
        <div class="fc-left">
            <div class="fc-button-group">
                <button type="button" class="fc-prev-button fc-button fc-state-default fc-corner-left"><span
                            class="fc-icon fc-icon-left-single-arrow" onclick="nav('down')"></span></button>
                <button type="button" class="fc-next-button fc-button fc-state-default fc-corner-right" onclick="nav('up')"><span
                            class="fc-icon fc-icon-right-single-arrow"></span></button>
            </div>
            <button type="button" onclick="nav('now')" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right fc-state-active">
                Сегодня
            </button>
            <a href="#example-modal" class="btn btn-default" data-toggle="modal">Создать занятие</a>
            <a href="#example-modal" class="btn btn-primary" onclick="showSearchPopup()">Поиск</a>
        </div>
        <div class="fc-right">
            <div class="fc-button-group">
                <button type="button" class="fc-agendaWeek-button fc-button fc-state-default" onClick="changeFilter('week')">Неделя</button>
                <button type="button" class="fc-agendaDay-button fc-button fc-state-default fc-corner-right fc-state-active" onClick="changeFilter('day')">День
                </button>
            </div>
        </div>
        <div class="fc-center"><h2><span id="graphDate"></span></h2></div>
        <div class="fc-clear"></div>
    </div>
    <div id="example-datatables_wrapper" class="dataTables_wrapper form-inline no-footer">
    <table class="table table-striped table-bordered dataTable no-footer" id="tblTest">
        <tbody>
        </tbody>
    </table>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>