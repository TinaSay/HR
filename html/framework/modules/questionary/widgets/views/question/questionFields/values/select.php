<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 05.03.18
 * Time: 0:29
 */

/** @var \app\modules\questionary\models\QuestionFieldValue $model */
/** @var \app\modules\questionary\models\DataField $dataField */
?>

<option <?= $dataField->value == $model->id ? 'selected="selected"' : ''; ?>
        value="<?= $model->id; ?>">
    <?= $model->name; ?>
</option>
