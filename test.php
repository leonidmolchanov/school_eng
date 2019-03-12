
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>

<div class="inbox-container clearfix">
    <!-- Inbox Menu -->
    <div id="message-menu" class="inbox-menu">
        <ul  class="nav nav-pills nav-stacked push">
            <li onclick="changeType(this, 'newMessage')">
                <!-- Modal is under the Inbox Container div -->
                <a href="#inbox-compose-modal" data-toggle="modal"><i class="fa fa-pencil"></i> Новое сообщение</a>
            </li>
        </ul>
        <ul class="nav nav-pills nav-stacked push">
            <li  class="active" onclick="changeType(this, 'incoming')">
                <a href="javascript:void(0)"><i class="fa fa-inbox"></i> Входящие <span id="count-inbox" class="inbox-menu-count" style="display: none;"><i class="fa fa-check"></i></span></a>
            </li>
            <li onclick="changeType(this, 'outgoing')">
                <a href="javascript:void(0)"><i class="fa fa-fighter-jet"></i>Исходящие</a>
            </li>
        </ul>

    </div>
    <!-- END Inbox Menu -->

    <!-- Inbox Messages Outer -->
    <div class="inbox-messages-outer">
        <!-- Inbox Messages -->
        <div class="inbox-messages">
            <!-- Inbox Messages List -->
            <div   class="inbox-messages-list">
                <ul class="nav nav-pills nav-stacked" id="inbox-messages-list">

                </ul>
            </div>
            <!-- END Inbox Messages List -->

            <!-- Inbox Messages Content -->
            <div class="inbox-messages-container">
                <!-- Actions -->
                <ul class="inbox-messages-content-actions clearfix">
                    <li><a href="javascript:void(0)" onclick="selectTo()" id="selectTo" style="display: none">Кому</a></li>
                </ul>
                <!-- END Actions -->

                <!-- Message Header -->
                <div class="inbox-messages-content-header content-text" style="display: block;">
                    <img width="10%" id="global-avatar-message" src="" class="pull-left" >
                    <a href="javascript:void(0)"><strong id="global-username-message"></strong></a>
                    <span class="label label-info" id="global-date-message"></span>
                </div>
                <!-- END Message Header -->

                <div class="inbox-messages-content-body" style="display: block;">
                    <p id="global-text-message"></p>
                </div>
                <div class="inbox-messages-content-reply" style="display: block;">
                    <form action="#" method="post" class="form-horizontal remove-margin" onsubmit="return false;">
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea id="global-text-area" name="example-textarea-large" class="form-control" rows="10"></textarea>
                                <input type="hidden" id="global-send-id" />
                                <button onclick="sendMessage()" id="successButton" class="btn btn-success"><i class="fa fa-pencil-square-o"></i> Отправить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Inbox Messages Content -->
        </div>
        <!-- END Inbox Messages -->
    </div>
    <!-- END Inbox Messages Outer -->
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
<script>
    function showFullMenu(){

       let messageList = document.querySelectorAll(".message-item")

        messageList.forEach(function (message) {
message.style.display='block'
            console.log(message.style.display)
        })
        initMessage();
    }
    BX.ready(function() {
        ajaxLoad = function(){
        $('#successButton').hide()

        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'getMessage',
                filter: 'incoming'
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
                $('#inbox-messages-list').empty()
                console.log(data)
                i = 0;
                message = data.map(function (item) {
                    i++
                    return i>7?('<li class="message-item" style="display: none">\n'):('<li class="">\n') +
                        '                        <br><div><img src="'+item.avatar+'" width="40px" height="40px" alt="fakeimg" class="img-circle">' +
                        '<a href="javascript:void(0)" data-avatar ="' + item.avatar + '"  data-from="' + item.from + '"  data-date="' + item.date + '"  id="msg' + i + '" class="">\n' +
                        '                            <span class="inbox-messages-list-username">' + item.name + '</span> <span class="inbox-messages-list-meta">' + item.date + '</span><br>\n' +
                        '                            <span class="inbox-messages-list-preview">' + item.text + '</span>\n' +
                        '                        </a>\n' +
                        '                    </li></div>'


                })



                $('#inbox-messages-list').prepend(message);
                // $('#inbox-messages-list').append('<li class=""><a href="#" onClick="showFullMenu()" > Далее...</a></li>')

                initMessage();
            }


        });
    }
        ajaxLoad()
    });

    initMessage = function() {
        $(function () {

            console.log('run message')
            var msgList = $('.inbox-messages-list');
            var countInbox = $('#count-inbox');
            var linkId, num;

            // Count unread messages and add the number to the inbox
            countInbox.text($('.unread', msgList).length);

            // When a message is clicked
            $('a', msgList).click(function () {
                $('#successButton').show()

                console.log($(this).attr('id'))
                console.log($(this).attr('data-from'))

                $('#global-username-message').html(this.querySelector('.inbox-messages-list-username').innerHTML)
                $('#global-avatar-message').attr('src', $(this).attr('data-avatar'))
                $('#global-date-message').html($(this).attr('data-date'))
                $('#global-text-message').html(this.querySelector('.inbox-messages-list-preview').innerHTML)
                $('#global-send-id').val($(this).attr('data-from'))

                // Message with id 'linkId' was clicked (for loading the message or marking it as read in your backend)
                linkId = $(this).attr('id');

                // Just a small effect you could apply when loading a message
                $('.inbox-messages-container > div').hide(250, function () {

                    // New content should be loaded here
                    // ...

                    $(this).slideDown(250);
                });

                // Remove .active class from every message
                $('li', msgList).removeClass('active');

                // Add the class .active to its parent li
                $(this).parent('li').addClass('active');

                // Remove class .unread if there is one and update the inbox unread number
                if ($(this).hasClass('unread')) {

                    // Remove .unread class
                    $(this).removeClass('unread');

                    // Get the unread messages number
                    num = parseInt(countInbox.text());

                    // Hide the number if all the messages are read else the number goes minus 1!
                    if (num === 1) {
                        countInbox.slideUp(50, function () {
                            $(this).html('<i class="fa fa-check"></i>').slideDown(50, function () {
                                $(this).fadeOut(500);
                            });
                        });
                    } else {
                        countInbox.slideUp(50, function () {
                            $(this).text(num - 1).slideDown(50);
                        });
                    }
                }
            });
        });
    }

