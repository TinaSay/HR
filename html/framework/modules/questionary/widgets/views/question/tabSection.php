<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 04.03.18
 * Time: 20:11
 */

/** @var string $tabName */
/** @var array $sections */
 ?>
<div id="<?= $tabName ?>">
    <form class="blok-content base-form ac-checkmark">
        <?= implode('', $sections); ?>
    </form>
</div>
