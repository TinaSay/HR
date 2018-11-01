<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 19.03.18
 * Time: 9:34
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class AppStatusAsset
 *
 * @package app\assets
 */
class AppStatusAsset extends AssetBundle
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
    public $js = [
        'js/sessionStatus.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        AppAsset::class,
    ];
}
