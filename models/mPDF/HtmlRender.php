<?php


namespace app\models\mPDF;


use app\models\Information;
use app\models\Medicine;
use app\models\MedicineDetail;

class HtmlRender
{

    public function renderTable($medicines, $modelLink) {

        $table = '<table cellspacing="0" cellpadding="1" border="0">';

        if (!empty($medicines)) {
            foreach ($medicines as $key=>$value){

                $elem = MedicineDetail::findOne($value);
                $item = $elem->getMedicine()->one();

                if (!empty($item)) {

                    $modelLink->link('receiptMedicines', $item);

                    $table .= '<tr>
                    <th width="8%">-' . ($key+1) . '</th>
                    <td width="92%">' . $elem->caliber . '  ' . $item->name_english  . '</td>
                    </tr>' . '<tr>' .
                    '<td width="100%">' . $elem->how_to_use . '</td>' .
                    '</tr>';
                }
            }
        }

        $table .= '</tbody> </table>';

        return $table;
    }

    public function renderInformationHeader($infoObj){

        $table = '';
        if ($infoObj != null) {

            $table = '<table cellspacing="0" cellpadding="1" border="0" dir="rtl">
            <tbody>';

            $table .= '<tr>
            <td width="50%">' . $infoObj->name_doctor  . '</td>
            <td width="20%"></td>
            <td width="50%">' . $infoObj->bio . '</td>
            </tr>';
            $table .= '</tbody> </table>';
        }

        return $table;
    }


    public function renderInformationFooter($infoObj){

        $table = '';
        if ($infoObj != null) {

            $table = '<table cellspacing="0" cellpadding="1" border="0" dir="rtl">
                <tbody>';

            $table .= '<tr>
                <td width="40%">' . $infoObj->acceciblate . '</td>
                <td width="20%"></td>
                <td width="50%">' . $infoObj->address1  . '</td>
                </tr>';
            $table .= '</tbody> </table>';
        }

        return $table;
    }


    public function renderInformationReceipt($number){

        $info = '';
        $info .= '<p> # '. $number.'</p>';
        $info .= '<p>'. 'التاريخ :' . date('d/m/y') .'</p>';

        return $info;
    }

    public function renderInformationPatient($patientName){

        $table = '<table cellspacing="0" cellpadding="1" border="0" dir="rtl">
            <tbody>';

        $table .= '<tr>
            <td width="50%">' . 'الاسم :' . $patientName . '</td>
            <td width="10%"></td>
            <td width="50%">' . 'التاريخ :' . date('d/m/Y') . '</td>
            </tr>';
        $table .= '</tbody> </table>';

        return $table;
    }
}