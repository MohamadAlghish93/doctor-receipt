<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Receipt */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Receipts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="receipt-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app','Delete') , ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date',
            'patient_name',
            [
                'attribute' => 'file',
                'label' =>  Yii::t('app','File'),
                'value' => function ($model) {
                    return Html::a('<i class="glyphicon glyphicon-download-alt"></i>', [
                        'receipt/pdf',
                        'id' => $model->id,
                    ], [
                        'class' => 'btn btn-primary',
                        'target' => '_blank',
                    ]);
                },
                'format' => 'raw',
            ],
            [
                'label' => Yii::t('app','Medicines'),
                'value' => function($model){
                    return join(', ', yii\helpers\ArrayHelper::map($model->receiptMedicines, 'id', 'name_english'));
                },
            ],
        ],
    ]) ?>

</div>
