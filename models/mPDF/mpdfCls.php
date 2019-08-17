<?php

namespace app\models\mPDF;

use kartik\mpdf\Pdf;

class mpdfCls
{

    public function actionReport($content) {

//        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Doctor'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>[date("r")],
                'SetFooter'=>['|Page {PAGENO}|'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

}