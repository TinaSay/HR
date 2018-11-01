<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 13.03.18
 * Time: 13:21
 */

namespace app\modules\questionary\widgets;

use app\modules\questionary\models\DataField;
use app\modules\questionary\models\Question;
use app\modules\questionary\models\QuestionField;
use yii\jui\Widget;

/**
 * Class QuestionViewWidget
 *
 * @package app\modules\questionary\widgets
 */
class QuestionViewWidget extends Widget
{
    /** @var \app\modules\cabinet\models\Client */
    public $model;

    /** @inheritdoc */
    public function run()
    {
        $relation = $this->model->questionaryClientRelation;
        $contentArray = [];
        parent::run();
        if ($relation && $relation->data) {
            foreach (Question::TABS as $tabName => $tabValue) {
                $content = $this->getTabContent($tabName);
                if ($content) {
                    $contentArray[] = $content;
                }
            }
        }

        return $this->render('questionView/index', [
            'client' => $this->model,
            'contentArray' => $contentArray,
        ]);
    }

    /**
     * @param string $tabName
     *
     * @return string
     */
    public function getTabContent($tabName)
    {
        $contentArray = [];
        foreach (Question::TABS_SECTIONS[$tabName] as $tabSection) {
            $content = $this->getTabSectionContent($tabSection);
            if ($content) {
                $contentArray[] = $content;
            }
        }
        if ($contentArray) {
            return $this->render('questionView/tab', [
                'name' => Question::TABS[$tabName],
                'contentArray' => $contentArray
            ]);
        }

        return '';
    }

    /**
     * @param string $tabSection
     *
     * @return string
     */
    public function getTabSectionContent($tabSection)
    {
        $contentArray = [];
        /** @var Question[] $questions */
        $questions = Question::find()->where([
            'section' => $tabSection,
            'hidden' => Question::HIDDEN_NO
        ])
            ->orderBy('ord')
            ->all();
        foreach ($questions as $question) {
            $content = $this->getQuestionContent($question);
            if ($content) {
                $contentArray[] = $content;
            }
        }
        if ($contentArray) {
            return $this->render('questionView/tabSection', [
                'name' => Question::SECTIONS[$tabSection],
                'contentArray' => $contentArray
            ]);
        }

        return '';
    }

    /**
     * @param Question $question
     *
     * @return string
     * @throws \app\modules\questionary\exceptions\UnknownFieldException
     * @throws \yii\base\InvalidConfigException
     */
    public function getQuestionContent(Question $question)
    {
        $contentArray = [];

        foreach ($question->questionFieldsRelation as $questionField) {
            $content = $this->getQuestionFieldContent($questionField);
            if ($content) {
                $contentArray[] = $content;
            }
        }
        if ($contentArray) {
            return $this->render('questionView/question', [
                'question' => $question,
                'contentArray' => $contentArray
            ]);
        }

        return '';
    }

    /**
     * @param QuestionField $questionField
     *
     * @return string
     * @throws \app\modules\questionary\exceptions\UnknownFieldException
     * @throws \yii\base\InvalidConfigException
     */
    public function getQuestionFieldContent(QuestionField $questionField)
    {
        $dataField = new DataField($questionField, $this->model);

        if ($dataField->exist()) {
            $value = $dataField->text;
            if ($dataField->type == QuestionField::TYPE_IMAGE) {
                $value = $this->render('questionView/image', ['path' => $value]);
            }

            return $this->render('questionView/questionField', [
                'questionField' => $questionField,
                'value' => $value,
            ]);
        }

        return '';
    }
}
