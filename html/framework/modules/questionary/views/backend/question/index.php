<?php

use app\modules\questionary\models\Question;
use app\widgets\SortableGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Questions');
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
            'orderUrl' => ['order'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
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
                'name',
                'description',
                'hidden:boolean',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
