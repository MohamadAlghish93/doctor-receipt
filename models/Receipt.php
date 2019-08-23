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
            'id' => Yii::t('app','ID') ,
            'date' => Yii::t('app','Date'),
            'patient_name' => Yii::t('app','PatientName'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiptMedicines()
    {
        return $this->hasMany(Medicine::className(), ['id' => 'medicine_id'])
            ->viaTable('receipt_medicine', ['receipt_id' => 'id']);

//        return $this->hasMany(ReceiptMedicine::className(), ['receipt_id' => 'id']);
    }
}
