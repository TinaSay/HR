<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 18.03.18
 * Time: 19:31
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
    <div id="reg-step-4" class="reg-step-card active" style="display: block;">
        <div class="reg-message">
            <h4>Мы почти закончили...</h4>
            <p>Вам на почту отправлено письмо. Пожалуйста, перейдите в нем по ссылке для подтверждения корректности
                указанных данных.</p>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
