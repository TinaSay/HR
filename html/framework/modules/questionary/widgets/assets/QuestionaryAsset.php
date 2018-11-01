<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 08.03.18
 * Time: 12:55
 */

namespace app\modules\questionary\widgets\assets;

use yii\web\AssetBundle;

/**
 * Class QuestionaryAsset
 *
 * @package app\modules\questionary\widgets\assets
 */
class QuestionaryAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/questionary/widgets/assets/dist';

    /**
     * @var array
     */
    public $js = [
        'js/saveQuestionaryForm.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'app\assets\AppAsset',
    ];
}
