<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kode_barang') ?>

    <?= $form->field($model, 'kode_kategori') ?>

    <?= $form->field($model, 'nama_barang') ?>

    <?= $form->field($model, 'kode_satuan') ?>

    <?= $form->field($model, 'deskripsi') ?>

    <?php // echo $form->field($model, 'stock_warning') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
