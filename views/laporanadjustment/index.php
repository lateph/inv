<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
 use kartik\date\DatePicker;
use kartik\select2\Select2Asset;
use yii\helpers\ArrayHelper;
use app\models\Barang;
use app\models\Adjustment;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LaporanAdjustmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Adjustments';
$this->params['breadcrumbs'][] = $this->title;
$url = \yii\helpers\Url::to(['ajax/barang']);
$js = '
$("#laporanadjustmentsearch-kode_barang").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Barang -","language":"en-US",
    "minimumInputLength" : 3,
    "ajax" : {
        "url" : "'.$url.'",
        "dataType" : "json",
        "data" : function(params) { return {q:params.term}; }
    },
    "escapeMarkup" : function (markup) { return markup; },
    "templateResult" : function(city) { return city.text; },
    "templateSelection" : function (city) { return city.text; },});
$("#laporandistribusibarangsearch-kode_unit").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Unit -","language":"en-US"});
$("#laporanadjustmentsearch-kondisi").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Kondisi -","language":"en-US"});
';

$this->registerJs($js);
Select2Asset::register($this);
?>
<div class="adjustment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="distribusi-barang-form">

        <?php $form = ActiveForm::begin(['layout' => 'horizontal','id' => 'dynamic-form','method' => 'get']); ?>

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

    <?= $form->field($searchModel, "kondisi")->dropDownList(['1'=>'Berkurang','2'=>'Bertambah','3'=>'Service Maintenance Out','4'=>'Service Maintenance In'],['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>      

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-10">
                <?= Html::submitButton("Search", ['class' =>'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_adjustment',
            'tanggal_adjustment',
            'barang.nama_barang',
            [
                'attribute'=>'kondisi',
                'content'=>function($e){
                    return @Adjustment::pilihanKondisi[$e->kondisi];
                } 
            ],
            'qty',
            // 'keterangan',
            // 'kode_unit',
            // 'penanggung_jawab',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
    ]); ?>
</div>
