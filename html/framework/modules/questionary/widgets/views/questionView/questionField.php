<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 13.03.18
 * Time: 14:27
 */

/** @var \app\modules\questionary\models\QuestionField $questionField */
/** @var array $contentArray */
/** @var string $value */
?>

<div class="well">
    <span><b><?= $questionField->name; ?></b>:</span>
    <span><?= $value; ?></span>
</div>
