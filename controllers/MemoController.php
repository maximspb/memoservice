<?php

namespace app\controllers;

use app\models\MemoRecipient;
use app\models\Recipient;
use Yii;
use app\models\Memo;
use yii\data\ActiveDataProvider;
use app\models\search\MemoSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MemoController implements the CRUD actions for Memo model.
 */
class MemoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [

                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Memo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Yii::$app->user;
        $searchModel = new MemoSearch();
        $user->can('manageUsers') ?
            $dataProvider = new ActiveDataProvider([
                'query' => Memo::find(),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]) :
        $dataProvider = new ActiveDataProvider([
            'query' => Memo::find()->where(['user_id' => $user->id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Memo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);

    }

    /**
     * Creates a new Memo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Memo();
        $recipients = Recipient::find()->all();
        $names = ArrayHelper::map($recipients, 'id', 'name', 'job');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model, 'recipients' => $names
        ]);
    }

    /**
     * Updates an existing Memo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        MemoRecipient::deleteAll(['memo_id' => $model->id]);
        $recipients = Recipient::find()->all();
        $names = ArrayHelper::map($recipients, 'id', 'name', 'job');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model, 'recipients' => $names,
        ]);
    }

    /**
     * Deletes an existing Memo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            $model->delete();
            return $this->redirect(['/memo']);
        } catch (NotFoundHttpException | \Throwable $exception) {
            return $this->redirect(['/memo']);
        }
    }

    /**
     * Finds the Memo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Memo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Memo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена');
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * возвращает макет для pdf
     */
    protected function getPdfContent($id)
    {
        try {
            $model = $this->findModel($id);
        } catch (NotFoundHttpException $exception) {
            return $this->redirect(['/memo']);
        }
        return $this->renderPartial('memotemplate', ['model' => $model]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * отправка письма адресатам служебной записки
     */
    public function actionSendmemo($id)
    {
        $content = $this->getPdfContent($id);
        try {
            $model = $this->findModel($id);
        } catch (NotFoundHttpException $exception) {
            return $this->redirect(['/memo']);
        }
        try {
            if(!empty($model->recipients)){
                $model->makePdf($content);
                $model->sendMail();
                Yii::$app->session->setFlash('success', 'Служебка отправлена');
                $this->redirect('/memo/view?id='.$model->id);
            } else {
                Yii::$app->session->setFlash('error', 'Не указаны адресаты. Отредактируйте служебку');
                $this->redirect('/memo/view?id='.$model->id);
            }
        } catch (\Throwable $exception) {
            Yii::$app->session->setFlash('error', 'Ошибка отправки. Попробуйте снова');
            $this->redirect('/memo/view?id='.$model->id);
        }
    }

    public function actionTest($id)
    {
        try {
            $model = $this->findModel($id);
        } catch (NotFoundHttpException $exception) {
            return $this->redirect(['/memo']);
        }
        return $this->renderPartial('testtemplate', ['model' => $model]);
    }
}
