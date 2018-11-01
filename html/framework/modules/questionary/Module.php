<?php

namespace app\modules\questionary;

use krok\system\components\backend\NameInterface;
use Yii;

/**
 * quetionary module definition class
 */
class Module extends \yii\base\Module implements NameInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public static function getName()
    {
        return Yii::t('system', 'Questionary');
    }
}
