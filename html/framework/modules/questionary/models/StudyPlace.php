<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 24.03.18
 * Time: 11:07
 */

namespace app\modules\questionary\models;

use yii\base\Model;

/**
 * Class StudyPlace
 *
 * @property integer $id
 * @property string $name
 * @property string $faculty
 * @property string $specialty
 * @property integer $trainingId
 * @property string $yearEnd
 * @package app\modules\questionary\models
 */
class StudyPlace extends Model
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
     * @var string
     */
    public $faculty;
    /**
     * @var string
     */
    public $specialty;
    /**
     * @var integer
     */
    public $trainingId;
    /**
     * @var string
     */
    public $yearEnd;
}
