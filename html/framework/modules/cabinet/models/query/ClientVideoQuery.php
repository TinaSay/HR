<?php

namespace app\modules\cabinet\models\query;

use app\modules\cabinet\models\ClientVideo;
use Yii;

/**
 * This is the ActiveQuery class for [[ClientVideo]].
 *
 * @see ClientVideo
 */
class ClientVideoQuery extends \yii\db\ActiveQuery
{
    /**
     * @param null|string $language
     *
     * @return $this
     */
    public function language($language = null)
    {
        if ($language === null) {
            $language = Yii::$app->language;
        }

        return $this->andWhere([ClientVideo::tableName() . '.[[language]]' => $language]);
    }

    /**
     * @inheritdoc
     * @return ClientVideo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ClientVideo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
