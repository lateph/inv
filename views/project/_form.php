<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Unit;
use yii\bootstrap\ActiveForm; 

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'kode_project')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_project')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_mulai')->widget(\yii\jui\DatePicker::classname(), [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
    ]) ?>


    <?= $form->field($model, 'tanggal_selesai')->widget(\yii\jui\DatePicker::classname(), [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
    ]) ?>

    <?= $form->field($model, 'perusahaan')->dropDownList(ArrayHelper::map(Unit::find()->all(), 'kode_unit', 'unit_kerja'),['prompt'=>' - Perusahaan -']) ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-10">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
