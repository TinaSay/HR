<?php

/* @var $this yii\web\View */

use app\modules\questionary\models\QuestionField;

/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\questionary\models\QuestionFieldValue */
?>
<?= $form->field($model, 'questionaryQuestionFieldId')->dropDownList(QuestionField::getListWithQuestion()) ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'costExpert')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'costManager')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'costLeader')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'hidden')->dropDownList($model::getHiddenList()) ?>

