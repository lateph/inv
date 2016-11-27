<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangSearchPenerimaanBarangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penerimaan-barang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'no_penerimaan') ?>

    <?= $form->field($model, 'tanggal_penerimaan') ?>

    <?= $form->field($model, 'supplier') ?>

    <?= $form->field($model, 'no_po') ?>

    <?= $form->field($model, 'pengirim') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
