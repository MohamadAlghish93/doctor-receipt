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
            [['address1', 'address2', 'bio'], 'string'],
            [['name_doctor', 'phone1', 'phone2', 'mobile1', 'mobile2'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_doctor' => 'Name Doctor',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'phone1' => 'Phone1',
            'phone2' => 'Phone2',
            'mobile1' => 'Mobile1',
            'mobile2' => 'Mobile2',
            'bio' => 'Bio',
        ];
    }
}
