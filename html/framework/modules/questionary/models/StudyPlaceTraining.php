<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 24.03.18
 * Time: 11:09
 */

namespace app\modules\questionary\models;

use yii\base\Model;

/**
 * Class StudyPlaceTraining
 *
 * @property integer $id
 * @property string $name
 * @package app\modules\questionary\models
 */
class StudyPlaceTraining extends Model
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var string
     */
    public $name;

    const FORM_DAYTIME = 1;
    const FORM_EVENING = 2;
    const FORM_EXTRAMURAL = 3;

    const FORMS = [
        self::FORM_DAYTIME => 'очное (дневное)',
        self::FORM_EVENING => 'очное (вечернее)',
        self::FORM_EXTRAMURAL => 'заочное обучение',
    ];

    /**
     * @return StudyPlaceTraining[]
     */
    public static function getList()
    {
        $list = [];
        foreach (self::FORMS as $key => $position) {
            $model = new StudyPlaceTraining();
            $model->id = $key;
            $model->name = $position;
            $list[] = $model;
        }

        return $list;
    }
}
