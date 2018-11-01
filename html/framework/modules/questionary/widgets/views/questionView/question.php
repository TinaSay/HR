<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 13.03.18
 * Time: 13:59
 */

/** @var \app\modules\questionary\models\Question $question */
/** @var array $contentArray */
?>
<div class="well">
    <b><?= $question->name; ?></b>
    <?= implode(PHP_EOL, $contentArray); ?>
</div>
