<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 04.02.16
 * Time: 0:12
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model krok\cabinet\models\Login */
/* @var $form ActiveForm */
?>

<div id="log-in" class="tabs-card">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '<span class="input input--juro">'
                . '{input}' . PHP_EOL . '{label}{error}'
                . '</span>',
            'labelOptions' => [
                'class' => "input__label input__label--juro",
            ],
            'inputOptions' => [
                'class' => 'input__field input__field--juro',
            ],
            'options' => ['class' => 'faild-wrap']
        ],
        'options' => [
            'class' => ["base-form", "blok-content"],
            'id' => 'login-form'
        ],
    ]); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <?= $form->field($model, 'login')
                ->label(
                    '<span class="input__label-content input__label-content--juro">'
                    . $model->getAttributeLabel('login')
                    . '</span>'
                ) ?>
        </div>
        <div class="col-xs-12 col-sm-6">
            <?= $form->field($model, 'password')
                ->passwordInput()
                ->label(
                    '<span class="input__label-content input__label-content--juro">'
                    . $model->getAttributeLabel('password')
                    . '</span>'
                ) ?>
            <span data-url="<?= Url::to(['/cabinet/reset-password']); ?>" onclick="showRecovery(this);" class="forgot-pass">Забыли пароль?</span>
        </div>
        <div class="col-xs-12">
            <button class="btn btn-prime" type="submit">Войти</button>
            <div class="loader"><img src="/static/default/img/loader.svg"></div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
