<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 24.03.18
 * Time: 11:22
 */

/** @var \app\modules\questionary\models\StudyPlace $studyPlace */
?>

<div>Наименование: <?= $studyPlace->name; ?></div>
<div>Факультет: <?= $studyPlace->faculty; ?></div>
<div>Специальность: <?= $studyPlace->specialty; ?></div>
<div>Форма обучения: <?= \app\modules\questionary\models\StudyPlaceTraining::FORMS[$studyPlace->trainingId] ?? ''; ?></div>
<div>Год окончания: <?= $studyPlace->yearEnd; ?></div>