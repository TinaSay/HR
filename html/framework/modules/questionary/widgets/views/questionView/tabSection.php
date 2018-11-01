<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 13.03.18
 * Time: 13:59
 */

/** @var string $naame */
/** @var array $contentArray */
?>

<div class="well">
    <h5><?= $name; ?></h5>
    <?= implode(PHP_EOL, $contentArray); ?>
</div>
