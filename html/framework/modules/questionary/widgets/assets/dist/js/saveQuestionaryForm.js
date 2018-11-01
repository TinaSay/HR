$(function () {
    var fields = [];
    $('.base-form')
        .on('focusin', 'input:text, input:checkbox, input:radio, textarea, select', function () {
            var value = $(this).val();
            if ($(this).attr('type') == 'checkbox'
                || $(this).attr('type') == 'radio') {
                value = $(this).prop("checked");
            }
            fields[$(this).attr('name')] = value;
        })
        .on('focusout', 'input:text, input:checkbox, input:radio, textarea, select', function () {
            var name = $(this).attr('name');
            var value = $(this).val();
            var oldValue = fields[name];
            if ($(this).attr('type') == 'checkbox'
                || $(this).attr('type') == 'radio') {
                value = $(this).prop("checked");
            }
            if (oldValue != value) {
                if ($(this).attr('type') == 'radio') {
                    value = $(this).val();
                }
                saveChanges(this, value, name);
            }
        });

    $('.all-done-block .btn-prime')
        .off('click')
        .on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: '/cabinet/questionary/question/send-profile',
                dataType: 'json',
                success: function (response) {
                    redirect(response);
                }
            });
        });
});

function redirect(data) {
    if (data.message) {
        alert(data.message);
    }
    if (data.redirect) {
        window.location.href = data.redirect;
    }
}

function enableCompleteButtonIfAllFilled(data) {
    if (data.allFilled) {
        $('.all-done-block').find('.btn-prime').prop('disabled', false);
    }
}

function saveFile(el) {
    var formData = new FormData();
    formData.append('ImageFile[imageFile]', el.files[0]);
    formData.append('fieldName', $(el).attr('name'));
    $.ajax({
        url: '/cabinet/questionary/question/save-file',
        type: 'POST',
        data: formData,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.result == 'OK') {
                console.log('Изменения сохранены');
                enableCompleteButtonIfAllFilled(data);
            }
        }
    });
}

function saveChanges(el, value, name) {
    if (!value) {
        value = $(el).val();
    }
    if (!name) {
        name = $(el).attr('name');
    }
    if (value && name) {
        data = {
            name: name,
            value: value
        };
    } else {
        data = $(el).serialize();
    }
    $.ajax({
        url: '/cabinet/questionary/question/save-field',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function (data) {
            if (data.result == 'OK') {
                console.log('Изменения сохранены');
                enableCompleteButtonIfAllFilled(data);
            }
        }
    });
}
