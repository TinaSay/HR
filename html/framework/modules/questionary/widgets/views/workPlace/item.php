<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 09.03.18
 * Time: 13:08
 */

use app\modules\questionary\models\WorkPlace;

/** @var \app\modules\questionary\models\DataField $dataField */
/** @var WorkPlace $model */
/** @var array $values */
/** @var string $key */
?>
<div class="hr-line-base"></div>
<div class="well-lg">
        <div class="faild-wrap">
        <span class="input input--juro">
            <input class="input__field input__field--juro"
                <?= $dataField->getSendProfile(); ?>
                   name="<?= $dataField->fieldName; ?>[<?= $key; ?>][name]"
                   value="<?= $model->name; ?>" type="text" id="place"/>
            <label class="input__label input__label--juro" for="place">
                <span class="input__label-content input__label-content--juro">
                    Место работы
                </span>
            </label>
        </span>
        </div>

        <div class="faild-wrap">
        <span class="input input--juro">
            <input class="input__field input__field--juro"
                <?= $dataField->getSendProfile(); ?>
                   name="<?= $dataField->fieldName; ?>[<?= $key; ?>][dateStart]"
                   value="<?= $model->dateStart; ?>" type="text" id="start"/>
            <label class="input__label input__label--juro" for="start">
                <span class="input__label-content input__label-content--juro">
                    Дата устройства
                </span>
            </label>
        </span>
        </div>

        <div class="faild-wrap">
        <span class="input input--juro">
            <input class="input__field input__field--juro"
                <?= $dataField->getSendProfile(); ?>
                   name="<?= $dataField->fieldName; ?>[<?= $key; ?>][dateEnd]"
                   value="<?= $model->dateEnd; ?>" type="text" id="end"/>
            <label class="input__label input__label--juro" for="end">
                <span class="input__label-content input__label-content--juro">
                    Дата увольнения
                </span>
            </label>
        </span>
        </div>

        <div class="faild-wrap">
            <select class="chosen-select" id="position"
                <?= $dataField->getSendProfile(); ?>
                    name="<?= $dataField->fieldName; ?>[<?= $key; ?>][positionId]"
                    onchange="saveChanges(this)" data-placeholder="Должность">
                <option></option>
                <?= implode('', $values); ?>
            </select>
        </div>

</div>
