<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 13.03.18
 * Time: 10:35
 */

namespace app\modules\questionary\controllers\backend;

use app\modules\cabinet\models\ClientSearch;
use app\modules\questionary\widgets\Export;
use krok\cabinet\models\Client;
use krok\system\components\backend\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class ResultController extends Controller
{
    /**
     * Lists all Client models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Yii::createObject(ClientSearch::class);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param string $type
     *
     * @return string
     * @throws NotFoundHttpException
     * @throws \HttpRequestException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionDownload($format = 'xls')
    {
        ini_set('memory_limit', '128M');
        ini_set('max_execution_time', 1 * 60 * 60);
        $dataProvider = (new ClientSearch())->search(Yii::$app->getRequest()->getQueryParams());

        (new Export([
            'model' => new \app\modules\cabinet\models\Client(),
            'dataProvider' => $dataProvider,
            'attributes' => [
                'name',
                'login',
                'phone',
                'city',
                'work',
                'position',
                'questionaryFilledPercent',
                [
                    'attribute' => 'createdAt',
                    'value' => function ($model) {
                        return Yii::$app->getFormatter()->asDatetime($model->createdAt);
                    },
                ],
            ],
        ]))
            ->generate()
            ->sendFile(
                'Users-'
                . Yii::$app->getFormatter()->asDate(time(), 'php:d-m-Y')
                . '.' . $format,
                $format
            );
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\base\InvalidConfigException
     */
    protected function findModel($id)
    {
        if (($model = Yii::createObject(Client::class)::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
