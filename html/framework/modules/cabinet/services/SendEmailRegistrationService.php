<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 15.03.18
 * Time: 13:52
 */

namespace app\modules\cabinet\services;

use app\components\services\SendEmailServiceBase;
use app\modules\cabinet\models\Client;
use Yii;

/**
 * Class SendEmailRegistrationService
 *
 * @package app\modules\cabinet\services
 */
class SendEmailRegistrationService extends SendEmailServiceBase
{
    /**
     * @param array $options = [
     *  'model' => Client $client,
     *  'recipient' => string $recipient
     * ]
     *
     * @return bool
     */
    public function send($options)
    {
        /** @var Client $client */
        $client = $options['model'];
        $recipient = $options['recipient'];
        $email = $this->settingsMail->email;
        if (!$email) {
            $email = Yii::$app->params['email'];
        }

        $mailer = $this->mailer->compose('@app/modules/cabinet/mail/completeRegister.php', [
            'model' => $client
        ])
            ->setSubject('Регистрация на портале')
            ->setFrom([$email => $this->settingsMail->senderName])
            ->setTo($recipient);

        return $mailer->send();
    }
}
