<?php

/* @var $this yii\web\View */

use app\modules\questionary\models\Question;
use app\modules\questionary\models\QuestionField;

/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\questionary\models\QuestionField */
?>

<?= $form->field($model, 'questionaryQuestionId')->dropDownList(Question::getAsDropDown()) ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'type')->dropDownList(QuestionField::TYPES) ?>

<?= $form->field($model, 'costExpert')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'costManager')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'costLeader')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'obligatory')->dropDownList(QuestionField::getObligatoryList()) ?>

<?= $form->field($model, 'hidden')->dropDownList($model::getHiddenList()) ?>

