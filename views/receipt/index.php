<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReceiptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Receipts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receipt-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app','Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date',
            'patient_name',
            [
                'label' => Yii::t('app','Medicines'),
                'value' => function($model){
                    return join(', ', yii\helpers\ArrayHelper::map($model->receiptMedicines, 'id', 'name_english'));
                },

            ],


            ['class' => 'yii\grid\ActionColumn','template'=>'{view} {delete}'],
        ],
    ]); ?>


</div>
