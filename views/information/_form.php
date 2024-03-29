<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;



/* @var $this yii\web\View */
/* @var $model app\models\Information */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="information-form">

    <?php $form = ActiveForm::begin(
    ); ?>
        

    <?= $form->field($model, 'name_doctor')->widget(TinyMce::className(), [
        'options' => ['rows' => 7],
        'language' => 'ar',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

    <?= $form->field($model, 'address1')->widget(TinyMce::className(), [
        'options' => ['rows' => 7],
        'language' => 'ar',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

    <?= $form->field($model, "address2")->textarea(["rows" => 6]) ?>

    <?= $form->field($model, "phone1")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "phone2")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "mobile1")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "mobile2")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, 'bio')->widget(TinyMce::className(), [
        'options' => ['rows' => 7],
        'language' => 'ar',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

    <?= $form->field($model, 'acceciblate')->widget(TinyMce::className(), [
        'options' => ['rows' => 7],
        'language' => 'ar',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>



    <?= $form->field($model, "logo")->dropDownList(
            array("A4"=>"A4" ,"A5"=>"A5" ,"A6"=>"A6"),
        array('empty'=>'Select Value')) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t("app","Save"), ["class" => "btn btn-success"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
