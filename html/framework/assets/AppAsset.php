<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot/static/default';

    /**
     * @var string
     */
    public $baseUrl = '@web/static/default';

    /**
     * @var array
     */
    public $css = [
        'css/icon.css',
        'css/flexboxgrid.css',
        'css/component.css',
        'css/main.css',
        'css/fix-style.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/modernizr.custom.js',
        'js/bundle.js',
        'js/validate.form.js',
        'js/main.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        \yii\web\YiiAsset::class,
    ];
}
