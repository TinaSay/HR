var connectionStatus = true;
$(function () {
    $timer = setInterval(function () {
        $.ajax({
            url: '/cabinet/default/index',
            dataType: 'json',
            success: function (data) {
            },
            error: function (response, status, reason) {
                if (connectionStatus && reason == 'Forbidden') {
                    clearInterval($timer);
                    connectionStatus = false;
                    alert('Ваш сеанс окончен, авторизуйтесь снова');
                    location.href = '/';
                }
            }
        });
    }, 5000);
});
