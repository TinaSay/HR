<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 04.03.18
 * Time: 21:40
 */

/** @var \app\modules\questionary\models\DataField $dataField */

?>

<div class="col-xs-12">
    <div class="faild-wrap">
        <span class="input input--juro">
            <input class="input__field input__field--juro" name="<?= $dataField->fieldName; ?>"
                <?= $dataField->getSendProfile() ?>
                   value="<?= $dataField->text; ?>" type="text" id="<?= $dataField->fieldSmallName; ?>"/>
            <label class="input__label input__label--juro" for="<?= $dataField->fieldSmallName; ?>">
                <span class="input__label-content input__label-content--juro">
                    <?= $dataField->name; ?>
                </span>
            </label>
        </span>
    </div>
</div>
