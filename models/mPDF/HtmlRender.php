<?php


namespace app\models\mPDF;


use app\models\Information;
use app\models\Medicine;

class HtmlRender
{

    public function renderTable($medicines, $modelLink) {

        $table = '<table cellspacing="0" cellpadding="1" border="1">
        <thead> 
        <tr >
        <th width="4%">#</th>
        <th width="50%">الاسم</th>
        <th width="12%">العيار</th> 
        <th width="34%">الاستخدام</th>
        </tr> </thead>         
        <tbody>';

        foreach ($medicines as $key=>$value){

            if (($item = Medicine::findOne($value)) !== null) {

                $modelLink->link('receiptMedicines', $item);

                $table .= '<tr>
                <th width="4%">' . ($key+1) . '</th>
                <td width="50%">' . $item->name_english . '</td>
                <td width="12%">' . $item->caliber . '</td> 
                <td width="34%">' . $item->how_to_use . '</td> 
                </tr>';
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
                <td width="10%"></td>
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

        $info = '<p>' . 'اسم المريض :' . $patientName . ' ';
        $info .= '&nbsp;&nbsp;' . 'الحالة :' . '__________'  . '</p>';

        return $info;
    }
}