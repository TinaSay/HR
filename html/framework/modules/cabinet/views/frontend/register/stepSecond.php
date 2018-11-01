<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 10.03.18
 * Time: 16:38
 */

use yii\widgets\ActiveForm;

?>

<div id="registration" class="tabs-card">
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
            'options' => [
                'class' => 'faild-wrap',
            ]
        ],
        'options' => [
            'class' => ["base-form", "blok-content", "ac-checkmark", "reg-step-wrap"],
            'id' => 'registration-form'
        ],
    ]); ?>
    <div id="reg-step-2" class="reg-step-card">
        <?= $form->field($model, 'step', [
            'template' => '{input}'
        ])->hiddenInput(); ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="reg-step-head">
                    <span class="reg-step">ШАГ 2/3</span>
                    <p>Пароль для вашего профиля</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= $form->field($model, 'newPassword')
                    ->passwordInput()
                    ->label('<span class="input__label-content input__label-content--juro">' . $model->getAttributeLabel('newPassword') . '</span>') ?>

                <span class="helper">Не менее 8 символов</span>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= $form->field($model, 'repeatPassword')
                    ->passwordInput()
                    ->label('<span class="input__label-content input__label-content--juro">' . $model->getAttributeLabel('repeatPassword') . '</span>') ?>

            </div>
            <div class="col-xs-12">
                <div class="step-fix"></div>
            </div>
            <div class="col-xs-12 col-sm-8">
                <a href="javascript:void();" onclick="loadStep(this, '');" class="link-back">Назад</a>
            </div>
            <div class="col-xs-12 col-sm-4">
                <button type="submit" class="btn btn-prime">Далее</button>
                <div class="loader"><img src="/static/default/img/loader.svg"></div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
