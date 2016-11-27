<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Adjustment */

$this->title = $model->no_adjustment;
$this->params['breadcrumbs'][] = ['label' => 'Adjustments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjustment-view">

    <h1>Adjustment (<?= Html::encode($this->title) ?>)</h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'no_adjustment',
            'tanggal_adjustment',
            [
                'label' => 'Barang',
                'value' => @$model->barang->kode_barang.' - '.@$model->barang->nama_barang,
            ],
            [
                'label' => 'Kondisi',
                'value' => @$model::pilihanKondisi[$model->kondisi],
            ],
            'qty',
            'keterangan',
            // 'kode_unit',
            'penanggung_jawab',
        ],
    ]) ?>

</div>
