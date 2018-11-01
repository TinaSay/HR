<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 28.02.18
 * Time: 14:18
 */

namespace app\modules\cabinet\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class ClientSearch
 *
 * @package app\modules\cabinet\models
 */
class ClientSearch extends Client
{
    /**
     * @var integer
     */
    public $filledPercent;

    /**
     * @var integer
     */
    public $clientRating;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'blocked'], 'integer'],
            [
                [
                    'login',
                    'name',
                    'city',
                    'work',
                    'position',
                    'phone',
                    'goalReserve',
                    'goalMinister',
                    'readyMunicipal',
                    'readyMove',
                    'filledPercent',
                    'clientRating',
                    'createdAt',
                    'updatedAt'
                ], 'safe'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
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
        $query = static::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->leftJoin(
            \app\modules\questionary\models\Client::tableName() . ' qc',
            \krok\cabinet\models\Client::tableName() . '.id = qc.clientId'
        );
        if (\Yii::$app->authManager->getAssignment(self::ROLE_QUESTIONARY_VIEW, \Yii::$app->user->id)) {
            $query->andFilterWhere(['=', 'qc.filledPercent', 100]);
        } else {
            $query->andFilterWhere(['>', 'qc.filledPercent', $this->filledPercent]);
        }

        $query->andFilterWhere(['>', 'rating', $this->clientRating]);
        $query->andFilterWhere([
            'id' => $this->id,
            'blocked' => $this->blocked,
        ]);
        $query->andFilterWhere(['goalReserve' => $this->goalReserve]);
        $query->andFilterWhere(['goalMinister' => $this->goalMinister]);
        $query->andFilterWhere(['readyMove' => $this->readyMove]);
        $query->andFilterWhere(['readyMunicipal' => $this->readyMunicipal]);

        $query
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'work', $this->work])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'createdAt', $this->createdAt])
            ->andFilterWhere(['like', 'updatedAt', $this->updatedAt]);

        return $dataProvider;
    }
}
