<?php
/** @var \dosamigos\fileupload\FileUploadUI $this */
use yii\helpers\Html;

$context = $this->context;
?>


<!-- The file upload form used as target for the file upload widget -->
<?= Html::beginTag('div', $context->options); ?>
<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
<div class="fileupload-buttonbar">
    <!-- The fileinput-button span is used to style the file input field as button -->
    <div class="upload-wrap">
        <div class="upload-cont">
            <span class="btn btn-prime fileinput-button">
                <span>Выбрать файл</span>
                <?= $context->model instanceof \yii\base\Model && $context->attribute !== null
                    ? Html::activeFileInput($context->model, $context->attribute, $context->fieldOptions)
                    : Html::fileInput($context->name, $context->value, $context->fieldOptions);?>

            </span>
        </div>
    </div>
    <p class="helper">Максимальный объём файла — 5 ГБ.</p>
    <p class="helper">Допустимые форматы видео: AVI, MP4, 3GP, MPEG, MOV, FLV, F4V, WMV, MKV, WEBM, VOB, RM, RMVB, M4V, MPG, OGV, TS, M2TS, MTS</p>
    <?php /*
    <a class="btn btn-primary start">
        <i class="glyphicon glyphicon-upload"></i>
        <span><?= Yii::t('fileupload', 'Start upload') ?></span>
    </a> */ ?>
    <?php /*
    <a class="btn btn-warning cancel">
        <i class="glyphicon glyphicon-ban-circle"></i>
        <span><?= Yii::t('fileupload', 'Cancel upload') ?></span>
    </a> */ ?>
</div>
<!-- The table listing the files available for upload/download -->
<div role="presentation" class="fileupload-block">
    <div class="files"></div>
</div>

<?= Html::endTag('div');?>
