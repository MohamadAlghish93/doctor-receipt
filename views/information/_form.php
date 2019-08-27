<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Information */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="information-form">

    <?php $form = ActiveForm::begin(
            [
                    "options" => ["enctype" => "multipart/form-data"]
            ]
    ); ?>

    <?= $form->field($model, "name_doctor")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "address1")->textarea(["rows" => 6]) ?>

    <?= $form->field($model, "address2")->textarea(["rows" => 6]) ?>

    <?= $form->field($model, "phone1")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "phone2")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "mobile1")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "mobile2")->textInput(["maxlength" => true]) ?>

    <?= $form->field($model, "bio")->textarea(["rows" => 6]) ?>

    <?= $form->field($model, 'acceciblate')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, "logo")->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t("app","Save"), ["class" => "btn btn-success"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
