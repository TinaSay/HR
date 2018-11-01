<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 04.03.18
 * Time: 21:07
 */

use app\modules\questionary\models\Question;

/** @var Question $model */
/** @var array $fields */
?>
<div class="col-xs-12">
    <p class="lable-top"><?= $model->name; ?></p>
    <p class="helper"><?= $model->description; ?></p>
</div>
<?= implode('', $fields); ?>
