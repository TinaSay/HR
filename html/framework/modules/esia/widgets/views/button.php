<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 21.03.18
 * Time: 7:36
 */

/** @var string $url */
/** @var string $name */
$buttonName = 'Авторизация ЕСИА';
if ($name) {
    $buttonName = $name;
}
?>
<a onclick="$(this).hide();" href="<?= $url; ?>" class="esia-btn">
    <?= $buttonName; ?>
</a>
