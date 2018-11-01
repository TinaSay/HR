<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 09.03.18
 * Time: 15:15
 */

namespace app\modules\questionary\widgets\assets;

use yii\web\AssetBundle;

/**
 * Class WorkPlaceAsset
 *
 * @package app\modules\questionary\widgets\assets
 */
class WorkPlaceAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/questionary/widgets/assets/dist';

    /**
     * @var array
     */
    public $js = [
        'js/addWorkPlace.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'app\assets\AppAsset',
    ];
}
