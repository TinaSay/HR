<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 15.03.18
 * Time: 12:54
 */

namespace app\components\services;

use app\modules\cabinet\models\SettingsMail;
use yii\swiftmailer\Mailer;

/**
 * Class SendEmailServiceBase
 *
 * @package app\services
 */
abstract class SendEmailServiceBase
{
    /**
     * @var array
     */
    public $mailerConfig = [
        'class' => '\yii\swiftmailer\Mailer',
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => '',
            'username' => '',
            'password' => '',
            'port' => '',
            'encryption' => ''
        ]
    ];

    /** @var Mailer $mailer */
    protected $mailer;

    /** @var SettingsMail $settingsMail */
    protected $settingsMail;

    /**
     * SendEmailService constructor.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct()
    {
        $this->settingsMail = new SettingsMail();
        $this->mailerConfig['transport'] = array_merge(
            $this->mailerConfig['transport'],
            $this->settingsMail->loadSettings()
        );

        $this->init();
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->mailer = \Yii::createObject($this->mailerConfig);
    }

    /**
     * @return Mailer
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * @param array $options
     *
     * @return boolean
     */
    abstract public function send($options);
}
