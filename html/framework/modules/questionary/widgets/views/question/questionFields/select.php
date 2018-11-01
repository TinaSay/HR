<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 04.03.18
 * Time: 23:39
 */

/** @var \app\modules\questionary\models\DataField $dataField */
/** @var array $values */
?>
<div class="col-xs-12">
    <div class="faild-wrap">
        <?php
        if ($dataField->value):
            ?>
        <?php
        endif;
        ?>
        <select class="chosen-select" id="<?= $dataField->fieldSmallName; ?>" name="<?= $dataField->fieldName; ?>"
            <?= $dataField->getSendProfile() ?>
                onchange="saveChanges(this)" data-placeholder="<?= $dataField->name; ?>">
            <option></option>
            <?= implode('', $values); ?>
        </select>
    </div>
</div>
