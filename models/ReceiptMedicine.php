<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "receipt_medicine".
 *
 * @property int $id
 * @property int $receipt_id
 * @property int $medicine_id
 *
 * @property Medicine $medicine
 * @property Receipt $receipt
 */
class ReceiptMedicine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receipt_medicine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receipt_id', 'medicine_id'], 'required'],
            [['receipt_id', 'medicine_id'], 'integer'],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicine::className(), 'targetAttribute' => ['medicine_id' => 'id']],
            [['receipt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Receipt::className(), 'targetAttribute' => ['receipt_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'receipt_id' => 'Receipt ID',
            'medicine_id' => 'Medicine ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicine()
    {
        return $this->hasOne(Medicine::className(), ['id' => 'medicine_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipt()
    {
        return $this->hasOne(Receipt::className(), ['id' => 'receipt_id']);
    }
}
