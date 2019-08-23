<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Medicine;
use kartik\select2\Select2;
use kartik\date\DatePicker;

use yii\web\JsExpression;

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

    <br>

    <?php
    $formatJs = <<< 'JS'
    var formatRepo = function (item) {
        if (item.loading) {
            return item.text;
        }
        var markup =
    '<div class="row">' + 
        '<div class="col-sm-5">' +
            '<b style="margin-left:5px">' + item.text + '</b>' + 
        '</div>' +
        '<div class="col-sm-3"><i class="fa fa-code-fork"></i> ' + item.caliber + '</div>' +
        '<div class="col-sm-3"><i class="fa fa-star"></i> ' + item.how + '</div>' +
    '</div>';
        if (item.description) {
          markup += '<p>' + item.description + '</p>';
        }
        return '<div style="overflow:hidden;">' + markup + '</div>';
    };
    var formatRepoSelection = function (repo) {
        return repo.text + ' ' + tem.caliber;
    }
JS;

    $this->registerJs($formatJs);

    $url = \yii\helpers\Url::to(['medicine-list']);

    echo Select2::widget([
        'name' => 'receiptMedicines',
        'value' => '',
        'language' => 'ar',
        'options' => ['multiple' => true, 'placeholder' => Yii::t('app','SelectMedicines')],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(item) { return \'<div class="row">\' + \'<div class="col-md-12">\' + \'<b >\' + item.text + \'</b>\' + \'</div>\' + \'</div>\' + \'<div class="row">\' + \'<div class="col-md-6"><i class="fa fa-code-fork"></i> \' + item.caliber + \'</div>\' + \'<div class="col-md-6"><i class="fa fa-question-circle"></i> \' + item.how + \'</div>\' + \'</div>\'; }'),
            'templateSelection' => new JsExpression('function (item) { return item.text + " " + item.caliber + " " + item.how ; }'),
        ],
    ]);


    ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
