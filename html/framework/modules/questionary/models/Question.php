<?php

namespace app\modules\questionary\models;

use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%questionary_question}}".
 *
 * @property integer $id
 * @property string $tab
 * @property string $section
 * @property string $name
 * @property string $description
 * @property integer $hidden
 * @property integer $ord
 * @property integer $createdBy
 * @property string $createdAt
 * @property string $updatedAt
 * @property QuestionFieldValue[] $questionFieldValues
 * @property QuestionField[] $questionFieldsRelation
 */
class Question extends \yii\db\ActiveRecord implements HiddenAttributeInterface
{
    use HiddenAttributeTrait;

    const TAB_PERSONAL = 'personal';
    const TAB_BYOGRAPHY = 'biography';
    const TAB_ABOUTME = 'aboutme';
    const TABS = [
        self::TAB_PERSONAL => 'Персональные данные',
        self::TAB_BYOGRAPHY => 'Биография',
        self::TAB_ABOUTME => '  О себе',
    ];

    const SECTION_PRIVATE = 'private';
    const SECTION_GENERAL = 'general';
    const SECTION_EDUCATION = 'education';
    const SECTION_WORK = 'work';
    const SECTION_ACHIVEMENTS = 'achievements';
    const SECTION_ACTIVITIES = 'activities';
    const SECTION_QUALITIES = 'qualities';
    const SECTION_OPINION = 'opinion';
    const SECTION_PREFERENCES = 'preferences';
    const SECTION_ADDITIONAL = 'additional';
    const SECTIONS = [
        self::SECTION_PRIVATE => 'Личные данные',
        self::SECTION_GENERAL => 'Общая информация',
        self::SECTION_EDUCATION => 'Сведения об образовании',
        self::SECTION_WORK => 'Сведения о работе и должностях',
        self::SECTION_ACHIVEMENTS => 'Сведения о достижениях',
        self::SECTION_ACTIVITIES => 'Сведения о деятельности',
        self::SECTION_QUALITIES => 'Личные качества',
        self::SECTION_OPINION => 'Ваше мнение',
        self::SECTION_PREFERENCES => 'Ваши интересы и предпочтения',
        self::SECTION_ADDITIONAL => 'Дополнительная информация',
    ];

    const TABS_SECTIONS = [
        self::TAB_PERSONAL => [
            self::SECTION_PRIVATE,
            self::SECTION_GENERAL,
            self::SECTION_EDUCATION,
        ],
        self::TAB_BYOGRAPHY => [
            self::SECTION_WORK,
            self::SECTION_ACHIVEMENTS,
            self::SECTION_ACTIVITIES,
        ],
        self::TAB_ABOUTME => [
            self::SECTION_QUALITIES,
            self::SECTION_OPINION,
            self::SECTION_PREFERENCES,
            self::SECTION_ADDITIONAL,
        ]
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
        return '{{%questionary_question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tab', 'section', 'name'], 'required'],
            [['hidden', 'createdBy'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['tab', 'section'], 'string', 'max' => 15],
            [['name', 'description'], 'string', 'max' => 256],
        ];
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
            'name' => 'Наименование',
            'description' => 'Описание',
            'hidden' => 'Скрыто',
            'createdBy' => 'Создано пользователем',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата обновления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionFieldValues()
    {
        return $this->hasMany(QuestionFieldValue::className(), ['questionaryQuestionId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionFieldsRelation()
    {
        return $this->hasMany(QuestionField::className(), ['questionaryQuestionId' => 'id'])
            ->andOnCondition([QuestionField::tableName() . '.hidden' => QuestionField::HIDDEN_NO])
            ->orderBy('ord');
    }

    /**
     * @return array
     */
    public static function getTabsAndSections()
    {
        $tabsSections = [];
        foreach (self::TABS_SECTIONS as $tName => $tabsSection) {
            foreach ($tabsSection as $sName) {
                $tabsSections[$sName] = self::TABS[$tName] . ' => ' . self::SECTIONS[$sName];
            }
        }

        return $tabsSections;
    }

    /**
     * @param string $section
     *
     * @return bool
     */
    public function fillTabBySection($section)
    {
        foreach (self::TABS_SECTIONS as $tName => $tSections) {
            if (in_array($section, $tSections)) {
                $this->tab = $tName;

                return true;
            }
        }

        return false;
    }

    /** @inheritdoc */
    public function load($data, $formName = null)
    {
        $this->fillTabBySection($data[$this->formName()]['section'] ?? '');

        return parent::load($data, $formName);
    }

    /**
     * @return array
     */
    public static function getAsDropDown(): array
    {
        $questions = self::find()->where(['hidden' => self::HIDDEN_NO])->all();

        return ArrayHelper::map($questions, 'id', 'name');
    }
}
