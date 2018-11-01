<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 27.02.18
 * Time: 22:03
 */

namespace app\modules\cabinet\models;

use app\modules\cabinet\services\SendEmailChangeEmailService;
use app\modules\esia\components\EsiaConnect;

/**
 * Class Client
 *
 * @property string $oldEmail
 * @property string $name
 * @property string $city
 * @property string $phone
 * @property string $work
 * @property string $position
 * @property boolean $goalMinister
 * @property boolean $goalReserve
 * @property boolean $readyMunicipal
 * @property boolean $readyMove
 * @property integer $ratingExpert
 * @property integer $ratingManager
 * @property integer $ratingLeader
 * @property integer $rating
 * @property string $birthDate
 * @property string $birthPlace
 * @property string $gender
 * @property string $snils
 * @property string $passportNumber
 * @property string $validateHash
 * @property boolean $isPublic
 * @property integer $questionaryFilledPercent
 * @property \app\modules\questionary\models\Client $questionaryClientRelation
 * @package app\modules\cabinet\models
 */
class Client extends \krok\cabinet\models\Client
{
    const GOAL_RESERVE = 'reserve';
    const GOAL_MINISTER = 'minister';

    const BOOLEAN_YES = 1;
    const BOOLEAN_NO = 0;

    const SESSION_PASSWORD_HASH = 'hash';

    const ROLE_QUESTIONARY_VIEW = 'isViewAnket';

