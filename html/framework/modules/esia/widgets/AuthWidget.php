<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 15.03.18
 * Time: 19:31
 */

namespace app\modules\esia\widgets;

use yii\jui\Widget;
use yii\log\Logger;

/**
 * Class EsiaAuthWidget
 *
 * @package app\modules\esia\widgets
 */
class AuthWidget extends Widget
{
    /** @var string */
    public $name;
    /** @var string */
    public $esiaClientName = 'esia';

    /** @inheritdoc */
    public function run()
    {
        parent::run();

        return $this->renderButton();
    }

    /**
     * @return string
     */
    public function renderButton()
    {
        try {
            $esia = \Yii::$app->authClientCollection->getClient($this->esiaClientName);
            $authUrl = $esia->buildAuthUrl();
        } catch (\Exception $ex) {
            $authUrl = '#';
            \Yii::getLogger()->log(
                'Message: ' . $ex->getMessage()
                . "\nLine: " . $ex->getLine()
                . "\nFile: " . $ex->getFile(),
                Logger::LEVEL_ERROR
            );
        }

        return $this->render('button', ['url' => $authUrl, 'name' => $this->name]);
    }
}
