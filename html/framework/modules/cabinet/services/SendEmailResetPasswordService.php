<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 21.03.18
 * Time: 19:28
 */

namespace app\modules\cabinet\services;

use app\components\services\SendEmailServiceBase;
use app\modules\cabinet\models\Client;
use Yii;

/**
 * Class SendEmailResetPasswordService
 *
 * @package app\modules\cabinet\services
 */
class SendEmailResetPasswordService extends SendEmailServiceBase
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

        $mailer = $this->mailer->compose('@app/modules/cabinet/mail/changePassword.php', [
            'model' => $client
        ])
            ->setSubject('Восстановление доступа к личному кабинету')
            ->setFrom([$email => $this->settingsMail->senderName])
            ->setTo($recipient);

        return $mailer->send();
    }
}
