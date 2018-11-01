<?php

namespace app\modules\questionary\models;

use krok\extend\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%questionary_client}}".
 *
 * @property integer $id
 * @property integer $clientId
 * @property string $data
 * @property integer $filledPercent
 * @property integer $status
 * @property string $createdAt
 * @property string $updatedAt
 * @property \app\modules\cabinet\models\Client $clientRelation
 */
class Client extends \yii\db\ActiveRecord
{
    const EXPORT_XLS = 'xls';
    const SESSION_FULL_FILLED = 'QuestionaryClient_full_fulled';

    const STATUS_YES = 1;
    const STATUS_NO = 0;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
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
        return '{{%questionary_client}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clientId'], 'required'],
            [['clientId', 'status'], 'integer'],
            [['data'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [
                ['clientId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \krok\cabinet\models\Client::className(),
                'targetAttribute' => ['clientId' => 'id']
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
            'clientId' => 'Client ID',
            'data' => 'Data',
            'status' => 'Отправлено',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * @return boolean
     */
    public static function isFullFilled()
    {
        $client = \app\modules\cabinet\models\Client::findOne(\Yii::$app->user->id);

        return $client && $client->questionaryFilledPercent == 100;
    }

    /**
     * @return integer
     */
    public static function isSendProfile()
    {
        $client = Client::find()->where(['clientId' => \Yii::$app->user->id])->one();

        return $client && $client->status == Client::STATUS_YES;
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->status == Client::STATUS_YES
            && $this->getOldAttribute('status') == Client::STATUS_YES) {
            return false;
        }
        $this->fillFilledPercent();
        if (!$this->data) {
            $this->data = [];
        }
        if (is_array($this->data)) {
            $this->data = serialize($this->data);
        }

        if (parent::save($runValidation, $attributeNames)) {
            $client = $this->clientRelation;
            $client->countAndFillRating();

            return $client->save();
        }

        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientRelation()
    {
        return $this->hasOne(\app\modules\cabinet\models\Client::className(), ['id' => 'clientId']);
    }

    /**
     * @return $this
     */
    public function fillFilledPercent()
    {
        $questions = QuestionField::getActiveFields();
        $questionsArray = [];
        $questionCnt = 0;
        foreach ($questions as $question) {
            $questionsArray[$question->id] = true;
            $questionCnt++;
        }
        $dataArray = $this->getData();
        $count = 0;
        $findWithoutObligatory = false;
        foreach ($dataArray as $fieldName => $items) {
            if (isset($items['obligatory'])) {
                $obligatory = $items['obligatory'];
            } else {
                $findWithoutObligatory = true;
                $dataField = DataField::findOrInit($fieldName);
                $obligatory = $dataField->obligatory;
                if (null === $obligatory) {
                    unset($dataArray[$fieldName]);
                    continue;
                }
                $dataArray[$fieldName]['obligatory'] = $obligatory;
            }
            if ($obligatory) {
                $count++;
            }
            if (isset($items['modelId']) && array_key_exists($items['modelId'], $questionsArray)) {
                unset($questionsArray[$items['modelId']]);
            }
        }
        if ($findWithoutObligatory) {
            $this->data = $dataArray;
        }

        /* TODO: не заполненные поля */
        //$questionsArray
        $this->filledPercent = round($count * 100 / $questionCnt);

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = unserialize($this->data, []);
        if (is_array($data)) {
            return $data;
        }

        return [];
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_NO => 'Нет',
            self::STATUS_YES => 'Да',
        ];
    }
}
