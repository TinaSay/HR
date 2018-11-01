<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\cabinet\models\search\ClientVideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Client Video');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?= GridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'clientId',
                    'format' => ['raw'],
                    'value' => function ($model) {
                        /* @var $model app\modules\cabinet\models\ClientVideo */
                        return Html::a($model->getClientTitle(), Url::to(['/cabinet/client/view/', 'id' => $model->clientId]));
                    }
                ],
                [
                    'attribute' => 'src',
                    'format' => ['raw'],
                    'value' => function ($model) {
                        return Html::a($model->src, $model->src, ['target' => '_blank']);
                    }
                ],
                [
                    'attribute' => 'latest',
                    'filter' => \app\modules\cabinet\models\ClientVideo::getLatestList(),
                    'value' => function ($model) {
                        /* @var $model app\modules\cabinet\models\ClientVideo */
                        return $model->getLatest();
                    }
                ],
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'createdAt',
                ],
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'updatedAt',
                ],

                ['class' => 'yii\grid\ActionColumn','template'=>'{view} {delete}'],
            ],
        ]); ?>

    </div>
</div>
