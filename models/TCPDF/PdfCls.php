<?php

namespace app\models\TCPDF;

require_once ('tcpdf.php');


class PdfCls
{

    var $pdf;
    var $template_id;


    public function actionReport($tbl, $info, $patientInfo, $infoReceipt, $image) {

        $this->pdf = new \TCPDF('p', 'mm', 'A4', true, 'UTF-8', false);
        $this->pdf ->SetCreator(PDF_CREATOR);
        $this->pdf ->SetAuthor('no name');
        $this->pdf->SetTitle('وصفة طبية');
        $this->pdf->setPrintHeader(false);

        //
        // start a new XObject Template and set transparency group option
        // set margins
        $this->pdf->AddPage();
        $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


        $this->addTemplate($image);

        $this->pdf->SetAlpha(0.2);
        $this->pdf->printTemplate($this->template_id, 15, 50, 20, 20, '', '', false);
        $this->pdf->printTemplate($this->template_id, 27, 62, 40, 40, '', '', false);
        $this->pdf->printTemplate($this->template_id, 55, 85, 60, 60, '', '', false);

        $this->pdf->SetAlpha(1);

        $this->pdf->SetFont('aealarabiya');
        $this->pdf->writeHTML($infoReceipt, true, false, false, false, '');
        $this->addBreakLine();
        $this->pdf->writeHTML($info, true, false, false, false, 'R');
        $this->addBreakLine();
        $this->pdf->writeHTML($patientInfo, true, false, false, false, 'R');
        $this->addBreakLine();
        $this->pdf->writeHTML($tbl, true, false, false, false, 'R');

        $this->addBreakLine();
        $this->pdf->writeHTML('<hr>', true, false, true, false, '');
//
        $this->pdf->SetTitle($this->getName(10));
        return $this->pdf->Output();
    }

    public function addBreakLine() {
        $this->pdf->Cell(0,0,'',0,1);
    }

    public function addTemplate($image) {
        $this->template_id = $this->pdf->startTemplate(60, 60, true);
        $this->pdf->StartTransform();
        $this->pdf->Image($image, 0, 0, 60, 60, '', '', '', true, 72, '', false, false, 0, false, false, false);
        $this->pdf->StopTransform();
        $this->pdf->SetXY(0, 0);
        $this->pdf->endTemplate();
    }

    function getName($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

}