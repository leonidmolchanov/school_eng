<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
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



    function ajaxRequest(navigate) {
        date = moment().add('days', navigate).format('YYYY-MM-DD');
        $("#graphDate").html(moment().add('days', navigate).format("dddd  Do.MM.YYYY"))
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
                            if(Number(lessons["PROPERTY_REPEAT_VALUE"])!==0){
                                newBodyContent += ' <td class="text-center table-hover" style="cursor: pointer;" bgcolor="' + color + '"><div data-lesson-name="' + lessons["NAME"] + '" data-lesson-time-from="'+lessons["PROPERTY_FROM_VALUE"]+'" data-lesson-time-to="'+lessons["PROPERTY_TO_VALUE"]+'" data-lesson-id="' + lessons["ID"] + '" ondblclick="editPopup(1, this)">' + lessons["NAME"] + '<br>' + lessons["PROPERTY_FROM_VALUE"] + '-' + lessons["PROPERTY_TO_VALUE"] + '</div></td>'

                            }
                            else {
                                newBodyContent += ' <td class="text-center table-hover" style="background: radial-gradient(#ffffff, ' + color + '); cursor: pointer;" bgcolor="' + color + '"><div data-lesson-name="' + lessons["NAME"] + '" data-lesson-time-from="'+lessons["PROPERTY_FROM_VALUE"]+'" data-lesson-time-to="'+lessons["PROPERTY_TO_VALUE"]+'" data-lesson-id="' + lessons["ID"] + '" ondblclick="editPopup(1, this)">' + lessons["NAME"] + '<br>' + lessons["PROPERTY_FROM_VALUE"] + '-' + lessons["PROPERTY_TO_VALUE"] + '</div></td>'
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
                                if(Number(lessons["PROPERTY_REPEAT_VALUE"])!==0){
                                    newBodyContent += ' <td class="text-center table-hover" style="cursor: pointer;" bgcolor="' + color + '"><div data-lesson-name="' + lessons["NAME"] + '" data-lesson-id="' + lessons["ID"] + '" ondblclick="editPopup(1, this)">' + lessons["NAME"] + '<br>' + lessons["PROPERTY_FROM_VALUE"] + '-' + lessons["PROPERTY_TO_VALUE"] + '</div></td>'

                                }
                                else {
                                    newBodyContent += ' <td class="text-center table-hover" style="background: radial-gradient(#ffffff, ' + color + '); cursor: pointer;" bgcolor="' + color + '"><div data-lesson-name="' + lessons["NAME"] + '" data-lesson-id="' + lessons["ID"] + '" ondblclick="editPopup(1, this)">' + lessons["NAME"] + '<br>' + lessons["PROPERTY_FROM_VALUE"] + '-' + lessons["PROPERTY_TO_VALUE"] + '</div></td>'
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
        console.log($(obj).attr('data-lesson-id'))
        if(state=='close'){
            document.getElementById('edit-modal').style.display='none';
        }
        else if(state==1){
            $("#editLessonName").html($(obj).attr('data-lesson-name'));
            $("#edit-idLesson").val($(obj).attr('data-lesson-id'));
            document.getElementById('edit-modal').style.display='block';
        }
    }
    function changeFilter(state) {
        if(state=='day'){
            filter='day';
            document.getElementById('filterButtonDay').className+='fc-corner-right fc-state-active';
            document.getElementById('filterButtonWeek').classList.remove('fc-state-active')

            ajaxRequest(navigate)
        }
        else if(state=='week'){
            document.getElementById('filterButtonWeek').className+='fc-corner-right fc-state-active';
            document.getElementById('filterButtonDay').classList.remove('fc-state-active')
            filter='week';
            ajaxRequest(navigate)

        }

    }


    function confrimAdjustment() {
         BX.ajax({
             url: '/api.php',
             data: {
                 sessid: BX.bitrix_sessid(),
                 type: 'createAdjustment',
                 lessonid: $("#edit-idLesson").val(),
                 description: $("#edit-description").val(),
                 userid: <?=$arResult['ID']?>
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
                     Swal({
                         title: 'Готово!',
                         text: "Отработка создана!",
                         type: 'warning',
                         confirmButtonColor: '#3085d6',
                         cancelButtonColor: '#d33',
                         confirmButtonText: 'Завершить'
                     }).then((result) => {
                         window.location = "/adjustment.php"
                     })                 }
             },
             onfailure: function () {
                 console.log("error");

             }
         });

    }
</script>

<div id="edit-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;"><div class="modal-backdrop  in" style="height: 833px;"></div>
    <!-- Modal Dialog -->
    <div class="modal-dialog">
        <!-- Modal Content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onClick="editPopup('close')" data-dismiss="modal">×</button>
                <h4>Назначение отработки</h4>
            </div>
            <div class="modal-body">
                <form action="page_form_components.html" method="post" class="form-horizontal form-box" onsubmit="return false;">                         <!-- Timepicker for Bootstrap (classes are initialized in js/main.js -> uiInit()), for extra usage examples you can check out http://jdewit.github.io/bootstrap-timepicker/ -->
                    <div class="form-group">
                        <div class="col-md-8">
                            <label class="control-label col-md-6" for="example-input-datepicker">Группа:</label>
                            <div class="input-group bootstrap-timepicker">
                            <span id="editLessonName"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <label class="control-label col-md-6" for="example-input-datepicker">Комментарий:</label>
                            <div class="input-group bootstrap-timepicker">
                                <textarea id="edit-description"  class="form-control" rows="3"></textarea>                            </div>
                        </div>
                    </div>
            </div>
            <input type="hidden" id="edit-idLesson">
            </form>
            <div class="modal-footer">
                <button class="btn btn-danger" onClick="editPopup('close')">Закрыть</button>
                <button class="btn btn-success" onclick="confrimAdjustment()">Создать</button>
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

    </div>
    <div class="fc-right">
        <div class="fc-button-group">
            <button type="button" id="filterButtonWeek" class="fc-agendaWeek-button fc-button fc-state-default" onClick="changeFilter('week')">Неделя</button>
            <button type="button" id="filterButtonDay" class="fc-agendaDay-button fc-button fc-state-default fc-corner-right fc-state-active" onClick="changeFilter('day')">День</button>
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