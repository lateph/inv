<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PenerimaanBarang */

$this->title = $model->no_penerimaan;
$this->params['breadcrumbs'][] = ['label' => 'Laporan Penerimaan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penerimaan-barang-view">

    <h1>Detail Penerimaan Barang (<?= Html::encode($this->title) ?>)</h1>

    <div class="btn-group" role="group" aria-label="..." style="margin-bottom:20px">
      <a type="button" class="btn btn-success" href="<?=\yii\helpers\Url::to(['penerimaan/index'])?>">Penerimaan Baru</a>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'no_penerimaan',
            'tanggal_penerimaan',
            'supplier',
            'no_po',
            'pengirim',
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
