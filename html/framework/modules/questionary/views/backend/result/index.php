<?php

use krok\extend\widgets\export\ExportWidget;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel krok\cabinet\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Client');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Create'), ['create'], [
                'class' => 'btn btn-success',
            ]) ?>
        </p>
    </div>
    <?php
    $widget = ExportWidget::begin([]);
    $widget::end();
    ?>

    <div class="card-content">
        <?= GridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                'city',
                'work',
                'position',
                'phone',
                [
                    'attribute' => 'rating',
                    'filter' => Html::activeDropDownList($searchModel, 'clientRating',
                        [
                            10 => 'больше 20',
                            40 => 'больше 40',
                            60 => 'больше 60',
                            80 => 'больше 80',
                            90 => 'больше 90',
                        ],
                        ['class' => 'form-control', 'prompt' => 'выберите']),
                ],
                'goalReserve:boolean',
                'goalMinister:boolean',
                'readyMunicipal:boolean',
                'readyMove:boolean',
//                [
//                    'attribute' => 'questionaryFilledPercent',
//                    'filter' => Html::activeDropDownList($searchModel, 'filledPercent',
//                        [
//                            10 => 'больше 20',
//                            40 => 'больше 40',
//                            60 => 'больше 60',
//                            80 => 'больше 80',
//                            90 => 'больше 90',
//                        ],
//                        ['class' => 'form-control', 'prompt' => 'выберите']),
//                ],
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'createdAt',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                ],
            ],
        ]); ?>
    </div>
</div>
