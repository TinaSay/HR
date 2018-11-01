<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 07.03.18
 * Time: 21:36
 */

namespace app\modules\questionary\models;

use yii\base\Model;

/**
 * Class Binary
 *
 * @package app\modules\questionary\models
 */
class Binary extends Model
{
    const YES = 1;
    const NO = 2;

    const VARIANTS = [
        self::YES => 'Да',
        self::NO => 'Нет',
    ];

    /** @var integer */
    public $id;

    /** @var string */
    public $name;

    /**
     * @return Binary[]
     */
    public static function getList()
    {
        $list = [];
        foreach (self::VARIANTS as $key => $variant) {
            $model = new Binary();
            $model->id = $key;
            $model->name = $variant;
            $list[] = $model;
        }

        return $list;
    }
}
