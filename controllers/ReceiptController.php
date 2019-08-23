<?php

namespace app\controllers;

use app\models\Information;
use app\models\Medicine;
use Yii;
use app\models\Receipt;
use app\models\ReceiptSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\mPDF\mpdfCls;
use app\models\mPDF\HtmlRender;
use app\models\TCPDF\PdfCls;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Receipt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Receipt();

        if ($model->load(Yii::$app->request->post())) {

            $infoObj = Information::findOne(1);
            $date = date_create($model->date);
            $model->date = date_format($date,"Y/m/d H:i:s");
            $model->save();

            $image = $infoObj->logo;
            $medicineVar = Yii::$app->request->post('receiptMedicines');

            $htmlObj = new HtmlRender();
            $table = $htmlObj->renderTable($medicineVar, $model);
            $info = $htmlObj->renderInformation($infoObj);
            $infoPatient = $htmlObj->renderInformationPatient($model->patient_name);
            $infoReceipt = $htmlObj->renderInformationReceipt($model->id);

            $pdf = new PdfCls();
            $data['patient_name'] = $model->patient_name;
            $pathPDF = $pdf->actionReport($table, $info, $infoPatient, $infoReceipt, $image, $data);

            $model->file_path = $pathPDF;
            $model->save();

            return Yii::$app->response->sendFile($pathPDF, 'temp.pdf', ['inline'=>false]);
        }

        $model->date = date('d-m-Y');
        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionPdf($id) {

        $model = Receipt::findOne($id);

        return Yii::$app->response->sendFile($model->file_path, $model->patient_name . '.pdf');
    }

    /**
     * Updates an existing Receipt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Receipt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionMedicineList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [
            'id' => '',
            'text' => '',
            'caliber' => '',
            'how' => '',
        ]
        ];

        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name_english AS text, caliber, how_to_use AS how')
                ->from('medicine')
                ->where(['like', 'name_english', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = [
                'id' => $id,
                'text' => Medicine::find($id)->name_english,
                'caliber' => Medicine::find($id)->caliber,
                'how' => Medicine::find($id)->how_to_use,
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

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
