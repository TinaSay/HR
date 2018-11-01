<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 01.03.18
 * Time: 21:54
 */

namespace app\modules\questionary\controllers\cabinet;

use app\modules\questionary\models\Client;
use \app\modules\cabinet\models\Client as CabinetClient;
use app\modules\questionary\models\DataField;
use app\modules\questionary\models\ImageFile;
use app\modules\questionary\models\QuestionField;
use app\modules\questionary\widgets\StudyPlaceWidget;
use app\modules\questionary\widgets\WorkPlaceWidget;
use krok\system\components\frontend\Controller;
use Yii;
use yii\helpers\Url;
use yii\web\Response;

/**
 * Class SectionController
 *
 * @package app\modules\questionary\controllers\cabinet
 */
class QuestionController extends Controller
{
    /**
     * @var string
     */
    public $layout = '//lk';

    /**
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionIndex()
    {
        $client = \app\modules\cabinet\models\Client::findOne(Yii::$app->getUser()->getId());

        return $this->render('index', ['model' => $client]);
    }

    /**
     * @param DataField $dataField
     *
     * @return array
     * @throws \app\modules\questionary\exceptions\UnknownClassException
     * @throws \app\modules\questionary\exceptions\UnknownFieldException
     * @throws \yii\base\InvalidConfigException
     */
    private function getAnswerAfterSaveDataField(DataField $dataField)
    {
        if ($dataField->save()) {
            $data = [
                'result' => 'OK'
            ];
            if (Client::isFullFilled()) {
                $data['allFilled'] = true;
            }

            return $data;
        }

        return [
            'result' => 'ERROR'
        ];
    }

    /**
     * @return array
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionSaveFile()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $dataField = DataField::findOrInit(Yii::$app->request->post('fieldName'));
        if ($dataField->type != QuestionField::TYPE_IMAGE) {
            return [
                'result' => 'ERROR'
            ];
        }
        $imageFile = ImageFile::findOne($dataField->value);
        if (!$imageFile) {
            $imageFile = new ImageFile();
        }

        if ($imageFile->save(true)) {
            $dataField->value = $imageFile->id;

            return $this->getAnswerAfterSaveDataField($dataField);
        }

        return [
            'result' => 'ERROR'
        ];
    }

    /**
     * @param string $field
     *
     * @return array
     * @throws \Exception
     * @throws \Throwable
     */
    private function saveClient($field)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $value = Yii::$app->request->post('value');

        /** @var Client $identity */
        $identity = Yii::$app->getUser()->getIdentity();
        $model = CabinetClient::findOne($identity->getId());
        if (!$model) {
            return ['result' => 'ERROR'];
        }
        $status = $value === 'true' ? CabinetClient::BOOLEAN_YES : CabinetClient::BOOLEAN_NO;
        $model->$field = $status;

        return ['result' => $model->save(true, [
            'goalMinister',
            'goalReserve',
            'readyMunicipal',
            'readyMove',
        ]) ? 'OK' : 'ERROR'];
    }

    /**
     * @return array
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionSaveField()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $fieldName = Yii::$app->request->post();
        /* for checkboxes only */
        if ($name = Yii::$app->request->post('name')) {
            if (preg_match('|([^\]]+)\[([^\]]+)|is', $name, $match)
                && $match[1] === 'Client') {
                return $this->saveClient($match[2]);
            }
            $fieldName = $name;
        }
        $field = DataField::findOrInit($fieldName);
        if ($value = Yii::$app->request->post('value')) {
            $field->value = $value;
        }

        return $this->getAnswerAfterSaveDataField($field);
    }

    /**
     * @param string $name
     *
     * @return array
     * @throws \Exception
     * @throws \app\modules\questionary\exceptions\UnknownClassException
     * @throws \app\modules\questionary\exceptions\UnknownFieldException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAddStudyPlace($name)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $dataField = DataField::findOrInit($name);
        if ($dataField->type != QuestionField::TYPE_STUDYPLACE) {
            return [
                'result' => 'ERROR'
            ];
        }

        return [
            'result' => 'OK',
            'data' => StudyPlaceWidget::widget(['dataField' => $dataField, 'new' => true])
        ];
    }

    /**
     * @param string $name
     *
     * @return array
     * @throws \Exception
     * @throws \app\modules\questionary\exceptions\UnknownClassException
     * @throws \app\modules\questionary\exceptions\UnknownFieldException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAddWorkPlace($name)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $dataField = DataField::findOrInit($name);
        if ($dataField->type != QuestionField::TYPE_WORKPLACE) {
            return [
                'result' => 'ERROR'
            ];
        }

        return [
            'result' => 'OK',
            'data' => WorkPlaceWidget::widget(['dataField' => $dataField, 'new' => true])
        ];
    }

    /**
     * @return Response
     */
    public function actionSendProfile()
    {
        $data = [];
        if (Client::isFullFilled()) {
            $clientId = \Yii::$app->getUser()->getId();
            if ($clientId > 0) {
                $model = Client::find()->where(['clientId' => $clientId])->one();
                $model->status = Client::STATUS_YES;
                if ($model->save()) {
                    $data['message'] = $this->renderPartial('filledMessage');
                    $data['redirect'] = Url::to(['/cabinet/questionary/question']);
                }
            }
        }

        return $this->asJson($data);
    }
}
