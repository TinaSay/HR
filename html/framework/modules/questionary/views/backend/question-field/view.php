<?php

use app\modules\questionary\models\Question;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\questionary\models\QuestionField */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Questions Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Update'), ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('system', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('system', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>

    <div class="card-content">
        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'tab',
                    'value' => function ($model) {
                        return Question::TABS[$model->tab];
                    }
                ],
                [
                    'attribute' => 'section',
                    'value' => function ($model) {
                        return Question::SECTIONS[$model->section];
                    }
                ],
                'question.name',
                'name',
                'description',
                [
                    'attribute' => 'type',
                    'value' => function ($model) {
                        return $model::TYPES[$model->type];
                    }
                ],
                'costExpert',
                'costManager',
                'costLeader',
                'obligatory:boolean',
                'hidden:boolean'
            ],
        ]) ?>
    </div>
</div>
