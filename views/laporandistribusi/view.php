<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DistribusiBarang */

$this->title = $model->no_distribusi;
$this->params['breadcrumbs'][] = ['label' => 'Laporan Distribusi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distribusi-barang-view">

    <h1>Detail Distribusi Barang (<?= Html::encode($this->title) ?>)</h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'no_distribusi',
            'tanggal_distribusi',
            [
                'label' => 'unit',
                'value' => @$model->unit->kode_unit.' - '.@$model->unit->unit_kerja,
            ],
            [
                'label' => 'Project',
                'value' => @$model->project->kode_project.' - '.@$model->project->nama_project,
            ],
            'no_request',
            'penerima',
            'keterangan',
        ],
    ]) ?>

    <table class="table table-bordered table-striped margin-b-none">
        <thead>
            <tr>
                <th style="width: 120px;">Kode Barang</th>
                <th style="width: 120px;">Nama Barang</th>
                <th style="width: 120px;">QTY</th>
                <th style="width: 120px;">Satuan</th>
                <th style="width: 500px;">Keterangan</th>
            </tr>
        </thead>
        <tbody class="form-options-body"><!-- widgetContainer -->
            <?php foreach ($model->details as $index => $modelDetail): ?>
                <tr class="form-options-item">
                    <td>
                        <?= $modelDetail->kode_barang; ?>
                    </td>
                    <td>
                        <?= $modelDetail->barang->nama_barang; ?>
                    </td>
                    <td>
                        <?= $modelDetail->qty; ?>
                    </td>
                    <td>
                        <?= $modelDetail->barang->satuan->satuan_barang; ?>
                    </td>
                    <td>
                        <?= $modelDetail->keterangan; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
