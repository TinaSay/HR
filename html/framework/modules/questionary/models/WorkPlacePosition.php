<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 09.03.18
 * Time: 15:09
 */

namespace app\modules\questionary\models;

use yii\base\Model;

/**
 * Class WorkPlacePosition
 *
 * @property integer $id
 * @property string $name
 * @package app\modules\questionary\models
 */
class WorkPlacePosition extends Model
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var string
     */
    public $name;

    const POSITION_HEAD = 1;
    const POSITION_DEPUTY = 2;
    const POSITION_UNIT = 3;
    const POSITION_DIRECTION = 4;
    const POSTION_OTHER = 5;

    const POSITIONS = [
        self::POSITION_HEAD => 'руководитель организации',
        self::POSITION_DEPUTY => 'заместитель руководителя организации',
        self::POSITION_UNIT => 'руководитель структурного подразделения организации',
        self::POSITION_DIRECTION => 'руководитель направления',
        self::POSTION_OTHER => 'иные должности'
    ];

    /**
     * @return WorkPlacePosition[]
     */
    public static function getList()
    {
        $list = [];
        foreach (self::POSITIONS as $key => $position) {
            $model = new WorkPlacePosition();
            $model->id = $key;
            $model->name = $position;
            $list[] = $model;
        }

        return $list;
    }
}
