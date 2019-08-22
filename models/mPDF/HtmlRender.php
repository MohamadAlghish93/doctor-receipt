<?php


namespace app\models\mPDF;


use app\models\Information;
use app\models\Medicine;

class HtmlRender
{

    public function renderTable($medicines) {

        $table = '<table cellspacing="0" cellpadding="1" border="1">
        <thead> 
        <tr > 
        <th width="24%">الاستخدام</th>
        <th width="6%">النوع</th>
        <th width="6%">العيار</th> 
        <th width="20%">الاسم العربي</th>
        <th width="40%">الاسم</th>
        <th width="4%">#</th> 
 
        </tr> </thead>         
        <tbody>';

        foreach ($medicines as $key=>$value){

            if (($item = Medicine::findOne($value)) !== null) {

                $table .= '<tr>
                <td width="24%">' . $item->how_to_use . '</td> 
                <td width="6%">' . $item->type . '</td>
                <td width="6%">' . $item->caliber . '</td> 
                <td width="20%">' . $item->name_arabic . '</td>
                <td width="40%">' . $item->name_english . '</td>
                <th width="4%">' . ($key+1) . '</th> 
                </tr>';
            }
        }


        $table .= '</tbody> </table>';

        return $table;
    }

    public function renderInformation($infoObj){

        $info = '';
        if ($infoObj != null) {

            $info .= '<p>'. 'الطبيب :' . $infoObj->name_doctor . '</p>';
            $info .= '<p>'. 'العنوان :' . $infoObj->address1 .'</p>';
            $info .= '<p>'. 'الموبايل :' . $infoObj->mobile1 .'</p>';
        }

        return $info;
    }

    public function renderInformationReceipt($number){

        $info = '';
        $info .= '<p> # '. $number.'</p>';
        $info .= '<p>'. 'التاريخ :' . date('d/m/y') .'</p>';

        return $info;
    }

    public function renderInformationPatient($patientName){

        $info = '<p>' . 'اسم المريض :' . $patientName . ' ';
        $info .= '&nbsp;&nbsp;' . 'الحالة :' . '__________'  . ' ';
        $info .= '&nbsp;&nbsp;' . 'ملاحظة :'. '__________'  . '</p>';

        return $info;
    }
}