<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Наполнение групп");
?>

    <script>
        function dragStart( event ) {
            event.dataTransfer.setData("Text", event.target.id); // используется для хранения данных, перетаскиваемых мышью во время операции drag and drop.
        }
        function dragging( event ) {
        }
        function allowDrop( event ) {
            event.preventDefault(); // отмена действия браузера по умолчанию (через событие ondragover)
        }
        function dragEnter( event ) {
            if ( event.target.className == "dragndrop" ) { // изменение цвета границы и заднего фона
                event.target.style.background = "yellow";
                event.target.style.border = "3px dotted black";
            }
        }
        function dragLeave( event ) {
            if ( event.target.className == "dragndrop" ) { // значения стиля границы и заднего фона возвращаются в первоначальный вид
                event.target.style.background = "";
                event.target.style.border = "";
            }
        }
        function drop( event ) {
            var data = event.dataTransfer.getData("Text"); // позволяет получить данные.
            console.log('add-in-group')
            console.log($("#group-list option:selected").attr('id'))
            console.log(data)
            addInGroup(data);
        }

        function dropOut( event ) {
            var data = event.dataTransfer.getData("Text"); // позволяет получить данные.
            console.log('add-out-group')
            deleteInGroup(data);
        }
        function dragEnd( event ) {
        }

function addInGroup(studentID){
            groupID=$("#group-list option:selected").attr('id');
    if(groupID)
    {
        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'addInGroupStructure',
                groupID: groupID,
                studentID: studentID
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
                refreshGroupStructure($("#group-list option:selected").attr('id'))
            }
        });
    }
}

        function deleteInGroup(studentID){
            groupID=$("#group-list option:selected").attr('id');
            groupID=Number(groupID);
            studentID=Number(studentID);
            console.log(typeof groupID)
            if(typeof groupID=='number' && typeof studentID=='number') {
                BX.ajax({
                    url: '/api.php',
                    data: {
                        sessid: BX.bitrix_sessid(),
                        type: 'deleteInGroupStructure',
                        groupID: groupID,
                        studentID: studentID
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
                        refreshGroupStructure($("#group-list option:selected").attr('id'))

                    }
                });
            }
        }

        BX.ready(function() {
            moment().localeData('ru');
            ajaxRequestStudent();
            ajaxRequestGroup();

        });


        function ajaxRequestStudent() {

            BX.ajax({
                url: '/api.php',
                data: {
                    sessid: BX.bitrix_sessid(),
                    type: 'getStudent'
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
                    data.map(function (item) {
                        newBodyContent = '<tr role="row" class="odd"  ondragstart = "dragStart(event)" ondrag = "dragging(event)" ondragend = "dragEnd(event)" draggable = "true" id ="'+item["ID"]+'">\n' +
                            '                        <td draggable = "false"><a href="javascript:void(0)" onclick="addInGroup(this.id)" id ="' + item["ID"] + '"  class="btn btn-outline"><i class="gi gi-circle_arrow_left"></i></a><a draggable = "false" href="javascript:void(0)">'+item["PROPERTY_DOGOVOR_VALUE"]+'</a></td>\n' +
                            '                        <td draggable = "false"><a  draggable = "false" href="javascript:void(0)">'+item["PROPERTY_LAST_NAME_VALUE"]+' '+item["PROPERTY_NAME_VALUE"]+'</a></td>\n' +
                            '                    </tr>';
                        $("#students-table tbody").append(newBodyContent);
console.log(item)
                    })


                    $(function () {
                        /* Initialize Datatables */
                        $('#students-table').dataTable();
                        $('.dataTables_filter input').attr('placeholder', 'Поиск');
                    });
                }
            });

        }

        function ajaxRequestGroup() {

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
                    data.group.map(function (row) {
                        teacher="";
                        data.teacher.map(function (item) {
                            if(item["ID"]==row["PROPERTY_TEACHER_VALUE"]){
                                teacher=item["NAME"]
                            }
                        })
                        $("#group-list").append('<option id="'+row["ID"]+'" value="10">'+row["NAME"]+'('+teacher+')</option>');
                        console.log(row)
                    })

                }
            });

        }
