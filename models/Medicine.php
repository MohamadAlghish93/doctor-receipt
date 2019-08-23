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
 * @property string $how_to_use
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
            [['how_to_use'], 'string'],
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
            'id' => Yii::t('app','ID') ,
            'name_arabic' => Yii::t('app','NameArabic') ,
            'name_english' => Yii::t('app','NameEnglish') ,
            'caliber' => Yii::t('app','Caliber') ,
            'type' => Yii::t('app','Type') ,
            'how_to_use' => Yii::t('app','HowToUse'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiptMedicines()
    {
        return $this->hasMany(Receipt::className(), ['id' => 'receipt_id'])
            ->viaTable('receipt_medicine', ['medicine_id' => 'id']);

//        return $this->hasMany(ReceiptMedicine::className(), ['medicine_id' => 'id']);
    }
}
