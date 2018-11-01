<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 04.03.18
 * Time: 20:52
 */

/** @var string $sectionName */
/** @var string $sectionValue */
/** @var array $questions */
?>

<div id="<?= $sectionName; ?>" class="collapsable collapsable-accordion">
    <div class="ca-control">
        <a href="#<?= $sectionName; ?>"><?= $sectionValue; ?><i class="icon-plus"></i></a>
    </div>
    <div class="ca-box">
        <div class="row">
            <?= implode('', $questions); ?>
        </div>
    </div>
</div>
