<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 13.03.18
 * Time: 14:08
 */

/** @var array $contentArray */
/** @var \app\modules\cabinet\models\Client $client */
?>

<div>
    <h1>
        <?php
        echo $client->name;
        if ($client->city) {
            echo ', ' . $client->city;
        }
        if ($client->phone) {
            echo ', ' . $client->phone;
        }
        ?>
    </h1>
    <?= implode(PHP_EOL, $contentArray); ?>
</div>
