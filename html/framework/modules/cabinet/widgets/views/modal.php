<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 10.03.18
 * Time: 13:59
 */

use app\modules\cabinet\forms\ClientForm;
use app\modules\cabinet\widgets\assets\RegisterAsset;
use app\modules\cabinet\widgets\assets\ResetPasswordAsset;
use app\modules\esia\widgets\AuthWidget;
use yii\helpers\Url;

RegisterAsset::register($this);
ResetPasswordAsset::register($this);

$updateUrl = '';
$hash = Yii::$app->session->get(ClientForm::SESSION_PASSWORD_HASH);
if ($hash) {
    $updateUrl = Url::to(['/cabinet/reset-password/update', 'hash' => $hash]);
}
?>
<div id="modalLogIn" class="md-modal md-effect-9">
    <div class="md-content">
        <span class="md-close wind-close"><i class="icon-close"></i></span>
        <div class="autorization-block">
            <div id="autorization-tabs" class="autorization-tabs">
                <ul class="tabs-nav">
                    <li><a href="#log-in" class="tabs_nav login">Войти в личный кабинет</a></li>
                    <li><a href="#registration" class="tabs_nav registration">Регистрация</a></li>
                </ul>
                <div class="tabs_container">
                </div><!--End tabs container-->
            </div><!--End tabs-->
            <div class="autorization-footer">
                <div class="blok-content">
                    <div class="log-in-esia">
                        <p class="name">Войти на сайт через портал Госуслуги</p>
                        <p>Вы можете авторизоваться через Интернет-портал государственных услуг</p>
                        <?= AuthWidget::widget(['name' => 'Войти']); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="recovery-password-block" style="display: none;">
            <div class="block-head">
                <div class="head-content">
                    <h3>Восстановление пароля</h3>
                </div>
                <div class="recovery-progress">
                    <div class="progress-bg"></div>
                </div>
            </div>
            <div class="block-body">
                <div class="recovery-wrap" data-url="<?= $updateUrl; ?>"></div>
                <div class="loader_rec"><img src="/static/default/img/loader.svg"></div>   
            </div>
        </div>
    </div>
</div>
<div class="md-overlay"></div><!-- the overlay element -->
