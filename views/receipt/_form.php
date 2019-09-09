<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Medicine;
use kartik\select2\Select2;
//use kartik\date\DatePicker;
use dosamigos\datepicker\DatePicker;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Receipt */
/* @var $medicine app\models\Medicine */
/* @var $modelDetail app\models\MedicineDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receipt-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'date')->widget(
    DatePicker::className(), [
        // inline too, not bad
        'inline' => false,
        'template' => '{addon}{input}',
         'size' => 'md',
         // modify template for custom rendering
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true,
        ]
    ]);?>

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
    ?>



<!-- new widget   -->
    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-record"></i><?= Yii::t('app','Details') ?> </h4></div>
        <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelDetail[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'caliber',
                    'how_to_use',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($modelDetail as $i => $item): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left"></h3>
                            <div class="pull-right">
                                <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (! $item->isNewRecord) {
                                echo Html::activeHiddenInput($item, "[{$i}]id");
                            }
                            ?>



                            <div class="row">


                                <div class="col-sm-6">
                                    <?= $form->field($item, "[{$i}]caliber")->textInput(['maxlength' => true]) ?>
                                </div>

                                <div class="col-sm-6">
                                    <?= $form->field($item, "[{$i}]medicine_id")->widget(Select2::classname(), [
                                        'name' => "receiptMedicines",
                                        'value' => '',
                                        'language' => 'ar',
                                        'options' => ['multiple' => false, 'placeholder' => Yii::t('app','SelectMedicines'), 'onchange' => 'get_index($(this))'],
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
                                            'templateResult' => new JsExpression('function(item) { return \'<div class="row">\' + \'<div class="col-md-12">\' + \'<b >\' + item.text + \'</b>\' + \'</div>\' + \'</div>\'; }'),
                                            'templateSelection' => new JsExpression('function (item) { set_value_to_how_textarea(item.how); return item.text + "\n"; }'),
                                        ],
                                    ]); ?>
                                </div>



                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <?= $form->field($item, "[{$i}]how_to_use")->textarea(["rows" => 6]) ?>
                                </div>
                            </div>


                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
<!--  end widget  -->

    <br>
    <div class="form-group">
    
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success']) ?>        
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="application/javascript">

    var index = -1;
    function get_index(item) {

        index  = item.attr("id").replace(/[^0-9.]/g, "");;
    }

    function set_value_to_how_textarea(value) {

        if (index != -1 && value != undefined)
            $("#medicinedetail-" + index + "-how_to_use").val(value);
        else
            index = -1;
    }

</script>
