<?php

use yii\bootstrap\Html as BootstrapHtml;
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

    <div class="card-content">
        <?= GridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'login',
                'name',
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
                [
                    'class' => \krok\extend\grid\BlockedColumn::class,
                    'attribute' => 'blocked',
                ],
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'createdAt',
                ],
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'updatedAt',
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {login-as}',
                    'buttons' => [
                        'login-as' => function ($url, $model) {
                            return Html::a(BootstrapHtml::icon('log-in'),
                                ['login-as', 'id' => $model->id], [
                                    'title' => 'Войти как',
                                ]
                            );
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
