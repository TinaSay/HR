<?php

namespace app\modules\cabinet\models;

use app\modules\auth\models\Auth;
use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\LanguageBehavior;
use krok\extend\behaviors\TimestampBehavior;
use app\modules\cabinet\models\query\ClientVideoQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%client_video}}".
 *
 * @property integer $id
 * @property integer $clientId
 * @property string $src
 * @property integer $latest
 * @property string $language
 * @property integer $createdBy
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property Auth $createdBy0
 * @property Client $client
 */
class ClientVideo extends \yii\db\ActiveRecord
{
    const LATEST_YES = 1;
    const LATEST_NO = 0;
    const SAVE_PATH = '/uploads/video';
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
        return '{{%client_video}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'LanguageBehavior' => [
                'class' => LanguageBehavior::class,
            ],
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
            ],
            'CreatedByBehavior' => [
                'class' => CreatedByBehavior::class,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clientId'], 'required'],
            [['clientId', 'latest', 'createdBy'], 'integer'],
            [['src'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['language'], 'string', 'max' => 8],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['createdBy' => 'id']],
            [['clientId'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['clientId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clientId' => 'Пользователь',
            'src' => 'Путь к файлу',
            'latest' => 'Последнее видео',
            'language' => 'Язык',
            'createdBy' => 'Автор',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy0()
    {
        return $this->hasOne(Auth::className(), ['id' => 'createdBy']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'clientId']);
    }

    /**
     * @inheritdoc
     * @return ClientVideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientVideoQuery(get_called_class());
    }

    /**
     * @return mixed
     */
    public function getLatest()
    {
        return ArrayHelper::getValue(self::getLatestList(), $this->latest);
    }

    /**
     * @return array
     */
    public static function getLatestList()
    {
        return [
            self::LATEST_NO => 'Нет',
            self::LATEST_YES => 'Да',
        ];
    }

    /**
     * @return null|string
     */
    public function getClientTitle()
    {
        return is_null($this->clientId) ? null : $this->client->name;
    }
}