function changeType(element, type) {
    $("#message-menu li").removeClass("active");
    $(element).addClass("active");

if(type!=='newMessage'){
    $('#selectTo').hide()
        $('#successButton').hide()

    $('.inbox-messages-list').show()
    BX.ajax({
        url: '/api.php',
        data: {
            sessid: BX.bitrix_sessid(),
            type: 'getMessage',
            filter: type
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
            $('#inbox-messages-list').empty()

            console.log(data)
            i = 0;
            message = data.map(function (item) {
                i++
                return i>7?('<li class="message-item" style="display: none">\n'):('<li class="">\n') +
                    '                        <br><div><img src="'+item.avatar+'" width="40px" height="40px" alt="fakeimg" class="img-circle">' +
                    '                        <a href="javascript:void(0)" data-avatar ="' + item.avatar + '"  data-from="' + item.from + '"  data-date="' + item.date + '"  id="msg' + i + '" class="">\n' +
                    '                            <span class="inbox-messages-list-username">' + item.name + '</span> <span class="inbox-messages-list-meta">' + item.date + '</span><br>\n' +
                    '                            <span class="inbox-messages-list-preview">' + item.text + '</span>\n' +
                    '                        </a>\n' +
                    '                    </li></div>'

            })
            $('#inbox-messages-list').prepend(message);
            initMessage();
        }


    });
}
else{
    $('#selectTo').show()

    $('#successButton').show()

    $('.inbox-messages-list').hide()
}
}
function sendMessage() {
console.log($('#global-text-area').val())
    console.log($('#global-send-id').val())
if($('#global-text-area').val() && $('#global-send-id').val()) {
    BX.ajax({
        url: '/api.php',
        data: {
            sessid: BX.bitrix_sessid(),
            type: 'sendMessage',
            text: $('#global-text-area').val(),
            to: $('#global-send-id').val()

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
            $('#global-text-area').val('')
        }


    });
}
}

function selectUser(id, name, avatar) {
    console.log(avatar)
    $('#global-avatar-message').attr('src', avatar)
    $('#global-username-message').html(name)
    $('#global-send-id').val(id)
    $("#user-list-modal").hide();


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
        '                                <a href="#" data-id="'+item['NAME']+'" data-avatar ="'+item['AVATAR']+'" data-name ="'+item['LAST_NAME']+' '+item['NAME']+'" onclick="selectUser(this.dataset.id, this.dataset.name, this.dataset.avatar)">'+item['LAST_NAME']+' '+item['NAME']+'</a>\n' +
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

</script>
<script>

    document.addEventListener("DOMContentLoaded", function(event) {
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

                    console.log(module_id, command, params);
                    url = 'https://erperp.ru/<?=SITE_TEMPLATE_PATH?>/js/message.mp3';
                    play(url)
                    ajaxLoad()
                }
            }, this))

    });


    document.querySelector('#global-text-area').addEventListener('keypress', function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) { // 13 is enter
            sendMessage()
        }
    });
</script>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
