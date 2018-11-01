<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 10.03.18
 * Time: 16:38
 */

use app\modules\cabinet\forms\ClientForm;
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
    <div id="reg-step-3" class="reg-step-card">
        <?= $form->field($model, 'step', [
            'template' => '{input}'
        ])->hiddenInput(); ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="reg-step-head">
                    <span class="reg-step">ШАГ 3/3</span>
                    <p>Информация о месте работы</p>
                </div>
            </div>
            <div class="col-xs-12">
                <?= $form->field($model, 'work')->label(
                    '<span class="input__label-content input__label-content--juro">'
                    . $model->getAttributeLabel('work')
                    . '</span>'
                ) ?>
            </div>
            <div class="col-xs-12">
                <?= $form->field($model, 'position')->label(
                    '<span class="input__label-content input__label-content--juro">'
                    . $model->getAttributeLabel('position')
                    . '</span>'
                ) ?>
            </div>
            <div class="col-xs-12">
                <?= $form->field($model, 'isPublic', [
                    'template' => '{input}' . PHP_EOL . '{label}{error}',
                    'options' => [
                        'class' => 'faild-wrap ac-custom ac-checkbox',
                    ],
                ])->checkbox() ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <a href="javascript:void();" onclick="loadStep(this, '<?= ClientForm::SCENARIO_STEP_FIRST; ?>');"
                   class="link-back">Назад</a>
            </div>
            <div class="col-xs-12 col-sm-6">
                <button type="submit" class="btn btn-prime">Зарегистрироваться</button>
                <div class="loader"><img src="/static/default/img/loader.svg"></div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
