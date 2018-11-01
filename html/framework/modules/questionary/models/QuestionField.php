<?php

namespace app\modules\questionary\models;

use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;

/**
 * This is the model class for table "{{%questionary_question_field}}".
 *
 * @property integer $id
 * @property string $tab
 * @property string $section
 * @property integer $questionaryQuestionId
 * @property string $name
 * @property string $description
 * @property string $type
 * @property integer $obligatory
 * @property integer $costExpert
 * @property integer $costManager
 * @property integer $costLeader
 * @property string $tableClass
 * @property string $tableClassFieldName
 * @property integer $hidden
 * @property integer $ord
 * @property integer $createdBy
 * @property string $createdAt
 * @property string $updatedAt
 * @property QuestionFieldValue[] $questionFieldValues
 * @property Question $question
 */
class QuestionField extends \yii\db\ActiveRecord implements HiddenAttributeInterface
{
    use HiddenAttributeTrait;

    const OBLIGATORY_STATUS_YES = 1;
    const OBLIGATORY_STATUS_NO = 0;

    const OBLIGATORIES = [
        self::OBLIGATORY_STATUS_YES => 'Да',
        self::OBLIGATORY_STATUS_NO => 'Нет',
    ];

    const TYPE_IMAGE = 'image';
    const TYPE_INTEGER = 'integer';
    const TYPE_STRING = 'string';
    const TYPE_TEXT = 'text';
    const TYPE_SELECT = 'select';
    const TYPE_RADIO = 'radio';
    const TYPE_DATE = 'date';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_YEARLIST = 'yearlist';
    const TYPE_BINARY = 'binary';
    const TYPE_WORKPLACE = 'workplace';
    const TYPE_STUDYPLACE = 'studyplace';
    const TYPES = [
        self::TYPE_IMAGE => 'Изображение',
        self::TYPE_INTEGER => 'Целое число',
        self::TYPE_STRING => 'Строка',
        self::TYPE_TEXT => 'Текст',
        self::TYPE_SELECT => 'Список',
        self::TYPE_RADIO => 'Радио',
        self::TYPE_DATE => 'Дата',
        self::TYPE_YEARLIST => 'Год из списка',
        self::TYPE_CHECKBOX => 'Галочка',
        self::TYPE_BINARY => 'Да/Нет',
        self::TYPE_WORKPLACE => 'Места работы',
        self::TYPE_STUDYPLACE => 'Места обучения',
    ];

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
            ],
            [
                'class' => 'sjaakp\sortable\Sortable',
            ],
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
        return '{{%questionary_question_field}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tab', 'section', 'questionaryQuestionId', 'name', 'type'], 'required'],
            [['questionaryQuestionId', 'hidden', 'createdBy', 'obligatory'], 'integer'],
            [['costExpert', 'costManager', 'costLeader'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['tab', 'section', 'type'], 'string', 'max' => 15],
            [['tableClassFieldName'], 'string', 'max' => 40],
            [['name', 'description'], 'string', 'max' => 256],
            [['tableClass'], 'string', 'max' => 255],
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
     * @return QuestionField[]
     */
    public static function getActiveFields()
    {
        return QuestionField::find()->where([
            'hidden' => QuestionField::HIDDEN_NO,
            'obligatory' => QuestionField::OBLIGATORY_STATUS_YES
        ])->all();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tab' => 'Вкладка',
            'section' => 'Раздел',
            'tableClassFieldName' => 'tableClassFieldName',
            'questionaryQuestionId' => 'Questionary Question ID',
            'name' => 'Наименование',
            'costExpert' => 'Баллы эксперта',
            'costManager' => 'Баллы менеджера',
            'costLeader' => 'Баллы лидера',
            'description' => 'Описание',
            'type' => 'Type',
            'obligatory' => 'Обязательно для заполнения',
            'tableClass' => 'Table Class',
            'hidden' => 'Скрыто',
            'createdBy' => 'Создано пользователем',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата обновления',
        ];
    }

    /**
     * @return array
     */
    public static function getObligatoryList()
    {
        return self::OBLIGATORIES;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionFieldValues()
    {
        return $this->hasMany(QuestionFieldValue::className(), ['questionaryQuestionFieldId' => 'id']);
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
     * @throws \yii\base\InvalidConfigException
     */
    public function fillTabAndQuestionByQuestionId($id)
    {
        $question = Question::findOne($id);
        if ($question) {
            $this->tab = $question->tab;
            $this->section = $question->section;

            return true;
        }

        return false;
    }

    /** @inheritdoc */
    public function load($data, $formName = null)
    {
        $this->fillTabAndQuestionByQuestionId($data[$this->formName()]['questionaryQuestionId'] ?? 0);

        return parent::load($data, $formName);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getFieldName()
    {
        return $this->formName() . '[field_' . $this->id . ']';
    }

    /**
     * @return array
     */
    public static function getListWithQuestion()
    {
        /** @var QuestionField[] $questionFields */
        $questionFields = self::find()->where([
            'hidden' => self::HIDDEN_NO,
            'type' => [
                self::TYPE_RADIO,
                self::TYPE_SELECT
            ]
        ])->all();

        $result = [];
        foreach ($questionFields as $field) {
            $result[$field->id] = $field->question->name . ' => ' . $field->name;
        }

        return $result;
    }
}
