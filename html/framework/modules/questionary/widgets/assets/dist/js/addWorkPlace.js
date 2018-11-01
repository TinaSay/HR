$(function () {
    $('.work-place-button').on('click', function () {
        var name = $('.work-place-area').data('name');
        $.ajax({
            url: '/cabinet/questionary/question/add-work-place',
            dataType: 'json',
            data: {
                name: name
            },
            success: function (data) {
                if (data.result == 'OK') {
                    $('.work-place-area').append(data.data);
                    initSelect();
                }
            }
        });

    });
});
