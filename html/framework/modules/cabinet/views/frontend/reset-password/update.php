<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 22.03.18
 * Time: 17:11
 */

use yii\widgets\ActiveForm;

/** @var \app\modules\cabinet\forms\ClientForm $model */
?>
<div class="recovery-step" data-step="3">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '<span class="input input--juro">'
                . '{error}{input}' . PHP_EOL . '{label}'
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
            'class' => ["base-form"],
            'id' => 'new-password-form'
        ],
    ]); ?>
    <div class="row">
        <?= $form->field($model, 'step', [
            'template' => '{input}'
        ])->hiddenInput(); ?>
        <div class="row">
            <div class="col-xs-12">
                <p class="lable-top">Придумайте новый пароль</p>
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
                <button type="submit" class="btn btn-prime">Сохранить</button>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
