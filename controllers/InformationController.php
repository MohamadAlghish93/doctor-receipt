<?php

namespace app\controllers;

use Yii;
use app\models\Information;
use app\models\InformationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * InformationController implements the CRUD actions for Information model.
 */
class InformationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            "verbs" => [
                "class" => VerbFilter::className(),
                "actions" => [
                    "delete" => ["POST"],
                ],
            ],
        ];
    }

    /**
     * Lists all Information models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InformationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render("index", [
            "searchModel" => $searchModel,
            "dataProvider" => $dataProvider,
        ]);
    }

    /**
     * Displays a single Information model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render("view", [
            "model" => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Information model.
     * If creation is successful, the browser will be redirected to the "view" page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Information();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->logo = UploadedFile::getInstance($model, "logo");
            $imageName = $model->name_doctor.rand(1, 4000) . "." . $model->logo->extension;
            $imagePath = "upload" . $imageName;
            $model->logo->saveAs($imagePath);

            $model->logo = $imagePath;
            $model->save();
            return $this->redirect(["view", "id" => $model->id]);
        }

        return $this->render("create", [
            "model" => $model,
        ]);
    }

    /**
     * Updates an existing Information model.
     * If update is successful, the browser will be redirected to the "view" page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->logo = UploadedFile::getInstance($model, "logo");
            $imageName = date("Y-m-dh:i:s"). "." . $model->logo->extension;
            $imagePath = "upload/" . $imageName;
            $model->logo->saveAs($imagePath);

            $model->logo = $imagePath;
            $model->save();
            return $this->redirect(["view", "id" => $model->id]);
        }

        return $this->render("update", [
            "model" => $model,
        ]);
    }

    /**
     * Deletes an existing Information model.
     * If deletion is successful, the browser will be redirected to the "index" page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(["index"]);
    }

    /**
     * Finds the Information model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Information the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Information::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException("The requested page does not exist.");
    }
}
