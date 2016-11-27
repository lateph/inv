<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PenerimaanBarang */

$this->title = 'Create Penerimaan Barang';
$this->params['breadcrumbs'][] = ['label' => 'Penerimaan Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penerimaan-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
