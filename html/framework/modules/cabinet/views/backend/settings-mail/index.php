<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 15.03.18
 * Time: 13:20
 */

use app\modules\cabinet\forms\SettingsMailForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model SettingsMailForm */

$this->title = Yii::t('system', 'Settings mail');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('system', 'Settings mail'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Update'), ['update'], [
                'class' => 'btn btn-primary'
            ]) ?>
        </p>
    </div>

    <div class="card-content">
        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                'senderName',
                'email',
                'host',
                'username',
                'hiddenPassword',
                'port',
                'encryption',
            ],
        ]) ?>
    </div>
</div>
