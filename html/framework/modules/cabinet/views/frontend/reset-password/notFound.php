<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 23.03.18
 * Time: 15:52
 */

use yii\helpers\Url;

/** @var \app\modules\cabinet\models\Client $model */
?>
<div class="recovery-step" data-step="2_alt">
    <p>Пользователь с адресом электронной почты <span class="text-mail"><?= $model->login; ?></span> на портале не зарегистрирован.</p>
    <div class="btn-wrap">
        <div data-tab="registration" onclick="showRegistration(this);"
	         class="showRegistration btn btn-prime">Зарегистрироваться
	    </div>
	    <div data-url="<?= Url::to(['/cabinet/reset-password']); ?>" onclick="showRecovery(this);"
	         class="setStep btn btn-prime">Назад
	    </div>	
    </div>  
</div>
