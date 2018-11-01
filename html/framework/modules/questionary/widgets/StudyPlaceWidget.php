<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 24.03.18
 * Time: 11:29
 */

namespace app\modules\questionary\widgets;

use app\modules\questionary\models\DataField;
use app\modules\questionary\models\StudyPlace;
use app\modules\questionary\models\StudyPlaceTraining;
use app\modules\questionary\widgets\assets\StudyPlaceAsset;
use yii\base\Widget;

/**
 * Class StudyPlaceWidget
 *
 * @package app\modules\questionary\widgets
 */
class StudyPlaceWidget extends Widget
{
    const SESSION_CURRENT_KEY = 'StudyPlaceWidget_session_current_key';

    /** @var DataField */
    public $dataField;
    /** @var bool */
    public $new = false;

    /**
     * @param StudyPlaceTraining $studyPlaceTraining
     * @param DataField $dataField
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getValueContent($studyPlaceTraining, $dataField)
    {
        return $this->render('question/questionFields/values/select', [
            'model' => $studyPlaceTraining,
            'dataField' => $dataField,
        ]);
    }

    /** @inheritdoc */
    public function run()
    {
        parent::run();

        $studyPlaces = [];
        if (!$this->new) {
            $this->resetKey();
        }
        StudyPlaceAsset::register($this->getView());
        if ($this->new) {
            $studyPlaces[] = $this->renderItem();
        } else {
            if ($this->dataField->value && is_array($this->dataField->value)) {
                foreach ($this->dataField->value as $key => $item) {
                    $studyPlace = new StudyPlace();
                    $studyPlace->setAttributes($item, false);
                    $studyPlaces[] = $this->renderItem($studyPlace, $key);
                }
            } else {
                $studyPlaces[] = $this->renderItem();
            }
        }

        return implode(PHP_EOL, $studyPlaces);
    }

    private function resetKey()
    {
        \Yii::$app->session->set(self::SESSION_CURRENT_KEY, 0);
    }

    /**
     * @param integer $key
     */
    private function saveKey($key)
    {
        \Yii::$app->session->set(self::SESSION_CURRENT_KEY, $key);
    }

    /**
     * @return integer
     */
    private function getIncrementKey()
    {
        $session = \Yii::$app->session;
        $key = $session->get(self::SESSION_CURRENT_KEY) + 1;
        $this->saveKey($key);

        return $key;
    }

    /**
     * @param StudyPlace $studyPlace
     * @param integer $key
     *
     * @return string
     * @throws \app\modules\questionary\exceptions\UnknownFieldException
     * @throws \yii\base\InvalidConfigException
     */
    public function renderItem($studyPlace = null, $key = null)
    {
        $values = [];
        $dataField = new DataField();

        if (!$studyPlace) {
            $studyPlace = new StudyPlace();
        } else {
            $dataField->value = $studyPlace->trainingId;
        }

        foreach (StudyPlaceTraining::getList() as $form) {
            $values[] = $this->getValueContent($form, $dataField);
        }

        if (null === $key) {
            $key = $this->getIncrementKey();
        } else {
            $this->saveKey($key);
        }

        return $this->render('studyPlace/item', [
            'model' => $studyPlace,
            'key' => $key,
            'dataField' => $this->dataField,
            'values' => $values
        ]);
    }
}
