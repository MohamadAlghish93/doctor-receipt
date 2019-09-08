<?php

namespace app\models\TCPDF;

use Yii;

require_once ("tcpdf.php");

class MYPDF extends \TCPDF {

    var $infoH;
    var $infoF;

    //Page header
    public function Header() {

        $this->SetFont('aealarabiya', 'B', 10);

        $this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $this->infoH, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);

        // image of logo
//        $image_file = K_PATH_IMAGES.'logo.jpg';
//        $this->Image($image_file, 70, 5, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    }

    // Page footer
    public function Footer() {
        // Position at 30 mm from bottom
        $this->SetY(-25);
        // Set font
        $this->SetFont('aealarabiya', 'I', 8);
        // Page number
        $this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $this->infoF['table'], $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);

        $this->SetFont('aefurat', '', 12);
        $format = "رقم %s أ/ر/14   وصفة طبية";
        $htmlFooter = sprintf($format, $this->infoF['numberReceipt']);
//        $this->Cell(0, 0, $htmlFooter, 1, 1, 'C', 0, '', 3);

        $this->SetFont('aealarabiya', 'I', 8);
        $this->Cell(0, 10, $this->getAliasNumPage(), 0, 1, 'C', 0, '', 0, false, 'T', 'M');
    }
}

class PdfCls
{
    var $pdf;
    var $template_id;

    public function actionReport($tbl, $infoHeader, $infoFooter, $patientInfo, $infoReceipt, $image, $data) {

        $this->pdf = new MYPDF("p", "mm", "A6", true, "UTF-8", false);
        $this->pdf->SetFont("aealarabiya");
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

        if ($image != "") {

            $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


            $this->addTemplate($image);

            $this->pdf->SetAlpha(0.2);
            $this->pdf->printTemplate($this->template_id, 15, 50, 20, 20, "", "", false);
            $this->pdf->printTemplate($this->template_id, 27, 62, 40, 40, "", "", false);
            $this->pdf->printTemplate($this->template_id, 55, 85, 60, 60, "", "", false);
        }

        $this->pdf->SetAlpha(1);


        $this->pdf->writeHTML($infoReceipt, true, false, false, false, "");
        $this->addBreakLine();
        $this->pdf->writeHTML($patientInfo, true, false, false, false, "R");
        $this->addBreakLine();
        $this->pdf->writeHTML($tbl, true, false, false, false, "R");

        $this->addBreakLine();
        $note = '<p>' . 'ملاحظة :'. '__________'  . '</p>';
        $this->pdf->writeHTML($note, true, false, true, false, "");
        $this->pdf->writeHTML("<hr>", true, false, true, false, "");
//
        $this->pdf->SetTitle($data["patient_name"]);

        return $this->pdf;
//        $path = realpath(dirname(__FILE__)."/../../");
//
//        $nameDate = date("Y-m-dh:i:s");
//        $path = $path . "/web/upload/pdf/" . $data["patient_name"] . $nameDate . ".pdf";
//        $this->pdf->Output($path, "F");
//        return $path;
    }

    public function addConfig() {

        // set margins
//        $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
        $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
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