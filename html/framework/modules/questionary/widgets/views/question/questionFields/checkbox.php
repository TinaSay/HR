<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 04.03.18
 * Time: 23:46
 */

/** @var \app\modules\questionary\models\DataField $dataField */
?>
<div class="col-xs-12">
    <div class="faild-wrap ac-custom ac-checkbox">
        <input id="<?= $dataField->fieldSmallName; ?>" name="<?= $dataField->fieldName; ?>"
            <?= $dataField->getSendProfile() ?>
            <?= $dataField->value === 'true' ? ' checked="checked" ' : ''; ?>
               type="checkbox" class="checkbox__field">
        <label for="<?= $dataField->fieldSmallName; ?>"><?= $dataField->name; ?></label>
    </div>
</div>
