<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 24.03.18
 * Time: 11:36
 */

namespace app\modules\questionary\widgets\assets;

use yii\web\AssetBundle;

/**
 * Class StudyPlaceAsset
 *
 * @package app\modules\questionary\widgets\assets
 */
class StudyPlaceAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/questionary/widgets/assets/dist';

    /**
     * @var array
     */
    public $js = [
        'js/addStudyPlace.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'app\assets\AppAsset',
    ];
}
