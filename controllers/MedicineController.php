<?php

namespace app\controllers;

use app\models\MedicineDetail;
use Yii;
use app\models\Medicine;
use app\models\MedicineSearch;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MedicineController implements the CRUD actions for Medicine model.
 */
class MedicineController extends Controller
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
     * Lists all Medicine models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MedicineSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render("index", [
            "searchModel" => $searchModel,
            "dataProvider" => $dataProvider,
        ]);
    }

    /**
     * Displays a single Medicine model.
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
     * Creates a new Medicine model.
     * If creation is successful, the browser will be redirected to the "view" page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Medicine();
        $modelDetail = [new MedicineDetail()];

        if ($model->load(Yii::$app->request->post()) ) {

            $modelDetail = Model::createMultiple(MedicineDetail::classname());
            Model::loadMultiple($modelDetail, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelDetail),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();

            $valid = Model::validateMultiple($modelDetail) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        foreach ($modelDetail as $iter) {
                            $iter->medicine_id = $model->id;
                            if (! ($flag = $iter->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

        }

        return $this->render("create", [
            "model" => $model,
            'modelDetail' => (empty($modelDetail)) ? [new MedicineDetail()] : $modelDetail,
        ]);
    }

    /**
     * Updates an existing Medicine model.
     * If update is successful, the browser will be redirected to the "view" page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelDetail = $model->getMedicineDetails()->all();

        if ($model->load(Yii::$app->request->post())) {

            $modelDetail = Model::createMultiple(MedicineDetail::classname());
            Model::loadMultiple($modelDetail, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelDetail),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();

            $valid = Model::validateMultiple($modelDetail) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        foreach ($modelDetail as $iter) {
                            $iter->medicine_id = $model->id;
                            if (! ($flag = $iter->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

        }

        return $this->render("update", [
            "model" => $model,
            'modelDetail' => (empty($modelDetail)) ? [new MedicineDetail()] : $modelDetail,
        ]);
    }

    /**
     * Deletes an existing Medicine model.
     * If deletion is successful, the browser will be redirected to the "index" page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model =  $this->findModel($id);

        $relations = MedicineDetail::findAll(
            array("medicine_id" =>  $id)
        );
        foreach ($relations as $value) {
            $value->delete();
        }

        $model->delete();

        return $this->redirect(["index"]);
    }




    /**
     * Finds the Medicine model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Medicine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Medicine::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException("The requested page does not exist.");
    }


}
