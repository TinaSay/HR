$(function () {
    $('body')
        .off('beforeSubmit', 'form#recovery-form')
        .on('beforeSubmit', 'form#recovery-form', function () {
            sendResetPasswordData(this, 2);

            return false;
        })
        .off('beforeSubmit', 'form#new-password-form')
        .on('beforeSubmit', 'form#new-password-form', function () {
            sendResetPasswordData(this, 4);

            return false;
        });

    changePassword();
});

function changePassword() {
    var url = $('.recovery-wrap').data('url');
    if (url) {
        $('#modalLogIn').addClass('md-show');
        showRecovery($('.recovery-wrap'));
        setStepProgress(3);
    }
}

function sendResetPasswordData(el, nextStep) {
    var form = $(el),
        button = $(el).find('button'),
        loader = $('.recovery-password-block .loader_rec');
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
            $('.recovery-wrap').html(data);
            loader.fadeOut(0);
            button.fadeIn(200);
            setStepProgress(nextStep);
        },
        error: function () {
            console.log('internal server error');
            button.fadeIn(200);
        }
    });
}

function setStepProgress(step) {
    var val = (100 / 4) * Number.parseInt(step);
    $('.recovery-progress .progress-bg').css('width', val + '%');
}

// recovery password
function showRecovery(el) {
    if (el) {
        $.ajax({
            type: 'POST',
            url: $(el).data('url'),
            success: function (data) {
                $('.recovery-wrap').html(data);
            },
            error: function () {
                console.log('internal server error');
            }
        });
    }
    $('.autorization-block').fadeOut(0);
    $('.recovery-password-block').fadeIn(200);
    setStepProgress(1);
}

function showRegistration(el) {
    $('.tabs_nav.' + $(el).data('tab')).trigger('click');
    $('.recovery-password-block').fadeOut(0);
    $('.autorization-block').fadeIn(200);
}
