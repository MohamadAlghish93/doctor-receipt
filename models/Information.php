<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "information".
 *
 * @property int $id
 * @property string $name_doctor
 * @property string $address1
 * @property string $address2
 * @property string $phone1
 * @property string $phone2
 * @property string $mobile1
 * @property string $mobile2
 * @property string $bio
 * @property string $acceciblate
 * @property string $logo
 */
class Information extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'information';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_doctor', 'address1', 'phone1', 'mobile1', 'bio'], 'required'],
            [['address1', 'address2', 'bio', 'acceciblate'], 'string'],
            [['name_doctor', 'phone1', 'phone2', 'mobile1', 'mobile2'], 'string', 'max' => 250],
            [['logo'], 'file', 'extensions' => 'jpg,png,gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','ID'),
            'name_doctor' => Yii::t('app','NameDoctor'),
            'address1' => Yii::t('app','Address1'),
            'address2' => Yii::t('app','Address2'),
            'phone1' => Yii::t('app','Phone1'),
            'phone2' => Yii::t('app','Phone2'),
            'mobile1' => Yii::t('app','Mobile1'),
            'mobile2' => Yii::t('app','Mobile2'),
            'bio' => Yii::t('app','Bio'),
            'acceciblate' => Yii::t('app','Acceciblate'),
            'logo' => Yii::t('app','Logo'),
        ];
    }
}
