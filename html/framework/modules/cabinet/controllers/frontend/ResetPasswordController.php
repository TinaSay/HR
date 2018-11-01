<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 22.03.18
 * Time: 16:10
 */

namespace app\modules\cabinet\controllers\frontend;

use app\modules\cabinet\forms\ClientForm;
use app\modules\cabinet\models\Client;
use app\modules\cabinet\services\SendEmailResetPasswordService;
use krok\system\components\frontend\Controller;
use Yii;

/**
 * Class ResetPasswordController
 *
 * @package app\modules\cabinet\controllers\frontend
 */
class ResetPasswordController extends Controller
{
    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        if (!Yii::$app->request->isAjax) {
            return $this->redirect(Yii::$app->getUser()->getReturnUrl());
        }
        $model = new ClientForm();
        if ($model->load(Yii::$app->request->post())) {
            /** @var Client $client */
            if ($client = Client::getByLogin($model->login)) {
                $client->generateHash();
                if ($client->save()) {
                    $service = new SendEmailResetPasswordService();
                    $service->send(['model' => $client, 'recipient' => $client->login]);

                    return $this->renderAjax('emailSend', ['model' => $model]);
                }
            } else {
                return $this->renderAjax('notFound', ['model' => $model]);
            }
        }

        return $this->renderAjax('index', ['model' => $model]);
    }

    /**
     * @param $hash
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($hash)
    {
        if (!Yii::$app->request->isAjax) {
            Yii::$app->session->set(ClientForm::SESSION_PASSWORD_HASH, $hash);

            return $this->redirect(Yii::$app->getUser()->getReturnUrl());
        }
        $model = ClientForm::getByHash($hash);
        if ($model) {
            $model->setScenario(ClientForm::SCENARIO_STEP_SECOND);

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $client = Yii::createObject(Client::class)::findOne($model->id);
                $client->password = $model->password;
                $client->validateHash = '';
                if ($client->save()) {
                    Yii::$app->user->login($client);
                    Yii::$app->session->remove(ClientForm::SESSION_PASSWORD_HASH);

                    return $this->renderAjax('success');
                }
            }

            return $this->renderAjax('update', ['model' => $model]);
        }
        Yii::$app->session->remove(ClientForm::SESSION_PASSWORD_HASH);

        return $this->redirect(Yii::$app->getUser()->getReturnUrl());
    }
}
