<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Medicine;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Receipt */
/* @var $medicine app\models\Medicine */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receipt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->widget(DatePicker::className(), [
        'name' => 'date',
        'value' => date('dd-mm-yyyy', strtotime('+2 days')),
        'options' => ['placeholder' => 'Select date ...'],
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]
    ]) ?>

    <?= $form->field($model, 'patient_name')->textInput(['maxlength' => true]) ?>

    <?= Select2::widget([
        'name' => 'receiptMedicines',
        'value' => '',
        'language' => 'en',
        'data' => ArrayHelper::map(Medicine::find()->all(), 'id' , 'name_english' ),
        'options' => ['multiple' => true, 'placeholder' => Yii::t('app','SelectMedicines')],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]);
    ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
