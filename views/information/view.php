<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Information */

$this->title = $model->id;
$this->params["breadcrumbs"][] = ["label" => Yii::t("app","Informations"), "url" => ["index"]];
$this->params["breadcrumbs"][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="information-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t("app","Update"), ["update", "id" => $model->id], ["class" => "btn btn-primary"]) ?>
    </p>

    <?= DetailView::widget([
        "model" => $model,
        "attributes" => [
            "id",
            "name_doctor:html",
            "address1:html",
            "address2:ntext",
            "phone1",
            "phone2",
            "mobile1",
            "mobile2",
            "bio:html",
            "acceciblate:html",
            "logo"
        ],
    ]) ?>

</div>
