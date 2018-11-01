<?php

use krok\extend\widgets\alert\AlertWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\modules\cabinet\models\Client */

$this->title = Html::encode('Личный кабинет');
?>
<?= AlertWidget::widget(); ?>
<div class="col-xs-12 col-md-8">
    <div class="block-user-data">
        <h1 class="section-title">Мои данные</h1>
        <span class="user-status"><i class="check-user"></i>Зарегистрирован</span>
        <div class="card-user-data">
            <div class="prgress-bar">
                <p>Профиль заполнен</p>
                <div class="progress-wrap">
                    <span class="prgress-status">90%</span>
                    <div class="progress-bg"></div>
                </div>
            </div>
            <?php $form = ActiveForm::begin([
                'fieldConfig' => [
                    'template' => '<span class="input input--juro input-icon">'
                        . '{input}' . PHP_EOL . '{label}{error}'
                        . '<i class="faid-icon icon-redact"></i>'
                        . '</span>',
                    'labelOptions' => [
                        'class' => "input__label input__label--juro"
                    ],
                    'inputOptions' => [
                        'class' => 'input__field input__field--juro',
                        'readonly' => 'readonly',
                    ],
                    'options' => ['class' => 'faild-wrap']
                ],
                'options' => [
                    'class' => ["base-form", "ac-checkmark"]
                ],
            ]); ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                        $esiaOptions = [];
                        if ($model->clientOAuthRelation) {
                            $esiaOptions = [
                                'template' => '<span class="input input--juro input-icon">'
                                    . '{input}' . PHP_EOL . '{label}{error}'
                                    . '</span>',
                            ];
                        }
                        ?>
                        <?= $form->field($model, 'name', $esiaOptions)->label(
                            '<span class="input__label-content input__label-content--juro">'
                            . $model->getAttributeLabel('name')
                            . '</span>'
                        )
                        ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'city')->label(
                            '<span class="input__label-content input__label-content--juro">'
                            . $model->getAttributeLabel('city')
                            . '</span>'
                        )
                        ?>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <?= $form->field($model, 'phone', $esiaOptions)->label(
                            '<span class="input__label-content input__label-content--juro">'
                            . $model->getAttributeLabel('phone')
                            . '</span>'
                        )
                        ?>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <?= $form->field($model, 'login', $model->login ? $esiaOptions : [])->label(
                            '<span class="input__label-content input__label-content--juro">'
                            . $model->getAttributeLabel('login')
                            . '</span>'
                        )
                        ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'work')->label(
                            '<span class="input__label-content input__label-content--juro">'
                            . $model->getAttributeLabel('work')
                            . '</span>'
                        )
                        ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'position')->label(
                            '<span class="input__label-content input__label-content--juro">'
                            . $model->getAttributeLabel('position')
                            . '</span>'
                        )
                        ?>
                    </div>
                    <div class="col-xs-12">
                        <?= $form->field($model, 'birthPlace', $esiaOptions)->label(
                            '<span class="input__label-content input__label-content--juro">'
                            . $model->getAttributeLabel('birthPlace')
                            . '</span>'
                        )
                        ?>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <?= $form->field($model, 'birthDate', $esiaOptions)->label(
                            '<span class="input__label-content input__label-content--juro">'
                            . $model->getAttributeLabel('birthDate')
                            . '</span>'
                        )
                        ?>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <?= $form->field($model, 'gender', $esiaOptions)->label(
                            '<span class="input__label-content input__label-content--juro">'
                            . $model->getAttributeLabel('gender')
                            . '</span>'
                        )
                        ?>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <?= $form->field($model, 'snils', $esiaOptions)->label(
                            '<span class="input__label-content input__label-content--juro">'
                            . $model->getAttributeLabel('snils')
                            . '</span>'
                        )
                        ?>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <?= $form->field($model, 'passportNumber', $esiaOptions)->label(
                            '<span class="input__label-content input__label-content--juro">'
                            . $model->getAttributeLabel('passportNumber')
                            . '</span>'
                        )
                        ?>
                    </div>
                    <div class="col-xs-12">
                        <div class="faild-wrap ac-custom ac-checkbox">
                            <input id="gosWork" name="<?= $model->formName() . '[isPublic]'; ?>"
                                   type="checkbox"
                                <?= $model->isPublic ? 'checked="checked"' : ''; ?>
                                   class="checkbox__field">
                            <label for="gosWork"><?= $model->getAttributeLabel('isPublic'); ?></label>
                        </div>
                    </div>
                    <?php
                    if (!$esiaOptions):
                        ?>
                        <div class="col-xs-12">
                            <p class="lable-top">Изменить пароль</p>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <?= $form->field($model, 'newPassword')
                                ->passwordInput()
                                ->label(
                                    '<span class="input__label-content input__label-content--juro">'
                                    . $model->getAttributeLabel('newPassword')
                                    . '</span>'
                                )
                            ?>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <?= $form->field($model, 'repeatPassword')
                                ->passwordInput()
                                ->label(
                                    '<span class="input__label-content input__label-content--juro">'
                                    . $model->getAttributeLabel('repeatPassword')
                                    . '</span>'
                                )
                            ?>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>
                <button class="btn btn-prime form-send" type="submit" disabled="disabled">Сохранить изменения</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
