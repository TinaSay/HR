<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 10.03.18
 * Time: 16:37
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
                'onkeyup' => 'sendDataToServer(this);'
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
    <div id="reg-step-1" class="reg-step-card active">
        <?= $form->field($model, 'step', [
            'template' => '{input}'
        ])->hiddenInput(); ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="reg-step-head">
                    <span class="reg-step">ШАГ 1/3</span>
                    <p>Контактная информация</p>
                </div>
            </div>
            <div class="col-xs-12">
                <?= $form->field($model, 'name')->label(
                    '<span class="input__label-content input__label-content--juro">'
                    . $model->getAttributeLabel('name')
                    . '</span>'
                ) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= $form->field($model, 'phone')->label(
                    '<span class="input__label-content input__label-content--juro phone-faild">'
                    . $model->getAttributeLabel('phone')
                    . '</span>'
                ) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= $form->field($model, 'login')->label(
                    '<span class="input__label-content input__label-content--juro">'
                    . $model->getAttributeLabel('login')
                    . '</span>'
                ) ?>
            </div>
            <div class="col-xs-12 col-sm-8">
                <?= $form->field($model, 'agree', [
                    'template' => '{input}' . PHP_EOL . '{label}{error}',
                    'options' => [
                        'class' => 'faild-wrap ac-custom ac-checkbox',
                    ],
                ])->checkbox() ?>
            </div>
            <div class="col-xs-12 col-sm-4">
                <button type="submit" class="btn btn-prime">Далее</button>
                <div class="loader"><img src="/static/default/img/loader.svg"></div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
