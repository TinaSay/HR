<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 24.03.18
 * Time: 11:00
 */

/** @var \app\modules\questionary\models\WorkPlace $workPlace */
?>

<div>Наименование: <?= $workPlace->name; ?></div>
<div>Должность: <?= \app\modules\questionary\models\WorkPlacePosition::POSITIONS[$workPlace->positionId] ?? ''; ?></div>
<div>Дата начала: <?= $workPlace->dateStart; ?></div>
<div>Дата окончания: <?= $workPlace->dateEnd; ?></div>