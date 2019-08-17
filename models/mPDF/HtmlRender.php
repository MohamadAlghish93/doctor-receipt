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
        <th width="4%">#</th> 
        <th width="40%">Name English</th>
        <th width="40%">Name Arabic</th>
        <th width="8%">Caliber</th> 
        <th width="8%">Type</th> 
        </tr> </thead>         
        <tbody>';

        foreach ($medicines as $key=>$value){

            if (($item = Medicine::findOne($value)) !== null) {

                $table .= '<tr> 
                <th width="4%">' . ($key+1) . '</th> 
                <td width="40%">' . $item->name_english . '</td>
                <td width="40%">' . $item->name_arabic . '</td>
                <td width="8%">' . $item->caliber . '</td> 
                <td width="8%">' . $item->type . '</td> 
                </tr>';
            }
        }


        $table .= '</tbody> </table>';

        return $table;
    }

    public function renderInformation(){

        $infoObj = Information::findOne(1);
        $info = '';

        if ($infoObj != null) {

            $info .= '<p>'. $infoObj->name_doctor .'</p>';
            $info .= '<p>' . $infoObj->address1 .'</p>';
            $info .= '<p>' . $infoObj->mobile1 .'</p>';
        }

        return $info;
    }

    public function renderInformationReceipt($number){

        $info = '';
        $info .= '<p> # '. $number.'</p>';
        $info .= '<p> Date ' . date('d/m/y') .'</p>';

        return $info;
    }

    public function renderInformationPatient($patientName){

        $info = '<p> Name of patient :' . $patientName . '</p>';
        return $info;
    }
}