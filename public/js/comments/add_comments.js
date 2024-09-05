const escapeHtml = (unsafe) => {
    return unsafe.replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;').replaceAll('"', '&quot;').replaceAll("'", '&#039;');
};
// Save Comment
$(".save-comment").on('click', function () {
    var comment = escapeHtml($(".comment").val());
    var recipeId = $(this).data('recipe');
    var vm = $(this);

    // Run Ajax
    $.ajax({
        url: "/save_comment",
        type: "post",
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        data: {
            comment: comment,
            recipe_id: recipeId,
            user_id: userId,
        },

        beforeSend: function () {
            vm.text('Добавляем...').addClass('disabled');

        },
        success: function (res) {
            var html = '<div id="' + res.id + '" data-id="' + res.id + '"><blockquote class="blockquote"><div class="round-popup"><button data-id="' + res.id + '" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>\
                    \
            <small class="mb-0">' + comment + '</small>\
            <br><small style="font-size: 10px" class="mb-0 text-left">'+ res.name + ' ' + res.date + '</small>\
            </blockquote><hr/></div>';
            if (res.bool == true) {
                $(".comments").prepend(html);
                $(".comment").val('');
                $(".comment-count").text($('blockquote').length);
                $(".no-comments").hide();
            }
            vm.text('Добавить').removeClass('disabled');
        }
    });
});