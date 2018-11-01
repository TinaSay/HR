$(function () {
    $('.study-place-button').on('click', function () {
        var name = $('.study-place-area').data('name');
        $.ajax({
            url: '/cabinet/questionary/question/add-study-place',
            dataType: 'json',
            data: {
                name: name
            },
            success: function (data) {
                if (data.result == 'OK') {
                    $('.study-place-area').append(data.data);
                    initSelect();
                }
            }
        });
    });
});
