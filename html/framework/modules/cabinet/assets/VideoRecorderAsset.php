<?php

namespace app\modules\cabinet\assets;

use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;

/**
 * Class VideoRecorderAsset
 * @package app\modules\cabinet\assets
 */
class VideoRecorderAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/cabinet/assets';

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    /**
     * @var array
     */
    public $css = [
        'css/video.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'https://cdn.webrtc-experiment.com/RecordRTC.js',
        'https://cdn.webrtc-experiment.com/gif-recorder.js',
        'https://cdn.webrtc-experiment.com/getScreenId.js',
        'https://cdn.webrtc-experiment.com/gumadapter.js',
        'js/video.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        'app\assets\AppAsset',
    ];
}
