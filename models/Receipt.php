<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "receipt".
 *
 * @property int $id
 * @property string $date
 * @property string $patient_name
 *
 * @property ReceiptMedicine[] $receiptMedicines
 */
class Receipt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receipt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'patient_name'], 'required'],
            [['date'], 'safe'],
            [['patient_name'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'patient_name' => 'Patient Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiptMedicines()
    {
        return $this->hasMany(ReceiptMedicine::className(), ['receipt_id' => 'id']);
    }
}
