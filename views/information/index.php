<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InformationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t("app","Informations") ;
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="information-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        "dataProvider" => $dataProvider,
        "filterModel" => $searchModel,
        "columns" => [

            "id",
            "name_doctor",
            "address1:ntext",
            "phone1",
            "mobile1",
            [
                "label" => Yii::t("app","Logo"),
                "attribute" => "logo",
                "format" => "html",
                "value" => function($model){
                    return yii\bootstrap\Html::img($model->logo, ["width" => "150"]);
                }
            ],

            ["class" => "yii\grid\ActionColumn","template"=>"{view} {update}"],
        ],
    ]); ?>


</div>
