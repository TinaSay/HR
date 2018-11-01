<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 13.03.18
 * Time: 14:00
 */

/** @var string $name */
/** @var array $contentArray */
?>
<div>
    <h2><?= $name; ?></h2>
    <?= implode(PHP_EOL, $contentArray); ?>
</div>