<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdjustmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adjustments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjustment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Adjustment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_adjustment',
            'tanggal_adjustment',
            'kode_barang',
            'kondisi',
            'qty',
            // 'keterangan',
            // 'kode_unit',
            // 'penanggung_jawab',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
