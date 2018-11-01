<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 26.03.18
 * Time: 19:22
 */

namespace app\modules\cabinet\controllers\frontend;

use krok\system\components\frontend\Controller;

/**
 * Class RulesController
 *
 * @package app\modules\cabinet\controllers\frontend
 */
class RulesController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
