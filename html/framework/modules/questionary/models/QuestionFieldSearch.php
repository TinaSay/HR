<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 14.03.18
 * Time: 17:09
 */

namespace app\modules\questionary\models;

use yii\data\ActiveDataProvider;

class QuestionFieldSearch extends QuestionField
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                ], 'safe'
            ],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = static::find()->orderBy('ord');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
