<?php

namespace app\modules\cabinet\widgets;

use dosamigos\fileupload\FileUploadUI;
use yii\helpers\ArrayHelper;


/**
 * Class FileuploadUIWidget
 * @package app\modules\cabinet\widgets
 */
class FileuploadUIWidget extends FileUploadUI
{
    /**
     * @var string the form view path to render the JQuery File Upload UI
     */
    public $formView = 'fileupload/form';
    /**
     * @var string the upload view path to render the js upload template
     */
    public $uploadTemplateView = 'fileupload/upload';
    /**
     * @var string the download view path to render the js download template
     */
    public $downloadTemplateView = 'fileupload/download';

    public function init()
    {
        parent::init();

        $this->fieldOptions['multiple'] = false;
        $this->fieldOptions['id'] = ArrayHelper::getValue($this->options, 'id');

        $this->options['id'] .= '-fileupload';
        $this->options['data-upload-template-id'] = $this->uploadTemplateId ?: 'template-upload';
        $this->options['data-download-template-id'] = $this->downloadTemplateId ?: 'template-download';
    }
}
