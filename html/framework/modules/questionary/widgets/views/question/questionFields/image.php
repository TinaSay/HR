<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 04.03.18
 * Time: 23:33
 */

/** @var \app\modules\questionary\models\DataField $dataField */

$preview = '';
if ($dataField->value) {
    $preview = 'style="background-image: url(' . $dataField->text . ')"';
}
?>

<div class="col-xs-12">
    <div class="faild-wrap">
        <p class="helper file-debug"></p>
        <div class="input-file-block">
            <div class="input-file-wrap <?= $preview ? 'active' : ''; ?>">
                <div class="preview-wrap">
                    <label for="<?= $dataField->fieldSmallName; ?>" class="file-lable">
                        <i class="icon-plus"></i>
                    </label>
                    <div class="preview" <?= $preview; ?>></div>
                </div>
                <input onchange="saveFile(this);" id="<?= $dataField->fieldSmallName; ?>"
                       name="<?= $dataField->fieldName; ?>"
                    <?= $dataField->getSendProfile() ?>
                       type="file" class="upload-img">
                <div class="file-info">
                    <p class="text-info">
                        <span class="file-name">IMG_4317.jpg</span>
                        <span class="file-size">498.72 КБ</span>
                        <span class="clear-file"><i class="icon-close"></i></span>
                    </p>
                    <button type="button" class="btn-change">Заменить изображение</button>
                </div>
                <div class="info-defult">
                    <p><?= $dataField->description; ?></p>
                </div>
            </div>
        </div>
        <span class="helper"><?= $dataField->name; ?></span>
    </div>
</div>
