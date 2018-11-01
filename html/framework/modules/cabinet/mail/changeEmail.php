<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 23.03.18
 * Time: 7:55
 */

use yii\helpers\Url;

/** @var \app\modules\cabinet\models\Client $model */

$url = Url::to([
    '/cabinet/login/change-email',
    'hash' => $model->validateHash
], true);
?>
Здравствуйте!<br>
<br>
Ваш email был изменен на портале “Команда губернатора Нижегородской области”.
Для подтверждения смены e-mail адреса, пожалуйста, пройдите по ссылке  <a href="<?= $url; ?>"><?= $url; ?></a>.<br>
<br>
Если это были не Вы, то удалите это письмо.
В случае многократного получений подобных писем, незамедлительно обратитесь в службу поддержки пользователей Портала.
<br>
<br>
С уважением,<br>
Команда губернатора Нижегородской области.<br>
<?= Url::to(['/'], true); ?>
