const escapeHtml = (unsafe) => {
    return unsafe.replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;').replaceAll('"', '&quot;').replaceAll("'", '&#039;');
};

let arrayId = [];

// Формируем массив по data
const attributes = document.getElementsByClassName('messageBlock');
for (const attribute of attributes) {

    if (attribute.getAttribute('data-notified') == 0) {
        arrayId.push(attribute.getAttribute('id'))
    }
}
$('.messages').animate({scrollTop: $('.messages ul').height()}, "fast");


function newMessage() {
    var message = escapeHtml($('.message-input input').val());

    var socketMessage = to_user_id + '&' + message;

    var room = getNameChat(to_user_id, from_user_id);

    dataRoom = {
        "to_user_id": to_user_id,
        "from_user_id": from_user_id,
        "room": room,
        "body": message,
    };

    // alert(JSON.stringify(dataRoom));
    socket.send(JSON.stringify(dataRoom));

    socket.onmessage = function (event) {

        data = JSON.parse(event.data)
        // console.log(event.data);

        arrayId.push(data.id);
        let date = new Date(data.date);
        if ($.trim(message) == '') {
            message = $('.message-input .emoji-wysiwyg-editor').html();
            if ($.trim(message) == '') {
                return false;
            }
        }
        $(`<li class="sent"> <div class="myClass">
<div id="` + data.id + `" data-id="` + data.id + `" style="float: right; font-size: 17px; background-color: #dad6f5; " class="messageBlock">
<div class="round-popup">
<button data-id="` + data.id + `" type="button" class="close"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button> </div>
${data.body}<br>
                <small  style="font-size: 10px" class="mb-0 text-left">${date.toLocaleString()}</small >
                </div></div></li>`).appendTo($('.messages ul'));
        $('.message-input input').val('');
        $('.message-input .emoji-wysiwyg-editor').html('');
        $('.messages').animate({scrollTop: $('.messages ul').height()}, "fast");
    };

};

$('.submit').click(function () {
    newMessage();
});

// отправить сообщение по Enter
$("#framechat .content .message-input").keyup(function (event) {
    if (event.keyCode === 13) {
        $(".submit").click();
    }
});


// Удаление сообщения
$('body').on('click', '.close', function () {
    if (!confirm('Подтвердите удаление')) return false;
    let $this = $(this);
    data = {'id': $this.data('id')};
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/delete_message',
        type: 'get',
        data: data,
        dataType: 'json',

        success: function (res) {
            const removeItems = (number) => {
                let elements = document.querySelectorAll(`div[data-id="${number}"]`);
                elements.forEach((e) => {
                    e.remove()
                });
            };
            if (res.answer === 'ok') {
                removeItems($this.data('id'));
            }
        }
    });
});

function getNameChat(one, two) {
    let num = "";

    if (one < two) {
        num = one + '_' + two;
    } else {
        num = two + '_' + one;
    }
    return num;
}
