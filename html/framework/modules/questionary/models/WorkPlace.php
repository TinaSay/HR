<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 09.03.18
 * Time: 12:33
 */

namespace app\modules\questionary\models;

use yii\base\Model;

/**
 * Class WorkPlace
 *
 * @property integer $id
 * @property string $name
 * @property integer $positionId
 * @property string $dateStart
 * @property string $dateEnd
 * @package app\modules\questionary\models
 */
class WorkPlace extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $positionId;
    /**
     * @var string
     */

    public $dateStart;

    /**
     * @var string
     */
    public $dateEnd;
}
