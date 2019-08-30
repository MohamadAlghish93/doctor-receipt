<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medicine_detail".
 *
 * @property int $id
 * @property int $medicine_id
 * @property string $caliber
 * @property string $how_to_use
 *
 * @property Medicine $medicine
 */
class MedicineDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medicine_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['medicine_id'], 'integer'],
            [['how_to_use'], 'string'],
            [['caliber'], 'string', 'max' => 250],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicine::className(), 'targetAttribute' => ['medicine_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'medicine_id' => 'Medicine ID',
            'caliber' => Yii::t('app','Caliber') ,
            'how_to_use' => Yii::t('app','HowToUse'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicine()
    {
        return $this->hasOne(Medicine::className(), ['id' => 'medicine_id']);
    }
}
