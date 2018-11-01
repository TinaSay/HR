<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 11.09.17
 * Time: 17:10
 */

namespace app\modules\cabinet\controllers\frontend;

use krok\system\components\frontend\Controller;
use Yii;
use yii\filters\auth\QueryParamAuth;

/**
 * Class AuthController
 *
 * @package app\modules\cabinet\controllers\frontend
 */
class AuthController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => QueryParamAuth::class,
            ],
        ];
    }

    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(Yii::$app->getUser()->getReturnUrl());
        }

        return $this->goHome();
    }
}
