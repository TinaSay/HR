<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 15.03.18
 * Time: 13:00
 */

namespace app\modules\cabinet\models;

use app\components\PostCardConfig;
use Yii;
use yii\base\Model;

class SettingsMail extends Model
{
    const HIDDEN_PASSWORD = '********';
    const CONFIG_FILE = 'mail.cfg';

    /**
     * @var string
     */
    public $host = '';

    /**
     * @var string
     */
    public $username = '';

    /**
     * @var string
     */
    public $password = '';

    /**
     * @var integer
     */
    public $port = '';

    /**
     * @var string
     */
    public $encryption = '';

    /**
     * @var string
     */
    public $hiddenPassword = '';

    /** @var string */
    public $senderName = '';

    /** @var string */
    public $email = '';

    /**
     * @var string
     */
    private $_encryptKey = 'super_key';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'senderName',
                    'host',
                    'username',
                    'hiddenPassword',
                    'port'
                ],
                'required'
            ],
            [
                [
                    'senderName',
                    'email',
                    'host',
                    'username',
                    'password',
                    'encryption',
                    'hiddenPassword',
                ],
                'string'
            ],
            ['port', 'integer'],
            ['email', 'email']
        ];
    }

    /**
     * @return bool|string
     */
    private function decryptPassword()
    {
        return Yii::$app->security->decryptByPassword($this->password, $this->_encryptKey);
    }

    /**
     * @param string $password
     *
     * @return string
     */
    private function encryptPassword($password)
    {
        return Yii::$app->security->encryptByPassword($password, $this->_encryptKey);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'senderName' => Yii::t('system', 'Sender name'),
            'host' => Yii::t('system', 'Host'),
            'username' => Yii::t('system', 'Login'),
            'password' => Yii::t('system', 'Password'),
            'hiddenPassword' => Yii::t('system', 'Password'),
            'port' => Yii::t('system', 'Port'),
            'encryption' => Yii::t('system', 'Encryption'),
        ];
    }

    /**
     * Загрузка настроек из файла
     *
     * @return array
     */
    public function loadSettings()
    {
        $this->attributes = PostcardConfig::load(self::CONFIG_FILE, [
            'host' => '',
            'username' => '',
            'password' => '',
            'port' => '',
            'encryption' => ''
        ]);

        $this->password = $this->decryptPassword();
        $this->hiddenPassword = self::HIDDEN_PASSWORD;

        return $this->getAttributes([
            'host',
            'username',
            'password',
            'port',
            'encryption'
        ]);
    }

    /**
     * Сохранение настроек в файл
     *
     * @return boolean
     */
    public function saveSettings()
    {
        if (strcmp($this->hiddenPassword, self::HIDDEN_PASSWORD)) {
            $this->password = $this->encryptPassword($this->hiddenPassword);
        } else {
            $this->password = $this->encryptPassword($this->password);
        }
        $this->hiddenPassword = self::HIDDEN_PASSWORD;

        return PostcardConfig::save(self::CONFIG_FILE, $this->toArray());
    }
}
