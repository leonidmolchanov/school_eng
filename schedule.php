<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Расписание");
?>
    <script>
        filter='day';
        navigate=0;
        dataArr=[];
        // Делаем аякс запрос
        BX.ready(function() {
            moment().localeData('ru');
            ajaxRequest();
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
                               console.log(color)
                               newBodyContent += ' <td class="text-center table-hover" bgcolor="' + color + '"><a  class="close" alt="Удалить" id="' + lessons["ID"] + '" onclick="confrimDelete(this.id)" data-dismiss="modal">×</a><div data-lesson-name="' + lessons["NAME"] + '" data-lesson-time-from="'+lessons["PROPERTY_FROM_VALUE"]+'" data-lesson-time-to="'+lessons["PROPERTY_TO_VALUE"]+'" data-lesson-id="' + lessons["ID"] + '" ondblclick="editPopup(1, this)">' + lessons["NAME"] + '<br>' + lessons["PROPERTY_FROM_VALUE"] + '-' + lessons["PROPERTY_TO_VALUE"] + '</div></td>'
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
                                   newBodyContent += ' <td class="text-center table-hover" bgcolor="' + color + '"><a  class="close" alt="Удалить" id="' + lessons["ID"] + '" onclick="deleteLesson(this.id)" data-dismiss="modal">×</a><div data-lesson-name="' + lessons["NAME"] + '" data-lesson-id="' + lessons["ID"] + '" ondblclick="editPopup(1, this)">' + lessons["NAME"] + '<br>' + lessons["PROPERTY_FROM_VALUE"] + '-' + lessons["PROPERTY_TO_VALUE"] + '</div></td>'
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

console.log('ok')

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
                        auditorium: $("#auditoriumSelect option:selected").attr('data-auditorium-id')
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
                        window.location.reload();
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
                        idLesson: $("#edit-idLesson").val()
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
                            window.location.reload();
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
                    newContent='<option data-auditorium-id="'+item["ID"]+'">'+item["NAME"]+'</option>'
                    $("#editAuditoriumSelect").append(newContent);

                })
                dataArr.group.map(function (item) {
                    newContent='<option data-group-id="'+item["ID"]+'">'+item["NAME"]+'</option>'
                    $("#editGroupSelect").append(newContent);

                })
                $("#editLessonName").val($(obj).attr('data-lesson-name'));
                $("#edit-idLesson").val($(obj).attr('data-lesson-id'));
                $("#editLessonTo").val($(obj).attr('data-lesson-time-to'));
                $("#editLessonFrom").val($(obj).attr('data-lesson-time-from'));
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