<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 10.03.18
 * Time: 12:30
 */

namespace app\modules\cabinet\widgets\assets;

use yii\web\AssetBundle;

/**
 * Class RegisterAsset
 *
 * @package app\modules\cabinet\widgets\assets
 */
class RegisterAsset extends AssetBundle
{    /**
     * @var string
     */
    public $sourcePath = '@app/modules/cabinet/widgets/assets/dist';

    /**
     * @var array
     */
    public $js = [
        'js/register.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'app\assets\AppAsset',
    ];
}
