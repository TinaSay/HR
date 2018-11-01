<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 04.03.18
 * Time: 19:52
 */

namespace app\modules\questionary\widgets;

use app\modules\cabinet\models\Client;
use app\modules\questionary\exceptions\UnknownFieldTypeException;
use app\modules\questionary\models\Binary;
use app\modules\questionary\models\DataField;
use app\modules\questionary\models\Question;
use app\modules\questionary\models\QuestionField;
use app\modules\questionary\models\Year;
use app\modules\questionary\widgets\assets\QuestionaryAsset;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;

/**
 * Class QuestionWidget
 *
 * @package app\modules\questionary\widgets
 */
class QuestionWidget extends Widget
{
    /** @var Client $client */
    public $client;

    /** @inheritdoc */
    public function run()
    {
        parent::run();

        QuestionaryAsset::register($this->getView());
        $tabs = [];
        $tabsContent = [];
        foreach (Question::TABS as $tabName => $tabValue) {
            $tabs[] = $this->getTabContent($tabName, $tabValue);
            $tabsContent[] = $this->getTabSectionContent($tabName);
        }

        return $this->render('question/questionary', [
            'tabs' => $tabs,
            'tabsContent' => $tabsContent,
            'client' => $this->client,
        ]);
    }

    /**
     * @param string $tabName
     * @param string $tabValue
     *
     * @return string
     */
    public function getTabContent($tabName, $tabValue)
    {
        return $this->render('question/tab', [
            'tabName' => $tabName,
            'tabValue' => $tabValue
        ]);
    }

    /**
     * @param $tabName
     *
     * @return string
     * @throws InvalidConfigException
     * @throws UnknownFieldTypeException
     * @throws \app\modules\questionary\exceptions\UnknownClassException
     * @throws \app\modules\questionary\exceptions\UnknownFieldException
     */
    public function getTabSectionContent($tabName)
    {
        $sections = [];
        foreach (Question::TABS_SECTIONS[$tabName] as $sectionName) {
            $sections[] = $this->getSectionContent($sectionName);
        }

        return $this->render('question/tabSection', [
            'tabName' => $tabName,
            'sections' => $sections
        ]);
    }

    /**
     * @param Model $valueModel ['id', 'name']
     * @param DataField $dataField
     * @param array $options ['count']
     *
     * @return string
     * @throws InvalidConfigException
     */
    public function getValueContent($valueModel, $dataField, $options = [])
    {
        $count = $options['count'] ?? null;

        return $this->render('question/questionFields/values/' . $dataField->type, [
            'model' => $valueModel,
            'count' => $count,
            'dataField' => $dataField
        ]);
    }

    /**
     * @param $questionField
     *
     * @return string
     * @throws InvalidConfigException
     * @throws UnknownFieldTypeException
     * @throws \app\modules\questionary\exceptions\UnknownFieldException
     */
    public function getQuestionFieldContent($questionField)
    {
        $values = [];
        $fieldType = 'input';

        $dataField = new DataField($questionField, $this->client);

        switch ($questionField->type) {
            case QuestionField::TYPE_INTEGER:
                break;
            case QuestionField::TYPE_STRING:
                break;
            case QuestionField::TYPE_SELECT:
                $fieldType = 'select';
                foreach ($questionField->questionFieldValues as $questionFieldValue) {
                    $values[] = $this->getValueContent($questionFieldValue, $dataField);
                }
                break;
            case QuestionField::TYPE_YEARLIST:
                $fieldType = 'select';
                foreach (Year::getList() as $year) {
                    $values[] = $this->getValueContent($year, $dataField);
                }
                break;
            case QuestionField::TYPE_BINARY:
                $fieldType = 'select';
                foreach (Binary::getList() as $variant) {
                    $values[] = $this->getValueContent($variant, $dataField);
                }
                break;
            case QuestionField::TYPE_RADIO:
                $fieldType = 'radio';
                $qFVCnt = count($questionField->questionFieldValues);
                foreach ($questionField->questionFieldValues as $questionFieldValue) {
                    $values[] = $this->getValueContent($questionFieldValue, $dataField, ['count' => $qFVCnt]);
                }
                break;
            case QuestionField::TYPE_DATE:
                break;
            case QuestionField::TYPE_TEXT:
                $fieldType = 'textarea';
                break;
            case QuestionField::TYPE_IMAGE:
                $fieldType = 'image';
                break;
            case QuestionField::TYPE_CHECKBOX:
                $fieldType = 'checkbox';
                break;
            case QuestionField::TYPE_WORKPLACE:
                $fieldType = 'workplace';
                break;
            case QuestionField::TYPE_STUDYPLACE:
                $fieldType = 'studyplace';
                break;
            default:
                throw new UnknownFieldTypeException($questionField->type);
                break;
        }

        return $this->render('question/questionFields/' . $fieldType, [
            'dataField' => $dataField,
            'values' => $values,
        ]);
    }

    /**
     * @param Question $question
     *
     * @return string
     * @throws InvalidConfigException
     * @throws UnknownFieldTypeException
     * @throws \app\modules\questionary\exceptions\UnknownClassException
     * @throws \app\modules\questionary\exceptions\UnknownFieldException
     */
    public function getQuestionContent($question)
    {
        $fields = [];
        foreach ($question->questionFieldsRelation as $questionField) {
            $fields[] = $this->getQuestionFieldContent($questionField);
        }

        return $this->render('question/question', [
            'model' => $question,
            'fields' => $fields
        ]);
    }

    /**
     * @param $sectionName
     *
     * @return string
     * @throws InvalidConfigException
     * @throws UnknownFieldTypeException
     * @throws \app\modules\questionary\exceptions\UnknownClassException
     * @throws \app\modules\questionary\exceptions\UnknownFieldException
     */
    public function getSectionContent($sectionName)
    {
        $arrQuestions = [];
        /** @var Question[] $questions */
        $questions = Question::find()->where([
            'section' => $sectionName,
            'hidden' => Question::HIDDEN_NO
        ])
            ->orderBy('ord')
            ->all();
        foreach ($questions as $question) {
            $arrQuestions[] = $this->getQuestionContent($question);
        }

        return $this->render('question/section', [
            'sectionName' => $sectionName,
            'sectionValue' => Question::SECTIONS[$sectionName],
            'questions' => $arrQuestions
        ]);
    }

    /**
     * @param Model $model
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function createFieldName($model)
    {
        return $model->formName() . '[field_' . $model->id . ']';
    }
}
