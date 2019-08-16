<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medicine".
 *
 * @property int $id
 * @property string $name_arabic
 * @property string $name_english
 * @property string $caliber
 * @property string $type
 *
 * @property ReceiptMedicine[] $receiptMedicines
 */
class Medicine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medicine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_arabic', 'name_english'], 'string', 'max' => 500],
            [['caliber', 'type'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_arabic' => 'Name Arabic',
            'name_english' => 'Name English',
            'caliber' => 'Caliber',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiptMedicines()
    {
        return $this->hasMany(ReceiptMedicine::className(), ['medicine_id' => 'id']);
    }
}
