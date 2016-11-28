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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->no_adjustment], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->no_adjustment], [
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
            'no_adjustment',
            'tanggal_adjustment',
            'kode_barang',
            'kondisi',
            'qty',
            'keterangan',
            'kode_unit',
            'penanggung_jawab',
        ],
    ]) ?>

</div>
