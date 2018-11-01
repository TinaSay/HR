<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 07.03.18
 * Time: 21:07
 */

namespace app\modules\questionary\models;

use yii\base\Model;

/**
 * Class Year
 *
 * @property integer $id
 * @property string $name
 * @package app\modules\questionary\models
 */
class Year extends Model
{
    const MAX_YEARS_AGO = 50;

    /** @var integer */
    public $id;

    /** @var string */
    public $name;

    /**
     * @return Year[]
     */
    public static function getList()
    {
        $list = [];
        $date = date("Y");
        $minDate = $date - self::MAX_YEARS_AGO;
        for ($i = $date; $i > $minDate; $i--) {
            $model = new Year();
            $model->id = $i;
            $model->name = $i;
            $list[] = $model;
        }

        return $list;
    }
}
