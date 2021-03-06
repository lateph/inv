<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2Asset;
 use kartik\datetime\DateTimePicker;
 use yii\helpers\ArrayHelper;
use app\models\Barang;
/* @var $this yii\web\View */
/* @var $model app\models\Adjustment */
/* @var $form yii\widgets\ActiveForm */
Select2Asset::register($this);
$js = '

$("#adjustment-kode_barang").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Barang -","language":"en-US"});
$("#adjustment-kondisi").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Kondisi -","language":"en-US"});

';


$this->registerJs($js);
?>

<div class="adjustment-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal','id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'no_adjustment')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'tanggal_adjustment', [
      
            ])->widget(DateTimePicker::classname(),[
      'options' => ['placeholder' => ''],
      'value' => date('d-M-Y'),
      'readonly' => true,
      
      'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd hh:ii',
        'todayHighlight' => TRUE,
    ]
    ]);
    ?>

    <?= $form->field($model, "kode_barang")->dropDownList(ArrayHelper::map(Barang::find()->all(), 'kode_barang', 'kodenama'),['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang form-control'] ) ?>

    <?= $form->field($model, "kondisi")->dropDownList(['1'=>'Berkurang','2'=>'Bertambah','3'=>'Service Maintenance Out','4'=>'Service Maintenance In'],['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penanggung_jawab')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-10">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
