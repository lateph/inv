<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use app\models\Barang;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2Asset;
 use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LaporanPenerimaanBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Penerimaan';
$this->params['breadcrumbs'][] = $this->title;
Select2Asset::register($this);
$url = \yii\helpers\Url::to(['ajax/barang']);
$js = '
$("#laporanpenerimaanbarangsearch-kode_barang").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Barang -","language":"en-US",
    "minimumInputLength" : 3,
    "ajax" : {
        "url" : "'.$url.'",
        "dataType" : "json",
        "data" : function(params) { return {q:params.term}; }
    },
    "escapeMarkup" : function (markup) { return markup; },
    "templateResult" : function(city) { return city.text; },
    "templateSelection" : function (city) { return city.text; },});
';

$this->registerJs($js);
Select2Asset::register($this);
?>
<div class="penerimaan-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="penerimaan-barang-form">

        <?php $form = ActiveForm::begin(['layout' => 'horizontal','id' => 'dynamic-form','method' => 'get']); ?>

        <?= $form->field($searchModel, 'supplier')->textInput(['maxlength' => true]) ?>

        <?php
            $barang = Barang::findOne(['kode_barang'=>$searchModel->kode_barang]);
            $ar = [];
            if($barang){
                $ar = [$barang->kode_barang=>$barang->kode_barang.' - '.$barang->nama_barang];
            }
        ?>
        <?= $form->field($searchModel, "kode_barang")->dropDownList($ar,['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>

        <?= $form->field($searchModel, 'tgl1', [
      
                    ])->widget(DatePicker::classname(),[
                         'type' => DatePicker::TYPE_RANGE,
                      'options' => ['placeholder' => ''],
                      'value' => date('d-M-Y'),
                      'readonly' => true,
                        'attribute2'=>'tgl2',
                      'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => TRUE,
                    ]
                    ]);
            ?>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-10">
                <?= Html::submitButton("Search", ['class' =>'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_penerimaan',
            'tanggal_penerimaan',
            'supplier',
            'no_po',
            'pengirim',
            // 'keterangan',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
    ]); ?>
</div>
