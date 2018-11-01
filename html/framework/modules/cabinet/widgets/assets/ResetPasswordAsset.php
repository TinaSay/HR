<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 23.03.18
 * Time: 16:01
 */

namespace app\modules\cabinet\widgets\assets;

use yii\web\AssetBundle;

/**
 * Class ResetPasswordAsset
 *
 * @package app\modules\cabinet\widgets\assets
 */
class ResetPasswordAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/cabinet/widgets/assets/dist';

    /**
     * @var array
     */
    public $js = [
        'js/resetPassword.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'app\assets\AppAsset',
    ];
}
