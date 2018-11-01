<?php

namespace app\modules\questionary\models;

use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\traits\HiddenAttributeTrait;

/**
 * This is the model class for table "{{%questionary_qf_value}}".
 *
 * @property integer $id
 * @property integer $questionaryQuestionId
 * @property integer $questionaryQuestionFieldId
 * @property string $name
 * @property integer $costExpert
 * @property integer $costManager
 * @property integer $costLeader
 * @property integer $hidden
 * @property integer $createdBy
 * @property string $createdAt
 * @property string $updatedAt
 * @property QuestionField $questionField
 * @property Question $question
 */
class QuestionFieldValue extends \yii\db\ActiveRecord
{
    use HiddenAttributeTrait;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
            ],
            'CreatedByBehavior' => [
                'class' => CreatedByBehavior::class
            ]
        ];
    }

    /**
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%questionary_qf_value}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['questionaryQuestionId', 'questionaryQuestionFieldId', 'name'], 'required'],
            [['questionaryQuestionId', 'questionaryQuestionFieldId', 'hidden', 'createdBy'], 'integer'],
            [['costExpert', 'costManager', 'costLeader'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [
                [
                    'questionaryQuestionFieldId'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => QuestionField::className(),
                'targetAttribute' => ['questionaryQuestionFieldId' => 'id']
            ],
            [
                ['questionaryQuestionId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Question::className(),
                'targetAttribute' => ['questionaryQuestionId' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'questionaryQuestionId' => 'Questionary Question ID',
            'questionaryQuestionFieldId' => 'Вопрос => поле',
            'name' => 'Наименование',
            'costExpert' => 'Баллы эксперта',
            'costManager' => 'Баллы менеджера',
            'costLeader' => 'Баллы лидера',
            'hidden' => 'Скрыто',
            'createdBy' => 'Создано пользователем',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата обновления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionField()
    {
        return $this->hasOne(QuestionField::className(), ['id' => 'questionaryQuestionFieldId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'questionaryQuestionId']);
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function fillQuestionIdByQuestionFieldId($id)
    {
        $questionField = QuestionField::findOne($id);
        if ($questionField) {
            $this->questionaryQuestionId = $questionField->questionaryQuestionId;

            return true;
        }

        return false;
    }

    /** @inheritdoc */
    public function load($data, $formName = null)
    {
        $this->fillQuestionIdByQuestionFieldId($data[$this->formName()]['questionaryQuestionFieldId'] ?? 0);

        return parent::load($data, $formName);
    }
}
