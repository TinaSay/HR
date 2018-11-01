<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 27.02.18
 * Time: 20:48
 */

namespace app\modules\cabinet\controllers\frontend;

use app\modules\cabinet\forms\ClientForm;
use app\modules\cabinet\services\SendEmailRegistrationService;
use krok\cabinet\models\Client;
use \app\modules\cabinet\models\Client as CabinetClient;
use krok\system\components\frontend\Controller;
use Yii;
use yii\web\Response;

/**
 * Class RegisterController
 *
 * @package app\modules\cabinet\controllers\frontend
 */
class RegisterController extends Controller
{
    /**
     * @param string $hash
     *
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionValidate($hash)
    {
        /** @var ClientForm $model */
        $model = ClientForm::getByHash($hash);
        if ($model) {
            $model->blocked = Client::BLOCKED_NO;
            $model->validateHash = '';
            if ($model->save()) {
                $client = Yii::createObject(Client::class)::findOne($model->id);
                Yii::$app->getUser()->login($client);
            }
        }

        return $this->redirect(Yii::$app->getUser()->getReturnUrl());
    }

    /**
     * @param string $goal
     *
     * @return string|\yii\web\Response|array
     * @throws \HttpInvalidParamException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRegister($goal = null)
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(Yii::$app->getUser()->getReturnUrl());
        }

        $post = Yii::$app->request->post();
        $step = $post['ClientForm']['step'] ?? 'zero';
        $model = new ClientForm();
        $model->blocked = Client::BLOCKED_YES;
        if ($goal == CabinetClient::GOAL_MINISTER) {
            $model->goalMinister = CabinetClient::BOOLEAN_YES;
        } elseif ($goal == CabinetClient::GOAL_RESERVE) {
            $model->goalReserve = CabinetClient::BOOLEAN_YES;
        }
        $model->loadFromSession();
        if ($post) {
            $model->load($post);
            $model->validate();
            $model->saveToSession();
        }
        if (isset($post['key'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ['result' => 'OK'];
        }

        switch ($step) {
            case 'zero':
                $model->setScenario(ClientForm::SCENARIO_STEP_FIRST);
                $view = ClientForm::SCENARIO_STEP_FIRST;
                break;
            case ClientForm::SCENARIO_STEP_FIRST:
                if ($model->hasErrors()) {
                    $model->setScenario(ClientForm::SCENARIO_STEP_FIRST);
                    $view = ClientForm::SCENARIO_STEP_FIRST;
                } else {
                    $model->setScenario(ClientForm::SCENARIO_STEP_SECOND);
                    $view = ClientForm::SCENARIO_STEP_SECOND;
                }
                break;
            case ClientForm::SCENARIO_STEP_SECOND:
                if ($model->hasErrors()) {
                    $model->setScenario(ClientForm::SCENARIO_STEP_SECOND);
                    $view = ClientForm::SCENARIO_STEP_SECOND;
                } else {
                    $model->setScenario(ClientForm::SCENARIO_STEP_THIRD);
                    $view = ClientForm::SCENARIO_STEP_THIRD;
                }
                break;
            case ClientForm::SCENARIO_STEP_THIRD:
                if ($model->hasErrors()) {
                    $model->setScenario(ClientForm::SCENARIO_STEP_THIRD);
                    $view = ClientForm::SCENARIO_STEP_THIRD;
                } else {
                    $client = Yii::createObject(Client::class);
                    $client->setScenario($model::SCENARIO_CREATE);
                    $client->setAttributes($model->getAttributes());
                    if ($client->save()) {
                        $service = new SendEmailRegistrationService();
                        $service->send(['model' => $client, 'recipient' => $model->login]);

                        $model->cleanSession();
                        $view = ClientForm::SCENARIO_STEP_FOURTH;
                    } else {
                        $view = ClientForm::SCENARIO_STEP_FIRST;
                        $model->setScenario(ClientForm::SCENARIO_STEP_FIRST);
                    }
                }
                break;
            default:
                throw new \HttpInvalidParamException();
                break;
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('/register/' . $view, ['model' => $model]);
        }

        return $this->redirect('/');
    }
}
