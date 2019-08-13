<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;
?>

<div class="row">
<?
$isAdmin=1;
$isMethodist=9;
$isTeacher=8;
$isStudent=7;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
global $USER;
$privilege=0;
$arGroups = $USER->GetUserGroupArray();
foreach ($arGroups as $state){
    if($state==$isAdmin){
        $privilege=1;
    }
    else if($state==$isMethodist){
        $privilege=2;
    }
    else if($state==$isTeacher){
        $privilege=3;
    }
    else if($state==$isStudent){
        $privilege=4;
    }
}

if($privilege==1 || $privilege==2){
    ?>
    <div class="row" style="margin-left:0px; margin-bottom: 3px">
    <div class="col-md-1">
        <button class="btn btn-warning" style="display: block; margin-right:0px;" onclick="selectGroup()" id="showGroupPopupButton">Группы</button>
    </div>
    <div class="col-md-2">
        <button class="btn btn-warning" style="display: block; margin-left:0px;" onclick="selectTo()" id="showGroupPopupButton">Выбрать получателя</button>
    </div>
    <div class="col-md-2">
        <button class="btn btn-success" style="display: none" id="selectBroadcastGroupSubmit">Отправить в группу</button>
    </div>
        <div class="col-md-2">
            <span class="label label-warning group-name"></span>
        </div>
    </div>
    <?
}
else if($privilege==3){
    $teacher=0;
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("NAME" => "ASC"),
            Array("IBLOCK_CODE" => 'TEACHER', "PROPERTY_USER"=> $USER->GetID()),
            false,
            false,
            Array('ID', 'NAME','PROPERTY_TEACHER')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            $teacher =  $ar_fields['PROPERTY_TEACHER_VALUE'];
        }
    endif;

    ?>

    <div class="row" style="margin-left:0px; margin-bottom: 3px">

    <div class="col-md-1">
        <button class="btn btn-warning" style="display: block; margin-right:0px; onclick="selectGroup()" id="showGroupPopupButton">Группы</button>
    </div>
    <div class="col-md-2">
        <button class="btn btn-warning" style="display: block; margin-left:0px; onclick="selectTo()" id="showGroupPopupButton">Выбрать получателя</button>
    </div>
    <div class="col-md-2">
        <button class="btn btn-success" style="display: none" id="selectBroadcastGroupSubmit">Отправить в группу</button>
    </div>
        <div class="col-md-2">
            <span class="label label-warning group-name"></span>
        </div>
    </div>
    <?
}
?>
</div>
    <div class="chat-container clearfix">
                        <!-- Chat People -->
                        <div class="chat-people">
                            <ul class="chat-people-list">
                            </ul>
                        </div>
                        <!-- END Chat People -->

                        <!-- Chat Messages -->
                        <div class="chat-messages">
                            <ul class="chat-messages-list">
                            </ul>
                        </div>
                        <!-- END Chat Messages -->
                    </div>



    <div class="chat-input">
        <div class="chat-input-inner">
                <input  type="text" id="chat-message" name="chat-message" class="form-control" placeholder="Введите сообщение" style="display: none">

        </div>
    </div>



    <div id="user-list-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;"><div class="modal-backdrop  in" style="height: 833px;"></div>
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onClick="closePopup()" data-dismiss="modal">×</button>
                    <h4>Выбор получателя</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 push">

                        <table id="users-table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="user_table_info">
                            <thead>
                            <tr role="row"><th rowspan="1" colspan="1" class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2" aria-label="
                #
            " style="width: 59px;">
                                    #
                                </th><th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="user_table" aria-label="
                 Фамилия Имя
            : activate to sort column ascending" style="width: 314px;">
                                    Фамилия Имя студента
                                </th></tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" onClick="closePopup()">Закрыть</button>
                    </div>
                </div>
            </div>
            <!-- END Modal Content -->
        </div>
    </div>

    <div id="group-list-modal" class="modal in" aria-hidden="false" style="display: none; padding-right: 0px;"><div class="modal-backdrop  in" style="height: 833px;"></div>
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onClick="closeGroupPopup()" data-dismiss="modal">×</button>
                    <h4>Выбор получателя</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 push">

                        <table id="group-table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="user_table_info">
                            <thead>
                            <tr role="row"><th rowspan="1" colspan="1" class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2" aria-label="
                #
            " style="width: 59px;">
                                    #
                                </th><th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="user_table" aria-label="
                 Группа
            : activate to sort column ascending" style="width: 314px;">
                                    Группа
                                </th></tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" onClick="closeGroupPopup()">Выбрать</button>
                        <button class="btn btn-danger" onClick="closeGroupPopup()">Закрыть</button>
                    </div>
                </div>
            </div>
            <!-- END Modal Content -->
        </div>
    </div>
    <script>
        groupList=[];
