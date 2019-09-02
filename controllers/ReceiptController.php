<?php

namespace app\controllers;

use app\models\Information;
use app\models\Medicine;
use app\models\MedicineDetail;
use app\models\Model;
use app\models\ReceiptMedicine;
use Yii;
use app\models\Receipt;
use app\models\ReceiptSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\mPDF\HtmlRender;
use app\models\TCPDF\PdfCls;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * ReceiptController implements the CRUD actions for Receipt model.
 */
class ReceiptController extends Controller
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
     * Lists all Receipt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReceiptSearch();
        $query = Yii::$app->request->queryParams;

        $dataProvider = $searchModel->search($query);

        return $this->render("index", [
            "searchModel" => $searchModel,
            "dataProvider" => $dataProvider,
        ]);
    }

    /**
     * Displays a single Receipt model.
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
     * Creates a new Receipt model.
     * If creation is successful, the browser will be redirected to the "view" page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Receipt();
        $modelDetail = [new MedicineDetail()];

        if ($model->load(Yii::$app->request->post())) {

            $infoObj = Information::findOne(1);
            $date = date_create($model->date);
            $model->date = date_format($date,"Y/m/d H:i:s");
            $model->save();

            if (!empty($infoObj)) {

                $image = $infoObj->logo;
                $medicineVar = Yii::$app->request->post("receiptMedicines");
                $medicineDetailArr = array();

                $htmlObj = new HtmlRender();


                $modelDetail = Model::createMultiple(MedicineDetail::classname());
                Model::loadMultiple($modelDetail, Yii::$app->request->post());

                $transaction = \Yii::$app->db->beginTransaction();
                $flag = false;

                if (!empty($medicineVar)) {
                    foreach ($medicineVar as $key => $value) {

                        $elem = Medicine::findOne($value);

                        // ajax validation
                        if (Yii::$app->request->isAjax) {
                            Yii::$app->response->format = Response::FORMAT_JSON;
                            return ArrayHelper::merge(
                                ActiveForm::validateMultiple($modelDetail),
                                ActiveForm::validate($elem)
                            );
                        }

                        $valid = Model::validateMultiple($modelDetail) ;

                        if ($valid) {

                            try {
                                $iter = $modelDetail[$key];

                                $iter->medicine_id = $elem->id;
                                if (! ($flag = $iter->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }

                                array_push($medicineDetailArr, $iter->id);

                            } catch (Exception $e) {
                                $transaction->rollBack();
                            }
                        }
                    }
                }

                if ($flag) {
                    $transaction->commit();
                }

                $table = $htmlObj->renderTable($medicineDetailArr, $model);

                $infoHeader = $htmlObj->renderInformationHeader($infoObj);
                $infoFooterTbl = $htmlObj->renderInformationFooter($infoObj);
                $infoPatient = $htmlObj->renderInformationPatient($model->patient_name);
                $infoReceipt = $htmlObj->renderInformationReceipt($model->id);

                $pdf = new PdfCls();
                $data["patient_name"] = $model->patient_name;

                $infoFooter['table'] = $infoFooterTbl;
                $infoFooter['numberReceipt'] = $model->id;

                return $pdf->actionReport($table, $infoHeader, $infoFooter, $infoPatient, $infoReceipt, $image, $data);

            }
        }

        $model->date = date("d-m-Y");
        return $this->render("create", [
            "model" => $model,
            'modelDetail' => (empty($modelDetail)) ? [new MedicineDetail()] : $modelDetail
        ]);
    }

    public function actionPdf($id) {

        $model = Receipt::findOne($id);

        return Yii::$app->response->sendFile($model->file_path, $model->patient_name . ".pdf");
    }

    /**
     * Updates an existing Receipt model.
     * If update is successful, the browser will be redirected to the "view" page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(["view", "id" => $model->id]);
        }

        return $this->render("update", [
            "model" => $model,
        ]);
    }

    /**
     * Deletes an existing Receipt model.
     * If deletion is successful, the browser will be redirected to the "index" page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $relations = ReceiptMedicine::findAll(
            array("receipt_id" =>  $id)
        );
        foreach ($relations as $value) {
            $value->delete();
        }
        $model->delete();
        return $this->redirect(["index"]);
    }


    public function actionMedicineList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ["results" => [
            "id" => "",
            "text" => "",
            "caliber" => "",
            "how" => "",
        ]
        ];

        if (!is_null($q)) {
            $query = new Query;
            $query->select("medicine.id, medicine.name_english AS text ")
                ->from("medicine")
                ->where(["like", "medicine.name_english", $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out["results"] = array_values($data);
        }
        elseif ($id > 0) {
            $out["results"] = [
                "id" => $id,
                "text" => Medicine::find($id)->name_english,
                "caliber" => Medicine::find($id)->caliber,
                "how" => Medicine::find($id)->how_to_use,
            ];
        }
        return $out;
    }

    /**
     * Finds the Receipt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Receipt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Receipt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException("The requested page does not exist.");
    }
}
