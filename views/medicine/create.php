<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Medicine */
/* @var $modelDetail app\models\MedicineDetail */

$this->title = Yii::t("app","Create");
$this->params["breadcrumbs"][] = ["label" => Yii::t("app","Medicines"), "url" => ["index"]];
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="medicine-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
        "modelDetail" => $modelDetail,
    ]) ?>

</div>