let broadcastGroupId;
        <?
        if($privilege==1 || $privilege==2) {

        if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("NAME" => "ASC"),
            Array("IBLOCK_CODE" => 'GROUP'),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_TEACHER')
        );

        while ($ar_fields = $my_elements->GetNext()) {
        ?>
        groupList.push({id:<?= $ar_fields['ID'] ?>,name:"<?= $ar_fields['NAME'] ?>"})
    <?
}
endif;

}
    else if($privilege==3){
    $teacher = 0;
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("NAME" => "ASC"),
            Array("IBLOCK_CODE" => 'TEACHER', "PROPERTY_USER" => $USER->GetID()),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_TEACHER')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            $teacher = $ar_fields['PROPERTY_TEACHER_VALUE'];
        }
    endif;

    ?>

        <?
        if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("NAME" => "ASC"),
            Array("IBLOCK_CODE" => 'GROUP', "PROPERTY_TEACHER" => $teacher),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_TEACHER')
        );

        while($ar_fields = $my_elements->GetNext())
        {
        ?>
        groupList.push({id:<?= $ar_fields['ID'] ?>, name: "<?= $ar_fields['NAME'] ?>"})

        <?
        }

        endif;
        }
?>
        function selectGroup() {
            console.log(groupList)
            $("#group-list-modal tbody").empty()
            let number=1
            let tableContent=groupList.map(function (item) {
                number++
                return ( '\n' +
                    '                        <tr role="row" class="odd">\n' +
                    '                            <td class="text-center sorting_1">\n' +
                    '                               '+number+'               </td>\n' +
                    '                            <td>\n' +
                    '                                <a href="#" id="'+item.id+'" name="'+item.name+'"  data-name ="'+item.name+'" onclick="selectGroupsetID(this.id, this.name)">'+item.name+'</a>\n' +
                    '                            </td>\n' +
                    '                        </tr>')
            })

            $("#group-table tbody").append(tableContent);

            $("#group-list-modal").show();
            /* Initialize Datatables */
            $('#group-table').dataTable();
            $('.dataTables_filter input').attr('placeholder', 'Поиск');
        };

