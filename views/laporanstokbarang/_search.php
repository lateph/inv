<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdjustmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adjustment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'no_adjustment') ?>

    <?= $form->field($model, 'tanggal_adjustment') ?>

    <?= $form->field($model, 'kode_barang') ?>

    <?= $form->field($model, 'kondisi') ?>

    <?= $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'kode_unit') ?>

    <?php // echo $form->field($model, 'penanggung_jawab') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
