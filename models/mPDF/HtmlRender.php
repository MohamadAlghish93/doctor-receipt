<?php


namespace app\models\mPDF;


use app\models\Information;
use app\models\Medicine;
use app\models\MedicineDetail;

class HtmlRender
{

    public function renderTable($medicines, $modelLink) {

        $table = '<table cellspacing="0" cellpadding="1" border="0" style="float: left">';

        if (!empty($medicines)) {
            foreach ($medicines as $key=>$value){

                $elem = MedicineDetail::findOne($value);
                $item = $elem->getMedicine()->one();

                if (!empty($item)) {

                    $modelLink->link('receiptMedicines', $item);

                    $table .= '<tr>
                    <th width="8%">' . $this->integerToRoman($key+1) . ')</th>
                    <td width="92%">' . $item->name_english . '  '  . $elem->caliber   . '</td>
                    </tr>' . '<tr style="float: right;">' .
                    '<td width="100%" style="text-align:right">' . $elem->how_to_use . '</td>' .
                    '</tr>' .
                    '<tr><td></td></tr>';
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

    public function renderInformationPatient($patientName){

        $table = '<table cellspacing="0" cellpadding="1" border="0" dir="rtl">
            <tbody>';

        $table .= '<tr>
            <td width="50%">' . '' . $patientName . '</td>
            <td width="10%"></td>
            <td width="50%">' . '' . date('d/m/Y') . '</td>
            </tr>';
        $table .= '</tbody> </table>';

        return $table;
    }

    public function integerToRoman($integer) {

        $integer = intval($integer);
        $result = '';

        $lookup = array('M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1);

        foreach($lookup as $roman => $value){
            // Determine the number of matches
            $matches = intval($integer/$value);

            // Add the same number of characters to the string
            $result .= str_repeat($roman,$matches);

            // Set the integer to be the remainder of the integer and the value
            $integer = $integer % $value;
        }

        // The Roman numeral should be built, return it
        return $result;

    }
}