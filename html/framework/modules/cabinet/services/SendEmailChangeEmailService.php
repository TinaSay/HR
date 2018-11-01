<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 23.03.18
 * Time: 7:54
 */

namespace app\modules\cabinet\services;

use app\components\services\SendEmailServiceBase;
use app\modules\cabinet\models\Client;
use Yii;

/**
 * Class SendEmailChangeEmailService
 *
 * @package app\modules\cabinet\services
 */
class SendEmailChangeEmailService extends SendEmailServiceBase
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

        $mailer = $this->mailer->compose('@app/modules/cabinet/mail/changeEmail.php', [
            'model' => $client
        ])
            ->setSubject('Запрос на смену e-mail адреса')
            ->setFrom([$email => $this->settingsMail->senderName])
            ->setTo($recipient);

        return $mailer->send();
    }
}
