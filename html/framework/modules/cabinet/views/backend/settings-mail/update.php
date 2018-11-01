<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 15.03.18
 * Time: 13:20
 */

use app\modules\cabinet\forms\SettingsMailForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model SettingsMailForm */

$this->title = Yii::t(
        'system', 'Update')
    . ' : '
    . Yii::t('system', 'Settings mail'
    );
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('system', 'Settings mail'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = Yii::t('system', 'Update');
?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?php $form = ActiveForm::begin(); ?>

        <?= $this->render('_form', ['form' => $form, 'model' => $model]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('system', 'Save'),
                ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
