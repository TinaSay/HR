<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 24.03.18
 * Time: 11:47
 */

/** @var \app\modules\questionary\models\DataField $dataField */
/** @var \app\modules\questionary\models\StudyPlace $model */
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
                    Наименование образовательной организации
                </span>
            </label>
        </span>
        </div>


        <div class="faild-wrap">
        <span class="input input--juro">
            <input class="input__field input__field--juro"
                <?= $dataField->getSendProfile(); ?>
                   name="<?= $dataField->fieldName; ?>[<?= $key; ?>][faculty]"
                   value="<?= $model->faculty; ?>" type="text" id="start"/>
            <label class="input__label input__label--juro" for="start">
                <span class="input__label-content input__label-content--juro">
                    Факультет
                </span>
            </label>
        </span>
        </div>

    
        <div class="faild-wrap">
        <span class="input input--juro">
            <input class="input__field input__field--juro"
                <?= $dataField->getSendProfile(); ?>
                   name="<?= $dataField->fieldName; ?>[<?= $key; ?>][specialty]"
                   value="<?= $model->specialty; ?>" type="text" id="end"/>
            <label class="input__label input__label--juro" for="end">
                <span class="input__label-content input__label-content--juro">
                    Специальность
                </span>
            </label>
        </span>
        </div>
    
        <div class="faild-wrap">
            <select class="chosen-select" id="position"
                <?= $dataField->getSendProfile(); ?>
                    name="<?= $dataField->fieldName; ?>[<?= $key; ?>][trainingId]"
                    onchange="saveChanges(this)" data-placeholder="Форма обучения">
                <option></option>
                <?= implode('', $values); ?>
            </select>
        </div>
    
        <div class="faild-wrap">
        <span class="input input--juro">
            <input class="input__field input__field--juro"
                <?= $dataField->getSendProfile(); ?>
                   name="<?= $dataField->fieldName; ?>[<?= $key; ?>][yearEnd]"
                   value="<?= $model->yearEnd; ?>" type="text" id="end"/>
            <label class="input__label input__label--juro" for="end">
                <span class="input__label-content input__label-content--juro">
                    Год окончания
                </span>
            </label>
        </span>
        </div>

</div>
