<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Medicine */
/* @var $modelDetail app\models\MedicineDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medicine-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, "name_arabic")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "name_english")->textInput(["maxlength" => true]) ?>

<!--    --><?//= $form->field($model, "type")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "how_to_use")->textarea(["rows" => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t("app","Save"), ["class" => "btn btn-success" ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
