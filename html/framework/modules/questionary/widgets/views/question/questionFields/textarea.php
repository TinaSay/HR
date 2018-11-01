<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 04.03.18
 * Time: 23:52
 */

/** @var \app\modules\questionary\models\DataField $dataField */
?>
<div class="col-xs-12">
    <div class="faild-wrap">
        <span class="input textarea input--juro ">
            <textarea class="input__field input__field--juro" name="<?= $dataField->fieldName; ?>"
                <?= $dataField->getSendProfile() ?>
                      type="text" id="<?= $dataField->fieldSmallName; ?>" rows="5"/><?= $dataField->text; ?></textarea>
            <label class="input__label input__label--juro" for="<?= $dataField->fieldSmallName; ?>">
                <span class="input__label-content input__label-content--juro"><?= $dataField->name; ?></span>
            </label>
        </span>
    </div>
</div>