function getGroupStructure(option) {
    $("#group-table tbody").empty();

    console.log(option[option.selectedIndex].id)

    BX.ajax({
        url: '/api.php',
        data: {
            sessid: BX.bitrix_sessid(),
            type: 'getGroupStructure',
            groupID: option[option.selectedIndex].id
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
            if(data!=='error') {
                number=1
                data.map(function (item) {
                    newBodyContent = '<tr role="row" class="odd"  ondragstart = "dragStart(event)" ondrag = "dragging(event)" ondragend = "dragEnd(event)" draggable = "true" id ="' + item["ID"] + '">\n' +
                        '                        <td draggable = "false" align="center"><a draggable = "false" href="javascript:void(0)">' + number + '</a></td>\n' +
                        '                        <td draggable = "false" align="center"><a draggable = "false" href="javascript:void(0)">' + item["PROPERTY_DOGOVOR_VALUE"] + '</a></td>\n' +
                        '                        <td draggable = "false" ><a draggable = "false" href="javascript:void(0)">' + item["PROPERTY_LAST_NAME_VALUE"] + ' ' + item["PROPERTY_NAME_VALUE"] + '</a></td>' +
                        '                        <td draggable = "false" align="right"><a href="javascript:void(0)" onclick="deleteInGroup(this.id)" id ="' + item["ID"] + '"  class="btn btn-outline-danger"><i class="gi gi-circle_arrow_right"></i></a></td>\n' +
                        '                    </tr>';
                    $("#group-table tbody").append(newBodyContent);
                    console.log(item)
                    number++
                })
            }
            else{
                newBodyContent = '<tr role="row" class="odd"  ondragstart = "dragStart(event)" ondrag = "dragging(event)" ondragend = "dragEnd(event)"  id ="clear">\n' +
                    '                        <td colspan="2">Добавте студента</td>\n' +
                    '                    </tr>';
                $("#group-table tbody").append(newBodyContent);
            console.log('test')
            }

        }
    });
}


        function refreshGroupStructure(option) {
            $("#group-table tbody").empty();
            BX.ajax({
                url: '/api.php',
                data: {
                    sessid: BX.bitrix_sessid(),
                    type: 'getGroupStructure',
                    groupID: option
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
                    if(data!=='error') {
                        data.map(function (item) {
                            newBodyContent = '<tr role="row" class="odd"  ondragstart = "dragStart(event)" ondrag = "dragging(event)" ondragend = "dragEnd(event)" draggable = "true" id ="' + item["ID"] + '">\n' +
                                '                        <td><a href="javascript:void(0)">' + item["PROPERTY_DOGOVOR_VALUE"] + '</a></td>\n' +
                                '                        <td><a href="javascript:void(0)">' + item["PROPERTY_LAST_NAME_VALUE"] + ' ' + item["PROPERTY_NAME_VALUE"] + '</a></td>\n' +
                                '                        <td draggable = "false" align="right"><a href="javascript:void(0)" onclick="deleteInGroup(this.id)" id ="' + item["ID"] + '"  class="btn btn-outline-danger"><i class="gi gi-circle_arrow_right"></i></a></td>\n' +
                                '                    </tr>';
                            $("#group-table tbody").append(newBodyContent);
                            console.log(item)
                        })
                    }
                    else{
                        newBodyContent = '<tr role="row" class="odd"  ondragstart = "dragStart(event)" ondrag = "dragging(event)" ondragend = "dragEnd(event)"  id ="clear">\n' +
                            '                        <td colspan="2">Добавте студента</td>\n' +
                            '                    </tr>';
                        $("#group-table tbody").append(newBodyContent);
                        console.log('test')
                    }

                }
            });
        }
    </script>
    <div class="row">
        <div class="col-md-6 push">
            <div id="example-datatables2_wrapper" class="dataTables_wrapper form-inline no-footer">
                <div class="row">
                    <div class="col-sm-6 col-xs-5">
                        <div class="dataTables_length" id="example-datatables2_length"><label>
                                <select onchange="getGroupStructure(this)"
                                        name="example-datatables2_length" id="group-list" aria-controls="example-datatables2"
                                        class="form-control">
                                    <option disabled selected value="10">Выберете группу</option>
                                </select></label></div>
                    </div>
                </div>
                <table id="group-table"
                       class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
                       aria-describedby="example-datatables2_info">
                    <thead>
                    <tr role="row">
                        <th class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables3" rowspan="1"
                            colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending"
                            style="width: 90px;">№
                        </th>
                        <th class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables3" rowspan="1"
                            colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending"
                            style="width: 90px;">Договор
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="2"
                            aria-label=" Username: activate to sort column ascending" style="width: 296px;"><i
                                    class="fa fa-user"></i> Участники
                        </th>
                    </tr>
                    </thead>
                    <tbody ondrop="drop(event)" ondragenter = "dragEnter(event)" ondragleave = "dragLeave(event)" ondrop = "drop(event)" ondragover = "allowDrop(event)">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div id="example-datatables3_wrapper" class="">

                <table id="students-table"
                       class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
                       aria-describedby="example-datatables3_info">
                    <thead>
                    <tr role="row">
                        <th class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables3" rowspan="1"
                            colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending"
                            style="width: 90px;">№
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example-datatables3" rowspan="1" colspan="1"
                            aria-label=" Username: activate to sort column ascending" style="width: 296px;"><i
                                    class="fa fa-user"></i>Участники
                        </th>
                    </tr>
                    </thead>
                    <tbody ondrop="dropOut(event)" ondragenter = "dragEnter(event)" ondragleave = "dragLeave(event)" ondragover = "allowDrop(event)">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>