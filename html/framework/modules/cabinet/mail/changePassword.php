<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 21.03.18
 * Time: 19:22
 */

use yii\helpers\Url;

$url = Url::to([
    '/cabinet/reset-password/update',
    'hash' => $model->validateHash
], true);
?>
Здравствуйте!<br>
<br>
<?= date('d.m.Y'); ?> в <?= date('H:i'); ?> на Портале “Команда губернатора Нижегородской области” был использован сервис восстановления доступа к Вашему личному кабинету.
<br>
<br>
Если сервисов воспользовались Вы, то для продолжения процедуры восстановления пароля перейдите по ниже указанной ссылке:
<br>
<a href="<?= $url; ?>"><?= $url; ?></a><br>
<br>
Если это были не Вы, то удалите это письмо.
В случае многократного получений подобных писем, незамедлительно обратитесь в службу поддержки пользователей Портала.
<br>
<br>
С уважением,<br>
Команда губернатора Нижегородской области.<br>
<?= Url::to(['/'], true); ?>
