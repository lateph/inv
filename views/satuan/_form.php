<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Satuan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="satuan-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'kode_satuan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'satuan_barang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'singkatan')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
    	<div class="col-sm-offset-3 col-sm-10">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    	</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
