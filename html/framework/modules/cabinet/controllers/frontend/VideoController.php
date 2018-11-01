<?php

namespace app\modules\cabinet\controllers\frontend;

use app\modules\cabinet\models\ClientVideo;
use krok\system\components\frontend\Controller;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * Class VideoController
 * @package app\modules\cabinet\controllers\frontend
 */
class VideoController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @var string
     */
    public $layout = '//lk';

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new ClientVideo();

        $clientId = Yii::$app->getUser()->getIdentity()->getId();
        $lastVideo = ClientVideo::find()->where(['clientId' => $clientId, 'latest' => ClientVideo::LATEST_YES])->one();

        return $this->render('index', [
            'model' => $model,
            'lastVideo' => $lastVideo,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionSaveRecordVideo()
    {
        $post = Yii::$app->request->post();
        if (!isset($post['audio-filename']) && !isset($post['video-filename'])) {
            return $this->asJson(['error' => 'Empty file name']);
        }
        // do NOT allow empty file names
        if (empty($post['audio-filename']) && empty($post['video-filename'])) {
            return $this->asJson(['error' => 'Empty file name']);
        }

        $fileName = '';
        $tempName = '';
        $file_idx = '';

        if (!empty($_FILES['audio-blob'])) {
            $file_idx = 'audio-blob';
            $fileName = $post['audio-filename'];
            $tempName = $_FILES[$file_idx]['tmp_name'];
        } else {
            $file_idx = 'video-blob';
            $fileName = $post['video-filename'];
            $tempName = $_FILES[$file_idx]['tmp_name'];
        }

        if (empty($fileName) || empty($tempName)) {
            if(empty($tempName)) {
                return $this->asJson(['error' => 'Invalid temp_name: '.$tempName]);
            }
            return $this->asJson(['error' => 'Invalid temp_name: '.$tempName]);
        }


        if (!is_dir(Yii::getAlias('@video/record'))) {
            mkdir(Yii::getAlias('@video/record'));
        }
        $filePath = Yii::getAlias('@video/record/' . $fileName);

        // make sure that one can upload only allowed audio/video files
        $allowed = array(
            'webm',
            'wav',
            'mp4',
            "mkv",
            'mp3',
            'ogg'
        );
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
            return $this->asJson(['error' => 'Invalid file extension: '.$extension]);
        }

        if (!move_uploaded_file($tempName, $filePath)) {
            return $this->asJson(['error' => 'Problem saving file: '.$tempName]);
        }

        $clientId = Yii::$app->getUser()->getIdentity()->getId();

        if($post['latest'] == ClientVideo::LATEST_YES) {
            $exists = ClientVideo::find()->where(['clientId' => $clientId, 'latest' => $post['latest']])->one();
            if($exists !== null) {
                $exists->latest = ClientVideo::LATEST_NO;
                $exists->save();
            }
        }

        $model = new ClientVideo([
            'clientId' => $clientId,
            'src' => ClientVideo::SAVE_PATH . '/record/' . $fileName,
            'latest' => $post['latest'],
        ]);
        $model->detachBehavior('CreatedByBehavior');
        if($model->save()) {
            return $this->asJson(['success' => true, 'id' => $model->id]);
        }
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeletePreviousVideo()
    {
        $post = Yii::$app->request->post();
        $query = ClientVideo::find()->where(['id' => $post['previousVideoId']])->one();

        if(file_exists(Yii::getAlias('@video/record/' . $post['previousVideoName'])) && $query !== null) {
            if (!unlink(Yii::getAlias('@video/record/' . $post['previousVideoName']))) {
                return $this->asJson(['error' => 'Problem deleting file.']);
            } else {
                $query->delete();
                return $this->asJson(['success' => true]);
            }
        } else {
            return $this->asJson(['error' => 'File not found']);
        }
    }

    /**
     * @return string
     */
    public function actionUploadFile()
    {
        $model = new ClientVideo();

        $videoFile = UploadedFile::getInstance($model, 'src');

        $directory = Yii::getAlias('@video/upload/');
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        if ($videoFile) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $videoFile->extension;
            $filePath = $directory . $fileName;
            if ($videoFile->saveAs($filePath)) {
                $path = '/uploads/video/upload/' . $fileName;

                $clientId = Yii::$app->getUser()->getIdentity()->getId();

                $exists = ClientVideo::find()->where(['clientId' => $clientId, 'latest' => ClientVideo::LATEST_YES])->one();
                if($exists !== null) {
                    $exists->latest = ClientVideo::LATEST_NO;
                    $exists->save();
                }

                $model = new ClientVideo([
                    'clientId' => $clientId,
                    'src' => ClientVideo::SAVE_PATH . '/upload/' . $fileName,
                    'latest' => ClientVideo::LATEST_YES,
                ]);
                $model->detachBehavior('CreatedByBehavior');

                if($model->save()) {
                    return Json::encode([
                        'files' => [
                            [
                                'name' => $fileName,
                                'filename' => $uid . '.' . $videoFile->extension,
                                'size' => $videoFile->size,
                                'url' => $path,
                                'thumbnailUrl' => $path,
                                'deleteUrl' => 'image-delete?name=' . $fileName,
                                'deleteType' => 'POST',
                            ],
                        ],
                    ]);
                }
            }
        }
        return '';
    }
}
