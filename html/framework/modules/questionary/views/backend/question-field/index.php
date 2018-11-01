<?php

use app\modules\questionary\models\Question;
use app\widgets\SortableGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var \app\modules\questionary\models\QuestionFieldSearch $searchModel */

$this->title = Yii::t('system', 'Questions Fields');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Create'), ['create'], [
                'class' => 'btn btn-success'
            ]) ?>
        </p>
    </div>

    <div class="card-content">
        <?= SortableGridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'orderUrl' => ['order'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'section',
                    'value' => function ($model) {
                        return Question::SECTIONS[$model->section] ?? null;
                    }
                ],
                'question.name',
                'name',
                'description',
                [
                    'attribute' => 'type',
                    'value' => function ($model) {
                        return $model::TYPES[$model->type] ?? null;
                    }
                ],
                'costExpert',
                'costManager',
                'costLeader',
                'obligatory:boolean',
                'hidden:boolean',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
