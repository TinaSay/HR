<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 03.03.18
 * Time: 22:25
 */

namespace app\modules\cabinet\forms;

use app\modules\cabinet\models\Client;

/**
 * Class ClientForm
 *
 * @property string $repeatPassword
 * @property string $newPassword
 * @property boolean $agree
 * @property string $step
 * @package app\modules\cabinet\controllers\forms
 */
class ClientForm extends Client
{
    const SCENARIO_STEP_FIRST = 'stepFirst';
    const SCENARIO_STEP_SECOND = 'stepSecond';
    const SCENARIO_STEP_THIRD = 'stepThird';
    const SCENARIO_STEP_FOURTH = 'stepFourth';

    const HIDDEN_PASSWORD = '********';

    const ACCEPT_YES = 1;

    /**
     * @var bool
     */
    public $agree;

    /**
     * @var string
     */
    public $step;

    /**
     * @var string
     */
    public $repeatPassword = '';

    /**
     * @var string
     */
    public $newPassword = '';

    /** @inheritdoc */
    public function rules()
    {
        return array_merge(
            [
                [
                    ['agree'],
                    'boolean',
                    'trueValue' => ClientForm::ACCEPT_YES,
                    'falseValue' => ClientForm::ACCEPT_YES,
                    'message' => 'Необходимо принять условия'
                ],
                [
                    [
                        'name',
                        'login',
                        'phone',
                        'newPassword',
                        'repeatPassword',
                        'agree'
                    ],
                    'required',
                    'on' => self::SCENARIO_STEP_FIRST
                ],
                [
                    [
                        'newPassword',
                        'repeatPassword'
                    ],
                    'required',
                    'on' => self::SCENARIO_STEP_SECOND
                ],
                [
                    [
                        'work',
                        'position'
                    ],
                    'required',
                    'on' => self::SCENARIO_STEP_THIRD
                ],
                [['newPassword', 'repeatPassword'], 'string', 'max' => 20, 'min' => 8],
                [['repeatPassword'], 'validateRepeatPassword'],
                [['repeatPassword'], 'compare', 'compareAttribute' => 'newPassword'],
            ],
            parent::rules()
        );
    }

    /**
     * @param $attribute
     * @param $params
     * @param $validator
     *
     * @return bool
     */
    public function validateRepeatPassword($attribute, $params, $validator)
    {
        if (strcmp($this->repeatPassword, self::HIDDEN_PASSWORD)) {
            $this->password = $this->newPassword;
        }

        return true;
    }

    /** @inheritdoc */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->newPassword = self::HIDDEN_PASSWORD;
        $this->repeatPassword = self::HIDDEN_PASSWORD;
    }

    /** @inheritdoc */
    public function setScenario($scenario)
    {
        parent::setScenario($scenario);
        $this->step = $this->scenario;

        if ($this->scenario == self::SCENARIO_STEP_SECOND) {
            $this->newPassword = $this->repeatPassword = '';
        }
    }

    public function attributeLabels()
    {
        return array_merge(
            [
                'newPassword' => 'Пароль',
                'repeatPassword' => 'Повторите пароль',
                'agree' => 'Я даю свое согласие на обработку моих персональных данных'
            ],
            parent::attributeLabels()
        );
    }

    /**
     * @return string
     */
    private function getSessionId()
    {
        return self::className();
    }

    public function loadFromSession()
    {
        $this->setAttributes(\Yii::$app->session->get($this->getSessionId()));
    }

    /**
     * @return true
     */
    public function saveToSession()
    {
        return \Yii::$app->session->set($this->getSessionId(), $this->getAttributes());
    }

    public function cleanSession()
    {
        \Yii::$app->session->remove($this->getSessionId());
    }
}
