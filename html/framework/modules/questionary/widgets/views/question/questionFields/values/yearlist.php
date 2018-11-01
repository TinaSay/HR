<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 14.03.18
 * Time: 11:16
 */

/** @var \app\modules\questionary\models\QuestionFieldValue $model */
/** @var \app\modules\questionary\models\DataField $dataField */
?>

<option <?= $dataField->value == $model->id ? 'selected="selected"' : ''; ?>
    value="<?= $model->id; ?>">
    <?= $model->name; ?>
</option>
