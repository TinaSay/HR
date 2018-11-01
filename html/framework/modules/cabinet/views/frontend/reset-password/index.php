<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 22.03.18
 * Time: 16:13
 */

use yii\widgets\ActiveForm;

/** @var \app\modules\cabinet\forms\ClientForm $model */
?>

<div class="recovery-step" data-step="1">
    <p class="lable-top">Для восстановления пароля ведите ваш e-mail, указанный при регистрации</p>
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
            'id' => 'recovery-form'
        ],
    ]); ?>
    <?= $form->field($model, 'login')
        ->label(
            '<span class="input__label-content input__label-content--juro">'
            . $model->getAttributeLabel('login')
            . '</span>'
        ) ?>
    <button type="submit" class="btn btn-prime">Продолжить</button>
    <?php ActiveForm::end(); ?>
</div>
