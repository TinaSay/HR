<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 14.03.18
 * Time: 8:42
 */

namespace app\modules\questionary\models;

use app\modules\questionary\exceptions\UnknownClassException;
use app\modules\questionary\exceptions\UnknownFieldException;
use yii\base\Model;
use yii\log\Logger;

/**
 * Class DataField
 *
 * @property string $tab
 * @property string $tabName
 * @property string $section
 * @property string $sectionName
 * @property string $questionName
 * @property string $fieldSmallName
 * @property string $fieldName
 * @property string $value
 * @property string $name
 * @property string $description
 * @property string $text
 * @property string $type
 * @property integer $costExpert
 * @property integer $costManager
 * @property integer $costLeader
 * @property integer $obligatory
 * @property string $modelName
 * @property integer $modelId
 * @package app\modules\questionary\models
 */
class DataField extends Model
{
    public $tab;
    public $tabName;
    public $section;
    public $sectionName;
    public $questionName;

    public $fieldSmallName;
    public $fieldName;
    public $value;
    public $name;
    public $description;
    public $text;
    public $type;

    public $costExpert;
    public $costManager;
    public $costLeader;

    public $obligatory;
    public $modelName;
    public $modelId;
    /** @var string */
    private $_fieldNameSuffix = '';
    /** @var \app\modules\cabinet\models\Client */
    private $_client;

    /**
     * @var array
     */
    private $_oldAttributes;

    /**
     * DataField constructor.
     *
     * @param Model $model
     * @param \app\modules\cabinet\models\Client $client
     * @param array $config
     *
     * @throws UnknownFieldException
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($model = null, $client = null, array $config = [])
    {
        if ($model) {
            $this->fillFieldNameFromObject($model);
            list($modelName, $fieldName) = $this->extractField($this->fieldName);
            $this->fillModel($modelName, $fieldName);
        }
        $this->loadFromData($client);
        parent::__construct($config);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getOldAttribute($name)
    {
        return $this->_oldAttributes[$name] ?? '';
    }

    /**
     * @param \app\modules\cabinet\models\Client $client
     */
    private function loadFromData($client)
    {
        $this->_client = $client;
        if ($client && $client->questionaryClientRelation) {
            $dataArray = unserialize($client->questionaryClientRelation->data, []);
            $data = $dataArray[$this->fieldName] ?? '';
            if ($data instanceof DataField) {
                $this->setAttributes($data->getAttributes(), false);
            } elseif (is_array($data)) {
                $this->setAttributes($data, false);
            }
            $this->_oldAttributes = $this->getAttributes();
        }
    }

    /**
     * @param string|DataField|array $fieldName
     *
     * @return DataField
     * @throws UnknownFieldException
     * @throws \yii\base\InvalidConfigException
     */
    public static function findOrInit($fieldName)
    {
        $client = \app\modules\cabinet\models\Client::findOne(\Yii::$app->user->getId());
        $dataField = new DataField();
        $value = '';
        if (is_object($fieldName)) {
            $dataField->fillFieldNameFromObject($fieldName);
        } elseif (is_array($fieldName)) {
            $value = $dataField->fillFieldNameFromArray($fieldName);
        } else {
            $dataField->fieldName = $fieldName;
        }
        list($modelName, $fieldName) = $dataField->extractField($dataField->fieldName);
        $dataField->fillModel($modelName, $fieldName);
        $dataField->loadFromData($client);
        if ($value) {
            $dataField->value = $value;
        }

        return $dataField;
    }

    /**
     * @return bool
     * @throws UnknownClassException
     * @throws UnknownFieldException
     * @throws \yii\base\InvalidConfigException
     */
    public function save()
    {
        $questionaryClient = $this->_client->questionaryClientRelation;
        if (!$questionaryClient) {
            $questionaryClient = new Client();
            $questionaryClient->clientId = $this->_client->id;
        }
        $data = $questionaryClient->getData();
        if (!$data) {
            $data = [];
        }
        $this->fillText();
        $data[$this->fieldName] = $this->getAttributes();
        $questionaryClient->data = serialize($data);

        return $questionaryClient->validate() && $questionaryClient->save();
    }

    /**
     * @return string
     */
    public function getSendProfile()
    {
        if (Client::isSendProfile()) {
            return 'disabled="disabled"';
        }

        return '';
    }

    /**
     * @param string $field
     *
     * @return int
     */
    private function extractFieldId($field)
    {
        preg_match('|field_(.*)|is', $field, $match);

        return $match[1] ?? 0;
    }

    /**
     * @param string $field
     *
     * @return array ['Model', 'field_1']
     * @throws UnknownFieldException
     */
    private function extractField($field)
    {
        preg_match('|([^\[]*)\[([^\]]+)\](.*)|is', $field, $match);
        if (isset($match[1], $match[2])) {
            $this->_fieldNameSuffix = $match[3];

            return [$match[1], $match[2]];
        }
        throw new UnknownFieldException($field);
    }

