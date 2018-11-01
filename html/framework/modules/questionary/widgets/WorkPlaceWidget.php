<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 09.03.18
 * Time: 14:27
 */

namespace app\modules\questionary\widgets;

use app\modules\questionary\models\DataField;
use app\modules\questionary\models\WorkPlace;
use app\modules\questionary\models\WorkPlacePosition;
use app\modules\questionary\widgets\assets\WorkPlaceAsset;
use yii\base\Widget;

/**
 * Class WorkPlaceWidget
 *
 * @package app\modules\questionary\widgets
 */
class WorkPlaceWidget extends Widget
{
    const SESSION_CURRENT_KEY = 'WorkPlaceWidget_session_current_key';

    /** @var DataField */
    public $dataField;
    /** @var bool */
    public $new = false;

    /**
     * @param WorkPlacePosition $workPlace
     * @param DataField $dataField
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getValueContent($workPlace, $dataField)
    {
        return $this->render('question/questionFields/values/select', [
            'model' => $workPlace,
            'dataField' => $dataField,
        ]);
    }

    /** @inheritdoc */
    public function run()
    {
        parent::run();

        $workPlaces = [];
        if (!$this->new) {
            $this->resetKey();
        }
        WorkPlaceAsset::register($this->getView());
        if ($this->new) {
            $workPlaces[] = $this->renderItem();
        } else {
            if ($this->dataField->value && is_array($this->dataField->value)) {
                foreach ($this->dataField->value as $key => $item) {
                    $workPlace = new WorkPlace();
                    $workPlace->setAttributes($item, false);
                    $workPlaces[] = $this->renderItem($workPlace, $key);
                }
            } else {
                $workPlaces[] = $this->renderItem();
            }
        }

        return implode(PHP_EOL, $workPlaces);
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
     * @param WorkPlace $workPlace
     * @param integer $key
     *
     * @return string
     * @throws \app\modules\questionary\exceptions\UnknownFieldException
     * @throws \yii\base\InvalidConfigException
     */
    public function renderItem($workPlace = null, $key = null)
    {
        $values = [];
        $dataField = new DataField();

        if (!$workPlace) {
            $workPlace = new WorkPlace();
        } else {
            $dataField->value = $workPlace->positionId;
        }

        foreach (WorkPlacePosition::getList() as $position) {
            $values[] = $this->getValueContent($position, $dataField);
        }

        if (null === $key) {
            $key = $this->getIncrementKey();
        } else {
            $this->saveKey($key);
        }

        return $this->render('workPlace/item', [
            'model' => $workPlace,
            'key' => $key,
            'dataField' => $this->dataField,
            'values' => $values
        ]);
    }
}
