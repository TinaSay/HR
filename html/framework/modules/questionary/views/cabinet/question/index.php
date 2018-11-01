<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 02.03.18
 * Time: 10:18
 */

use app\modules\questionary\widgets\QuestionWidget;

/** @var \app\modules\cabinet\models\Client $model */

echo QuestionWidget::widget(['client' => $model]);
