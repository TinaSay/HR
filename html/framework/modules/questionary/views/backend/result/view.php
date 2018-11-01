<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 13.03.18
 * Time: 13:20
 */

use app\modules\questionary\widgets\QuestionViewWidget;

/** @var \krok\cabinet\models\Client $model */

echo QuestionViewWidget::widget(['model' => $model]);