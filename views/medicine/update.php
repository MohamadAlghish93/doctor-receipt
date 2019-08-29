<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Medicine */
/* @var $modelDetail app\models\MedicineDetail */

$this->title = Yii::t("app","Update") . " " . $model->id;
$this->params["breadcrumbs"][] = ["label" => Yii::t("app","Medicines"), "url" => ["index"]];
$this->params["breadcrumbs"][] = ["label" => $model->id, "url" => ["view", "id" => $model->id]];
$this->params["breadcrumbs"][] = Yii::t("app","Update");
?>
<div class="medicine-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
        "modelDetail" => $modelDetail,
    ]) ?>

</div>
