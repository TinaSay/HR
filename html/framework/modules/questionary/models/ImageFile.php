<?php

namespace app\modules\questionary\models;

use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\storage\behaviors\UploaderBehavior;

/**
 * This is the model class for table "{{%questionary_image_file}}".
 *
 * @property integer $id
 * @property string $imageFile
 * @property integer $createdBy
 * @property string $createdAt
 * @property string $updatedAt
 */
class ImageFile extends \yii\db\ActiveRecord
{
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
            'UploaderBehavior' => [
                'class' => UploaderBehavior::class,
                'attribute' => 'imageFile',
                'scenarios' => [
                    self::SCENARIO_DEFAULT,
                ],
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
        return '{{%questionary_image_file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createdBy'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imageFile' => 'Image File',
            'createdBy' => 'Created By',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
