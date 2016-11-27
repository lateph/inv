<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PenerimaanBarang */

$this->title = 'Update Penerimaan Barang: ' . $model->no_penerimaan;
$this->params['breadcrumbs'][] = ['label' => 'Penerimaan Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->no_penerimaan, 'url' => ['view', 'id' => $model->no_penerimaan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="penerimaan-barang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