    /**
     * @param string $name
     * @param integer $fieldId
     *
     * @throws \yii\base\InvalidConfigException
     */
    private function fillModel($name, $fieldId)
    {
        $modelName = 'app\\modules\\questionary\\models\\' . $name;
        if (!class_exists($modelName)) {
            \Yii::getLogger()->log(
                'Model ' . $modelName . ' is not found',
                Logger::LEVEL_ERROR
            );

            return;
        }
        $this->modelName = $modelName;
        $this->modelId = $this->extractFieldId($fieldId);

        $model = $modelName::findOne($this->modelId);
        if (!$model) {
            \Yii::getLogger()->log(
                'Field ' . $fieldId . ' in model ' . $modelName . ' is not found',
                Logger::LEVEL_ERROR
            );

            return;
        }
        /** @var QuestionField $model */
        $this->fillFieldNameFromObject($model);
        $this->name = $model->name;
        $this->description = $model->description;
        $this->type = $model->type;
        $this->tab = $model->tab;
        $this->tabName = Question::TABS[$this->tab];
        $this->section = $model->section;
        $this->sectionName = Question::SECTIONS[$this->section];
        $this->questionName = $model->question->name;
        $this->costExpert = $model->costExpert;
        $this->costLeader = $model->costLeader;
        $this->costManager = $model->costManager;
        $this->obligatory = $model->obligatory;
    }

    /**
     * @param array $fieldName
     *
     * @return string
     */
    public function fillFieldNameFromArray($fieldName)
    {
        $names = array_keys($fieldName);
        $keys = array_keys($fieldName[$names[0]]);
        $this->fieldSmallName = $keys[0];
        $this->fieldName = $names[0] . '[' . $keys[0] . ']';

        return $fieldName[$names[0]][$keys[0]];
    }

    /**
     * @param Model $model
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function fillFieldNameFromObject($model)
    {
        $this->fieldSmallName = 'field_' . $model->id;
        $this->fieldName = $model->formName() . '[field_' . $model->id . ']';
    }

    /**
     * @return bool
     */
    public function exist()
    {
        return $this->value && $this->text;
    }

    /**
     * @return WorkPlace
     */
    public function getFilledWorkPlace()
    {
        preg_match('|\[([^\]+])?\]\[([^\]]+)|is', $this->_fieldNameSuffix, $math);
        $key = $math[1];
        $name = $math[2];
        $value = $this->value;
        $this->value = $this->getOldAttribute('value');

        $workPlace = new WorkPlace();
        $workPlace->setAttributes($this->value[$key] ?? [], false);
        $workPlace->$name = $value;
        if (!$workPlace->id) {
            $workPlace->id = $key;
        }
        if (!is_array($this->value)) {
            $this->value = [];
        }
        $this->value[$key] = $workPlace->getAttributes();

        return $workPlace;
    }

    /**
     * @return StudyPlace
     */
    public function getFilledStudyPlace()
    {
        preg_match('|\[([^\]+])?\]\[([^\]]+)|is', $this->_fieldNameSuffix, $math);
        $key = $math[1];
        $name = $math[2];
        $value = $this->value;
        $this->value = $this->getOldAttribute('value');

        $studyPlace = new StudyPlace();
        $studyPlace->setAttributes($this->value[$key] ?? [], false);
        $studyPlace->$name = $value;
        if (!$studyPlace->id) {
            $studyPlace->id = $key;
        }
        if (!is_array($this->value)) {
            $this->value = [];
        }
        $this->value[$key] = $studyPlace->getAttributes();

        return $studyPlace;
    }

    private function fillText()
    {
        switch ($this->type) {
            case QuestionField::TYPE_RADIO:
            case QuestionField::TYPE_SELECT:
                $field = QuestionFieldValue::findOne($this->value);
                if ($field) {
                    $value = $field->name;
                    $this->costManager = $field->costManager;
                    $this->costLeader = $field->costLeader;
                    $this->costExpert = $field->costExpert;
                }
                break;
            case QuestionField::TYPE_IMAGE:
                $image = ImageFile::findOne($this->value);
                if ($image) {
                    $value = (string)$image->imageFile;
                }
                break;
            case QuestionField::TYPE_BINARY:
                $value = Binary::VARIANTS[$this->value];
                break;
            case QuestionField::TYPE_CHECKBOX:
                $value = $this->value === 'true' ? 'Да' : 'Нет';
                break;
            case QuestionField::TYPE_WORKPLACE:
                $workPlace = $this->getFilledWorkPlace();
                $value = \Yii::$app->controller->renderPartial(
                    '@app/modules/questionary/widgets/views/workPlace/result',
                    ['workPlace' => $workPlace]
                );
                break;
            case QuestionField::TYPE_STUDYPLACE:
                $studyPlace = $this->getFilledStudyPlace();
                $value = \Yii::$app->controller->renderPartial(
                    '@app/modules/questionary/widgets/views/studyPlace/result',
                    ['studyPlace' => $studyPlace]
                );
                break;
            default:
                $value = $this->value;
                break;
        }
        if ($value) {
            $this->text = $value;
        }
    }
}
