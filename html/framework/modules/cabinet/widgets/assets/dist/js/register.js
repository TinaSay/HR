function reInitForm() {
    initChecbox();
    var inputs = $('.autorization-tabs .input__field');
    for (var i = 0; i < inputs.length; i++) {
        if ($(inputs[i]).val() !== '') {
            $(inputs[i]).parent().addClass('input--filled');
        }
    }
    $('.input__field')
        .on('focus', function (ev) {
            if ($(this).attr('readonly') == 'readonly') {
                return;
            }
            $(this).parent().addClass('input--filled');
        })
        .on('blur', function (ev) {
            if ($(this).val() == '') {
                $(this).parent().removeClass('input--filled');
            }
        });
}

$(function () {
    $('.tabs_nav.login')
        .off('click')
        .on('click', function () {
            $('.recovery-password-block').fadeOut(0);
            $('.autorization-block').fadeIn(200);
            $.ajax({
                url: '/cabinet/login/login',
                success: function (data) {
                    $('.autorization-tabs .tabs_nav.login').addClass('active');
                    $('.autorization-tabs .tabs_nav.registration').removeClass('active');
                    $('.tabs_container').html(data);
                    reInitForm();
                }
            });
        });
    $('.tabs_nav.registration')
        .off('click')
        .on('click', function (event, goal) {
            $('.recovery-password-block').fadeOut(0);
            $('.autorization-block').fadeIn(200);
            var urlSuffix = '';
            if (goal) {
                urlSuffix = '?goal=' + goal;
            }
            $.ajax({
                url: '/cabinet/register/register' + urlSuffix,
                success: function (data) {
                    $('.autorization-tabs .tabs_nav.login').removeClass('active');
                    $('.autorization-tabs .tabs_nav.registration').addClass('active');
                    $('.tabs_container').html(data);
                    reInitForm();
                }
            });
        });

    $('body')
        .off('beforeSubmit', 'form#registration-form')
        .on('beforeSubmit', 'form#registration-form', function () {
            sendAuthData(this);

            return false;
        })
        .off('beforeSubmit', 'form#login-form')
        .on('beforeSubmit', 'form#login-form', function () {
            sendAuthData(this);

            return false;
        });
});

function sendAuthData(el) {
    var form = $(el),
        button = $(el).find('button'),
        loader = $(el).find('.loader');
    if (form.find('.has-error').length) {
        return false;
    }
    button.fadeOut(0);
    loader.fadeIn(200);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function (data) {
            loader.fadeOut(0);
            button.fadeIn(200);
            $('.tabs_container').html(data);
            reInitForm();
        },
        error: function () {
            console.log('internal server error');
            loader.fadeOut(0);
            button.fadeIn(200);
        }
    });
}

function sendDataToServer(el) {
    var form = $(el).closest('form');
    var data = $(el).serialize() + '&key=1';
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: data,
        success: function (data) {
        },
        error: function () {
            console.log('internal server error');
        }
    });
}

function loadStep(el, step) {
    var button = $(el),
        loader = $(el).parent().find('.loader');
    var form = $('form#registration-form');
    if (step == '') {
        $('form#registration-form').find('#clientform-step').remove();
    } else {
        $('form#registration-form').find('#clientform-step').val(step);
    }
    button.fadeOut(0);
    loader.fadeIn(200);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function (data) {
            $('.tabs_container').html(data);
            reInitForm();
            loader.fadeOut(0);
            button.fadeIn(200);
        },
        error: function () {
            console.log('internal server error');
            loader.fadeOut(0);
            button.fadeIn(200);
        }
    });
}