    public $listVideo;

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(
            [
                [['login', 'oldEmail'], 'email'],
                [['name'], 'string', 'max' => 100, 'min' => 2],
                [['phone', 'validateHash', 'passportNumber'], 'string', 'max' => 15, 'min' => 10],
                [['city', 'work', 'position', 'snils'], 'string', 'max' => 64, 'min' => 2],
                [
                    [
                        'isPublic',
                        'goalReserve',
                        'goalMinister',
                        'readyMove',
                        'readyMunicipal',
                    ],
                    'boolean'
                ],
                [['phone'], 'unique'],
                [['phone'], 'filter', 'skipOnEmpty' => true, 'filter' => function ($value) {
                    return preg_replace('/[^0-9]+/', '', $value);
                }],
                [['gender'], 'string', 'max' => 1],
                [['birthPlace', 'birthDate'], 'string', 'max' => 255],
                [['ratingExpert', 'ratingManager', 'ratingLeader', 'rating'], 'integer'],
            ],
            parent::rules()
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'login' => 'E-mail',
                'oldEmail' => 'Старый E-mail',
                'phone' => 'Номер телефона',
                'name' => 'Фамилия, имя и отчество',
                'city' => 'Город',
                'work' => 'Место работы',
                'position' => 'Укажите должность',
                'rating' => 'Общий рейтинг',
                'ratingExpert' => 'Рейтинг эксперта',
                'ratingManager' => 'Рейтинг мэнеджера',
                'ratingLeader' => 'Рейтинг лидера',
                'goalMinister' => 'Согласен на подачу заявки на министра',
                'goalReserve' => 'Согласен на подачу заявки в резерв',
                'readyMove' => 'Готов к переезду',
                'readyMunicipal' => 'Готов к муниципальной службе',
                'isPublic' => 'Работаю на государственной службе',
                'questionaryFilledPercent' => 'Процент заполненности анкеты',
                'video' => 'Видео файлы пользователя',
                'birthDate' => 'Дата рождения',
                'birthPlace' => 'Место рождения',
                'gender' => 'Пол',
                'snils' => 'СНИЛС',
                'passportNumber' => 'Номер паспорта',
            ]
        );
    }

    /** @inheritdoc */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->clientOAuthRelation) {
            $this->setAttribute('name', $this->getOldAttribute('name'));
            $this->setAttribute('phone', $this->getOldAttribute('phone'));
            if ($this->isEsiaEmail(true)) {
                if (!$this->oldEmail) {
                    $this->setOldAttribute('validateHash', '');
                }
            } else {
                $this->setAttribute('login', $this->getOldAttribute('login'));
            }
        }
        if ($this->isNewRecord) {
            $this->generateHash();
        } elseif (!strcmp($this->password, $this->getOldAttribute('password'))) {
            $this->password = '';
        }
        if (!$this->isNewRecord
            && strcmp($this->login, $this->getOldAttribute('login'))
            && !$this->getOldAttribute('validateHash')) {
            $this->oldEmail = $this->login;
            $this->login = $this->getOldAttribute('login');
            $this->generateHash();
            $service = new SendEmailChangeEmailService();
            $service->send(['model' => $this, 'recipient' => $this->oldEmail]);

            \Yii::$app->session->setFlash('success', 'На ваш новый e-mail адрес отправлено письмо с дальнейшими инструкциями!');
        }

        return parent::save($runValidation, $attributeNames);
    }

    /**
     * @return bool
     */
    public function isEsiaEmail($old = false)
    {
        $login = $this->login;
        if ($old) {
            $login = $this->getOldAttribute('login');
        }

        return false !== strpos($login, EsiaConnect::ESIA_SUFFIX);
    }

    /**
     * @param array $data
     * @param null $formName
     *
     * @return bool
     */
    public function load($data, $formName = null)
    {
        if (parent::load($data, $formName)) {
            $this->readyMunicipal = $this->readyMunicipal === 'on' ? self::BOOLEAN_YES : self::BOOLEAN_NO;
            $this->readyMove = $this->readyMove === 'on' ? self::BOOLEAN_YES : self::BOOLEAN_NO;
            $this->isPublic = $this->isPublic === 'on' ? self::BOOLEAN_YES : self::BOOLEAN_NO;

            return true;
        }

        return false;
    }

    /**
     * @param string $hash
     *
     * @return array|\krok\cabinet\models\Client|null
     */
    public static function getByHash($hash)
    {
        return self::find()->where(['validateHash' => $hash])->one();
    }

    /**
     * @param string $login
     *
     * @return array|\krok\cabinet\models\Client|null
     */
    public static function getByLogin($login)
    {
        return Client::find()->where(['login' => $login])->one();
    }

    public function generateHash()
    {
        $this->validateHash = \Yii::$app->getSecurity()->generateRandomString(15);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionaryClientRelation()
    {
        return $this->hasOne(\app\modules\questionary\models\Client::className(), ['clientId' => 'id']);
    }

    /**
     * @return int
     */
    public function getQuestionaryFilledPercent()
    {
        $relation = $this->questionaryClientRelation;
        if ($relation) {
            return $relation->filledPercent;
        }

        return 0;
    }

    public function countAndFillRating()
    {
        $questionaryClient = $this->questionaryClientRelation;
        if ($questionaryClient) {
            $dataArray = $questionaryClient->getData();
            $ratingExpert = 0;
            $ratingManager = 0;
            $ratingLeader = 0;
            foreach ($dataArray as $key => $item) {
                if (is_array($item)) {
                    $ratingExpert += $item['costExpert'] ?? 0;
                    $ratingLeader += $item['costLeader'] ?? 0;
                    $ratingManager += $item['costManager'] ?? 0;
                }
            }
            $this->ratingManager = $ratingManager;
            $this->ratingLeader = $ratingLeader;
            $this->ratingExpert = $ratingExpert;
            $this->rating = $this->getRating();
        }
    }

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->ratingManager + $this->ratingExpert + $this->ratingLeader;
    }

    /**
     * @return string
     */
    public function getListVideo()
    {
        $output = "";
        $list = ClientVideo::find()->where(['clientId' => $this->id])->orderBy(['latest' => SORT_DESC])->all();
        if ($list !== null) {
            $output .= '<ul>';
            foreach ($list as $key => $value) {
                $last = "";
                if ($value->latest == ClientVideo::LATEST_YES) {
                    $last = 'Последнее добавленное';
                }
                $output .= '<li><a href="' . $value->src . '">' . $value->src . '</a>&nbsp;<span>(добавлено: ' . $value->createdAt . ')</span> - <span style="color:#ff0000">' . $last . '</span></li>';
            }
            $output .= '</ul>';
        }

        return $output;
    }
}
