<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 15.03.18
 * Time: 13:21
 */

use app\modules\cabinet\forms\SettingsMailForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model SettingsMailForm */
?>

<?= $form->field($model, 'senderName')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'host')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'hiddenPassword')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'port')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'encryption')->textInput(['maxlength' => true]) ?>