function selectGroupsetID(id, name) {
    broadcastGroupId = id;
    document.querySelector('#chat-message').value = ''
    document.querySelector('#chat-message').style.display='block'
    $("#group-list-modal").hide();
    $("#selectBroadcastGroupSubmit").show()
    $('.group-name').html(name)


    $('#global-text-message').html('')
    BX.ajax({
        url: '/api.php',
        data: {
            sessid: BX.bitrix_sessid(),
            type: 'getListUserMessage',
            group: true,
            groupID: id

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
$(".chat-people-list").empty()
            data.forEach(function (item) {

                $('.chat-people-list').prepend('<li class="new-chat-user" >\n' +
                    '                                    <a href="javascript:void(0)" class="new-chat-user-a"  data-id="' + item['ID'] + '"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Online!">\n' +
                    '                                        <img src="' + item['AVATAR'] + '" alt="avatar" width="40">\n' +
                    '                                        <span class="chat-name">' + item['NAME']+' '+item['LAST_NAME'] + '</span><br>\n' +
                    '                                    </a>\n' +
                    '                                </li>')
            })
        }


    });

}
        function selectTo() {
            $('#global-text-message').html('')
            BX.ajax({
                url: '/api.php',
                data: {
                    sessid: BX.bitrix_sessid(),
                    type: 'getListUserMessage'

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
                    $("#user-list-modal tbody").empty()
                    console.log(data)
                    number=1
                    tableContent=data.map(function (item) {
                        number++
                        return ( '\n' +
                            '                        <tr role="row" class="odd">\n' +
                            '                            <td class="text-center sorting_1">\n' +
                            '                               '+number+'               </td>\n' +
                            '                            <td>\n' +
                            '                                <a href="#" data-id="'+item['ID']+'" data-avatar ="'+item['AVATAR']+'" data-name ="'+item['LAST_NAME']+' '+item['NAME']+'" onclick="selectUser(this.dataset.id, this.dataset.name, this.dataset.avatar)">'+item['LAST_NAME']+' '+item['NAME']+' ('+item['DESCRIPTION']+')</a>\n' +
                            '                            </td>\n' +
                            '                        </tr>')
                    })

                    $("#users-table tbody").append(tableContent);

                    $("#user-list-modal").show();
                    $(function () {
                        /* Initialize Datatables */
                        $('#users-table').dataTable();
                        $('.dataTables_filter input').attr('placeholder', 'Поиск');
                    });
                }


            });
        }
        function closePopup() {
            $("#user-list-modal").hide();

        }
        function closeGroupPopup() {
            $("#group-list-modal").hide();

        }

        function selectUser(id, name, avatar) {
            console.log(id)
            console.log(name)
            console.log(avatar)
            $('.chat-people-list').empty()

            document.querySelector('#chat-message').style.display='block'
            document.querySelector('#chat-message').dataset.id = Number(id)
            $("#user-list-modal").hide();
           let newChatUser = $('.new-chat-user');
           console.log(newChatUser)
if(newChatUser.length==0) {
    $('.chat-people-list').prepend('<li class="new-chat-user" >\n' +
        '                                    <a href="javascript:void(0)" class="new-chat-user-a" style="margin-top: 10px" data-id="' + id + '"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Online!">\n' +
        '                                        <img src="' + avatar + '" alt="avatar" width="40">\n' +
        '                                        <span class="chat-name">' + name + '</span><br>\n' +
        '                                    </a>\n' +
        '                                </li>')

}
else{
    newChatUser.html(' <a href="javascript:void(0)" class="new-chat-user-a"  data-id="' + id + '"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Online!">' +
        '                                               <img src="' + avatar + '" alt="avatar" width="40">' +
        '                                               <span class="chat-name">' + name + '</span><br>' +
        '                                          </a>')
}
        $('.new-chat-user-a').trigger('click');


        }
        <?

        $user="";
        if (CModule::IncludeModule("iblock")):
            # show url my elements
            $my_elements = CIBlockElement::GetList (
                Array("ID" => "desc"),
                Array("IBLOCK_CODE" => 'STUDENTS', 'ID'=>$USER->GetID()),
                false,
                false,
                Array('ID', 'PROPERTY_NAME','PROPERTY_LAST_NAME', 'PROPERTY_USERID')
            );

            while($ar_fields = $my_elements->GetNext())
            {
                $user = $ar_fields['PROPERTY_NAME_VALUE'].' '.$ar_fields['PROPERTY_LAST_NAME_VALUE'];
            }
        endif;
        $dbUser = CUser::GetByID($USER->GetID());
    $arUser = $dbUser->Fetch();
    if ($arUser["PERSONAL_PHOTO"]) {
        $URL = CFile::GetPath($arUser["PERSONAL_PHOTO"]);

    } else {
        $URL = '/local/templates/school_eng/img/noPhoto.png';
    }
    $avatar = 'https://' . SITE_SERVER_NAME . $URL;
    ?>
        let avatar = '<?=$avatar;?>'
        let user = '<?=$user;?>'
        let result = []
        $(function () {
            var peopleList = $('.chat-people-list');
            var messageListCon = $('.chat-messages');
            var messageInput = $('#chat-message');
            var userId, msg;

            // When a user is clicked
            $(peopleList).click(function (ev) {

                if(ev.target.dataset.id) {
                    console.log(ev.target.dataset.id)
                    document.querySelector('#chat-message').style.display='block'
                    document.querySelector('#chat-message').dataset.id = ev.target.dataset.id
                    $('.chat-messages-list').empty()

                        result.forEach(function (item) {
item.content.forEach(function (message) {

    let re = /([^\"=]{2}|^)((https?|ftp):\/\/\S+[^\s.,> )\];'\"!?])/;
    let subst = '$1<a href="$2"  target="_blank"><span class="label label-inverse">$2</span></a>';
    message.text = message.text.replace(re, subst);

console.log( message.text)
    if(message.from==ev.target.dataset.id || message.to==ev.target.dataset.id) {
        if(Number(message.from)==Number(<?=$USER->GetID()?>)){

            $('.chat-messages-list').prepend('<li class="chat-msg-left">\n' +
                '                                    <span class="label label-inverse chat-msg-time"><em></em><em>'+ message.name +'</em></span>\n' +
                '                                    <img src="'+message.avatar+'" width="50" alt="avatar">\n' +
                message.text+'<br>'+message.date+
                '                                </li>')
        }else {
            $('.chat-messages-list').prepend('<li class="chat-msg-right">\n' +
                '                                    <span class="label label-success chat-msg-time"><em></em><em>' + message.name + '</em></span>\n' +
                '                                    <img src="' + message.avatar + '" width="50" alt="avatar">\n' + message.text +'<br>'+message.date+
                '                                </li>')
        }
    }

})
})

                    var objDiv = document.querySelector(".chat-messages");
                    objDiv.scrollTop = objDiv.scrollHeight;

                }

                if(ev.target.dataset.select){
                    console.log('ddd')

                    selectTo()
                }
                // Remove .active class from every user
                $('li', peopleList).removeClass('active');

                // Add the class .active to its parent li
                $(this).addClass('active');

                // User with id 'userId' was clicked (eg for loading chat messages from backend)
                userId = $(this).attr('id');

                //...
            });


        });



            ajaxLoad = function(){
                BX.ajax({
                    url: '/api.php',
                    data: {
                        sessid: BX.bitrix_sessid(),
                        type: 'getMessage',
                        filter: 'all'
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

                        data.forEach(function (item) {
                            if(!result[item.from] && Number(item.from) !== Number(<?=$USER->GetID()?>)){
                                result[item.from]=[]
                                result[item.from].content=[]
                                result[item.from].avatar  = item.avatar
                                result[item.from].name  = item.name
                            }
                            if(Number(item.from) == Number(<?=$USER->GetID()?>))
                            {
                                if(!result[item.to] &&  Number(item.to) !== Number(<?=$USER->GetID()?>)){
                                    result[item.to]=[]
                                    result[item.to].content=[]
                                    result[item.to].avatar  = item.avatarTo
                                    result[item.to].name  = item.nameTo

                                }
                                if(Number(item.to) !== Number(<?=$USER->GetID()?>)) {
                                    console.log('yy'+item.to)
                                    result[item.to].content.push(item)
                                }
                            }
                            else{
                                result[item.from].content.push(item)

                            }
                        })
                       console.log(result)
                        result.forEach(function (item, key) {
                            $('.chat-people-list').append('<li>\n' +
                                '                                    <a href="javascript:void(0)" data-id="'+key+'"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Online!">\n' +
                                '                                        <img src="'+item.avatar+'" data-id="'+key+'" alt="avatar" width="40">\n' +
                                '                                        <span class="chat-name" data-id="'+key+'">'+item.name+'</span><br>\n' +
                                '                                    </a>\n' +
                                '                                </li>')
                        })

                            $('.chat-online:first').trigger('click');

                        // $('.chat-people-list').append('<li>\n' +
                        //     '                                    <a href="javascript:void(0)" data-select="true"  data-toggle="tooltip" data-placement="left" title="" >\n' +
                        //     '                                        <span class="chat-name">Выбрать</span><br>\n' +
                        //     '                                    </a>\n' +
                        //     '                                </li>')
                    }


                });
            }


        document.addEventListener("DOMContentLoaded", function(event) {
            ajaxLoad()





            window.AudioContext = window.AudioContext || window.webkitAudioContext;

            function play(snd) {
                console.log(snd)
                var audioCtx = new AudioContext();

                var request = new XMLHttpRequest();
                request.open("GET", snd, true);
                request.responseType = "arraybuffer";
                request.onload = function () {
                    var audioData = request.response;

                    audioCtx.decodeAudioData(
                        audioData,
                        function (buffer) {
                            var smp = audioCtx.createBufferSource();
                            smp.buffer = buffer;
                            smp.connect(audioCtx.destination);
                            smp.start(0);
                        },
                        function (e) {
                            alert("Error with decoding audio data" + e.err);
                        }
                    );
                };
                request.send();
            }

            document.querySelector('button').addEventListener('click', function () {
                context.resume().then(() => {
                    console.log('Playback resumed successfully');
                });
            });




            BX.addCustomEvent("onPullEvent", BX.delegate(function (module_id, command, params) {
                if(module_id=='message') {

                    console.log(command['FROM_ID']);
                    url = 'https://erperp.ru/<?=SITE_TEMPLATE_PATH?>/js/message.mp3';
                    play(url)

                    if(command['FROM_ID']){
                        if(Number(command['FROM_ID'])==Number(document.querySelector('#chat-message').dataset.id)){

                            let re = /([^\"=]{2}|^)((https?|ftp):\/\/\S+[^\s.,> )\];'\"!?])/;
                            let subst = '$1<a href="$2"  target="_blank"><span class="label label-inverse">$2</span></a>';
                            command['TEXT'] = command['TEXT'].replace(re, subst);

                            $('.chat-messages-list').append('<li class="chat-msg-right">\n' +
                                '                                    <span class="label label-success chat-msg-time"><em></em><em>' + result[document.querySelector('#chat-message').dataset.id].name + '</em></span>\n' +
                                '                                    <img src="' +result[document.querySelector('#chat-message').dataset.id].avatar + '" width="50" alt="avatar">\n' + command['TEXT'] +
                                '                                </li>')


                            var objDiv = document.querySelector(".chat-messages");
                            objDiv.scrollTop = objDiv.scrollHeight;
                        }
                    }

                    if(!result[command['FROM_ID']] && Number(command['FROM_ID']) !== Number(<?=$USER->GetID()?>)){
                        result[command['FROM_ID']]=[]
                        result[command['FROM_ID']].content=[]
                        result[command['FROM_ID']].avatar  = command['avatar'].avatar
                        // result[command['FROM_ID']].name  = item.name

                        // result[item.to].content.push(item)

                    }
                }
            }, this))
        })


        document.querySelector('#chat-message').addEventListener('keypress', function (e) {
            var key = e.which || e.keyCode;
            if (key === 13) { // 13 is enter
                console.log(e.target.value)
                console.log(e.target.dataset.id)
                if(e.target.value && e.target.dataset.id) {
                    sendMessage(e.target.value, e.target.dataset.id)
                }
            }
        });


        function sendMessage(value, id) {
                BX.ajax({
                    url: '/api.php',
                    data: {
                        sessid: BX.bitrix_sessid(),
                        type: 'sendMessage',
                        text: value,
                        to: id

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
                        let re = /([^\"=]{2}|^)((https?|ftp):\/\/\S+[^\s.,> )\];'\"!?])/;
                        let subst = '$1<a href="$2"  target="_blank"><span class="label label-inverse">$2</span></a>';
                        value = value.replace(re, subst);
                        document.querySelector('#chat-message').value = ''
                        $('.chat-messages-list').append('<li class="chat-msg-left">\n' +
                            '                                    <img src="'+avatar+'" width="50" alt="avatar">\n' +
                            value+
                            '                                </li>')
                        var objDiv = document.querySelector(".chat-messages");
                        objDiv.scrollTop = objDiv.scrollHeight;
                        console.log(id)
                        // result[id].content.push({name:'test', text:'test'})


                    }


                });

        }



        let selectBroadcastGroupSubmit = document.querySelector('#selectBroadcastGroupSubmit');

        selectBroadcastGroupSubmit.addEventListener('click', function (e) {
            let value = document.querySelector('#chat-message').value
            console.log(broadcastGroupId)
            if(value) {
                BX.ajax({
                    url: '/api.php',
                    data: {
                        sessid: BX.bitrix_sessid(),
                        type: 'sendMessage',
                        text: value,
                        broadcast: broadcastGroupId,
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
                        if(data=="Success"){

                            Swal({
                                title: 'Отправлено',
                                text: "Групповое сообщение отправлено!",
                                type: 'success',
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Готово'
                            }).then(() => {
                                    window.location.reload()
                                }
                            )

                        }
                    }


                });
            }

            else{
                console.log('Не введено сообщение')
            }
        })
    </script>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>