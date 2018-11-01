<?php

namespace app\modules\cabinet\controllers\frontend;

use app\modules\cabinet\forms\ClientForm;
use krok\cabinet\models\Client;
use krok\system\components\frontend\Controller;
use Yii;
use yii\web\Response;

/**
 * Class DefaultController
 *
 * @package app\modules\cabinet\controllers\frontend
 */
class DefaultController extends Controller
{
    /**
     * @var string
     */
    public $layout = '//lk';

    /**
     * @return string|array
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->response->statusCode = 200;

            return ['result' => 'OK'];
        }
        /** @var Client $identity */
        $identity = Yii::$app->getUser()->getIdentity();
        $model = ClientForm::findOne($identity->getId());
        if ($model->isEsiaEmail()) {
            $model->login = '';
            $model->validate();
        }
        if ($model && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $client = Yii::createObject(Client::class)::findOne($model->id);
            $client->setAttributes($model->getAttributes());
            $client->save();
        }

        return $this->render('index', ['model' => $model]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout(false);

        return $this->goHome();
    }
}
