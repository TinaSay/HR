<?php

namespace app\modules\cabinet\controllers\backend;

use Yii;
use app\modules\cabinet\models\ClientVideo;
use app\modules\cabinet\models\search\ClientVideoSearch;
use krok\system\components\backend\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientVideoController implements the CRUD actions for ClientVideo model.
 */
class ClientVideoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ClientVideo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientVideoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientVideo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing ClientVideo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if(file_exists(Yii::getAlias('@root' . $model->src))) {
            unlink(Yii::getAlias('@root' . $model->src));
            Yii::$app->session->setFlash('sucess', 'Файл успешно удален. Запись удалена.');
        } else {
            Yii::$app->session->setFlash('error', 'Файл не найден. Запись удалена.');
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the ClientVideo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientVideo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientVideo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
