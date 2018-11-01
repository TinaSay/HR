<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 05.03.18
 * Time: 0:43
 */

/** @var \app\modules\questionary\models\QuestionFieldValue $model */
/** @var integer $count */
/** @var \app\modules\questionary\models\DataField $dataField */

$maxRowSize = 12;
$rowSize = $maxRowSize / $count;
$field = 'field_value_' . $model->id;
?>
<div class="col-xs-12 col-md-<?= $rowSize; ?>">
    <div class="faild-wrap ac-custom ac-checkbox">
        <input id="<?= $field ?>" type="radio"
            <?= $dataField->getSendProfile(); ?>
               value="<?= $model->id; ?>"
               name="<?= $dataField->fieldName; ?>"
            <?= $dataField->value == $model->id ? ' checked="checked" ' : ''; ?>
               class="checkbox__field">
        <label for="<?= $field; ?>"><?= $model->name; ?></label>
    </div>
</div>
