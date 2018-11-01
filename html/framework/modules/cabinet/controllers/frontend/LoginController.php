<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 04.02.16
 * Time: 0:11
 */

namespace app\modules\cabinet\controllers\frontend;

use app\modules\cabinet\forms\ClientForm;
use krok\cabinet\models\Client;
use krok\cabinet\models\Login;
use krok\cabinet\models\OAuth;
use krok\system\components\frontend\Controller;
use Yii;
use yii\authclient\ClientInterface;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * Class LoginController
 *
 * @package app\modules\cabinet\controllers\frontend
 */
class LoginController extends Controller
{
    /**
     * @var string
     */
    public $layout = '//common';

    /**
     * @return array
     */
    public function actions()
    {
        $url = Yii::$app->getUrlManager()->getHostInfo() . Yii::$app->getUser()->getReturnUrl();

        return [
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'cmf2' : null,
            ],
            'oauth' => [
                'class' => \yii\authclient\AuthAction::class,
                'successCallback' => [$this, 'OAuthCallback'],
                'successUrl' => $url,
                'cancelUrl' => $url,
            ],
        ];
    }

    /**
     * @param ClientInterface $client
     *
     * @throws Exception
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function OAuthCallback(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();

        if (empty($attributes)) {
            throw new InvalidConfigException('Empty user attributes');
        }

        /* @var $OAuth OAuth */
        $OAuth = OAuth::find()->where([
            'source' => $client->getId(),
            'sourceId' => $attributes['id'],
        ])->one();

        if (Yii::$app->getUser()->getIsGuest()) {
            if ($OAuth instanceof OAuth) {
                // login
                if ($OAuth->clientRelation->blocked == Client::BLOCKED_NO) {
                    Yii::$app->getUser()->login($OAuth->clientRelation);
                } else {
                    Yii::$app->getSession()->addFlash('danger', 'Ваш аккаунт заблокирован');
                }
            } else {
                // signUp
                if (isset($attributes['login']) && Yii::createObject(Client::class)::find()->where(['login' => $attributes['login']])->exists()) {
                    Yii::$app->getSession()->addFlash('danger',
                        sprintf('Пользователь %s совпадает с учетной записью %s, но не связан с ней',
                            $attributes['login'], $client->getTitle()));
                } else {
                    $password = Yii::$app->getSecurity()->generateRandomString(8);
                    /** @var Client $user */
                    $user = Yii::createObject([
                        'class' => Client::class,
                        'login' => $attributes['login'],
                        'password' => $password,
                        'blocked' => Client::BLOCKED_NO,
                        'snils' => $attributes['snils'] ?? '',
                        'gender' => $attributes['gender'] ?? '',
                        'birthDate' => date('Y-m-d', strtotime($attributes['birthDate'] ?? '')),
                        'birthPlace' => $attributes['birthPlace'] ?? '',
                    ]);
                    $user->setScenario(Client::SCENARIO_CREATE);
                    if (isset($attributes['name'])) {
                        $user->name = $attributes['name'];
                    }
                    if (isset($attributes['phone'])) {
                        $user->phone = $attributes['phone'];
                    }
                    $transaction = Yii::$app->getDb()->beginTransaction();
                    if ($user->save()) {
                        $OAuth = new OAuth([
                            'clientId' => $user->id,
                            'source' => $client->getId(),
                            'sourceId' => (string)$attributes['id'],
                        ]);
                        if ($OAuth->save()) {
                            $transaction->commit();
                            if ($user->blocked == Client::BLOCKED_NO) {
                                Yii::$app->getUser()->login($user);
                            } else {
                                Yii::$app->getSession()->addFlash('success',
                                    'Ваш аккаунт зарегистрирован, дождитесь его активации администратором');
                            }
                        } else {
                            $transaction->rollBack();
                            throw new Exception('', $OAuth->getErrors());
                        }
                    } else {
                        $transaction->rollBack();
                        throw new Exception('', $user->getErrors() + $attributes);
                    }
                }
            }
        } else {
            // user already logged in
            if (!($OAuth instanceof OAuth)) {
                // add user provider
                $OAuth = new OAuth([
                    'clientId' => Yii::$app->getUser()->getId(),
                    'source' => $client->getId(),
                    'sourceId' => (string)$attributes['id'],
                ]);
                if ($OAuth->save()) {
                    Yii::$app->getSession()->addFlash('success',
                        sprintf('Аккаунт <b>%s</b> привязан к социальной сети <b>%s</b>',
                            ArrayHelper::getValue(Yii::$app->getUser()->getIdentity(), 'login'),
                            $client->getTitle()));
                } else {
                    throw new Exception('', $OAuth->getErrors());
                }
            } elseif ($OAuth->clientId == Yii::$app->getUser()->getId()) {
                Yii::$app->getSession()->addFlash('info',
                    sprintf('Аккаунт <b>%s</b> уже привязан к социальной сети <b>%s</b>',
                        ArrayHelper::getValue(Yii::$app->getUser()->getIdentity(), 'login'), $client->getTitle()));
            } else {
                Yii::$app->getSession()->addFlash('danger',
                    sprintf('Социальная сеть <b>%s</b> уже привязана к другому аккаунту', $client->getTitle()));
            }
        }
    }

    /**
     * @param $hash
     *
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionChangeEmail($hash)
    {
        /** @var ClientForm $model */
        $model = ClientForm::getByHash($hash);
        if ($model) {
            $email = $model->oldEmail;
            $model->oldEmail = $model->login;
            $model->login = $email;
            $model->validateHash = '';
            if ($model->save()) {
                $client = Yii::createObject(Client::class)::findOne($model->id);
                Yii::$app->getUser()->login($client);
                \Yii::$app->session->setFlash('success', 'Ваш e-mail адрес успешно изменен!');
            }
        }

        return $this->redirect(Yii::$app->getUser()->getReturnUrl());
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(Yii::$app->getUser()->getReturnUrl());
        }

        $model = Yii::createObject(Login::class);

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Yii::$app->getUser()->getReturnUrl());
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('/login/login', ['model' => $model]);
        }

        return $this->redirect('/');
    }
}
