<?php

namespace app\models\TCPDF;

use Yii;

require_once ("tcpdf.php");

class MYPDF extends \TCPDF {

    var $infoH;
    var $infoF;

    //Page header
    public function Header() {

        $this->SetFont('arial', '', 8);

        $this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $this->infoH, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);

    }

    // Page footer
    public function Footer() {
        // Position at 30 mm from bottom
        $this->SetY(-35);
        // Set font
        $this->SetFont('arial', '', 8);
        // Page number
        $this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $this->infoF['table'], $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);


    }
}

class PdfCls
{
    var $pdf;
    var $template_id;

    public function actionReport($tbl, $infoHeader, $infoFooter, $patientInfo, $data, $sizePrint) {

        $this->pdf = new MYPDF("p", "mm", $sizePrint, true, "UTF-8", false);
        $this->pdf->SetFont("arial",'', 8);
        $this->pdf->setRTL(true);
        $this->pdf->infoH = $infoHeader;
        $this->pdf->infoF = $infoFooter;

        $this->pdf ->SetCreator(PDF_CREATOR);
        $this->pdf ->SetAuthor("no name");
        $this->pdf->SetTitle("وصفة طبية");

        $this->addConfig();

        // start a new XObject Template and set transparency group option
        // set margins
        $this->pdf->AddPage();

        $this->pdf->SetAlpha(1);

        $this->pdf->writeHTML($patientInfo, true, false, false, false, "R");

        $this->pdf->setRTL(false);
        $this->pdf->Cell(0, 0, 'Rx)', 0, 1, 'L', 0, '', 0);
        $this->pdf->writeHTML($tbl, true, false, false, false, "L");

        $this->addBreakLine();


        $this->pdf->SetTitle($data["patient_name"]);

        return $this->pdf;
    }

    public function addConfig() {

        // set margins
//        $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
//        $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//        $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    }

    public function addBreakLine() {
        $this->pdf->Cell(0,0,"",0,1);
    }

    public function addTemplate($image) {

        $this->template_id = $this->pdf->startTemplate(60, 60, true);
        $this->pdf->StartTransform();
        $this->pdf->Image($image, 0, 0, 60, 60, "", "", "", true, 72, "", false, false, 0, false, false, false);
        $this->pdf->StopTransform();
        $this->pdf->SetXY(0, 0);
        $this->pdf->endTemplate();
    }

    function getName($n) {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $randomString = "";

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

}