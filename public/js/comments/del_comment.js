// Удаление сообщения
$('body').on('click', '.close', function () {
    if (!confirm('Подтвердите удаление')) return false;
    let $this = $(this);
    data = {'id': $this.data('id')};
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/delete-comment',
        type: 'delete',
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
                $(".comment-count").text($('blockquote').length);
            } else {
                alert("У вас нет прав на удаление данного комментария.")
            }
        }
    });
});