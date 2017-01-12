<?php

use yii\helpers\Html;
use kartik\grid\GridView;
 use kartik\export\ExportMenu;
use yii\bootstrap\ActiveForm;
 use kartik\date\DatePicker;
use kartik\select2\Select2Asset;
use yii\helpers\ArrayHelper;
use app\models\Barang;
use app\models\KategoriBarang;
use app\models\Satuan;
use app\models\Adjustment;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LaporanAdjustmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Mutasi Stok';
$this->params['breadcrumbs'][] = $this->title;
$url = \yii\helpers\Url::to(['ajax/barang']);
$js = '
$("#laporanstokmutasisearch-kode_barang").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Barang -","language":"en-US",
    "minimumInputLength" : 3,
    "ajax" : {
        "url" : "'.$url.'",
        "dataType" : "json",
        "data" : function(params) { return {q:params.term}; }
    },
    "escapeMarkup" : function (markup) { return markup; },
    "templateResult" : function(city) { return city.text; },
    "templateSelection" : function (city) { return city.text; },});
$("#laporanstokmutasisearch-kode_kategori").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Kategori -","language":"en-US"});
$("#laporanstokmutasisearch-kode_satuan").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Satuan -","language":"en-US"});
$("#laporanstokmutasisearch-tampil_stok_kosong").select2({"theme":"bootstrap","width":"100%","language":"en-US"});
$("#laporanstokmutasisearch-tipeio").select2({"allowClear":true,"theme":"bootstrap","width":"100%","language":"en-US","placeholder":"- Pilih In/Out -"});
$("#laporanstokmutasisearch-referensi").select2({"allowClear":true,"theme":"bootstrap","width":"100%","language":"en-US","placeholder":"- Pilih Referensi -"});
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

        <?= $form->field($searchModel, "tipeIO")->dropDownList(['in'=>'In','out'=>'Out'],['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>

        <?= $form->field($searchModel, "referensi")->dropDownList(['1'=>'penerimaan','2'=>'distribusi','3'=>'adjustment'],['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>

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
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['label'=>'Kode','attribute'=>'referensi'],
            ['label'=>'Referensi','attribute'=>'tipe','value'=>function($row){
                switch ($row->tipe) {
                    case 1:
                        return "Penerimaan";
                        break;

                    case 2:
                        return "Distribusi"; 
                        break;

                    case 3:
                        return "Adjustment"; 
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }],
            ['label'=>'Unit','attribute'=>'kode_unit','value'=>function($row){
                switch ($row->kode_unit) {
                    case 'G001':
                        return "Gudang";
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }],
            'tanggal',
            ['label'=>'Tipe','attribute'=>'qty_in','value'=>function($row){
                if($row->qty_in > $row->qty_out){
                    return 'In';
                }
                else{
                    return 'Out';
                }
            }],
            ['label'=>'QTY','attribute'=>'qty_out','value'=>function($row){
                if($row->qty_in > $row->qty_out){
                    return $row->qty_in;
                }
                else{
                    return $row->qty_out; 
                }
            }],
            'stok',
            ['class' => 'yii\grid\ActionColumn','template'=>'{view}',
            'buttons'=>[
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'View'),
                    ]);
                },
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        if($model->tipe == 1){
                            return \yii\helpers\Url::to(['/laporanpenerimaan/view','id'=>$model->referensi]);
                        }
                        if($model->tipe == 2){
                            return \yii\helpers\Url::to(['/laporandistribusi/view','id'=>$model->referensi]);
                        }
                        if($model->tipe == 3){
                            return \yii\helpers\Url::to(['/laporanadjustment/view','id'=>$model->referensi]);
                        }
                    }
                  }
            ],
            // 'keterangan',
            // 'kode_unit',
            // 'penanggung_jawab',

            // ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
    ]); 

    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['label'=>'Kode','attribute'=>'referensi'],
            ['label'=>'Referensi','attribute'=>'tipe','value'=>function($row){
                switch ($row->tipe) {
                    case 1:
                        return "Penerimaan";
                        break;

                    case 2:
                        return "Distribusi"; 
                        break;

                    case 3:
                        return "Adjustment"; 
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }],
            ['label'=>'Unit','attribute'=>'kode_unit','value'=>function($row){
                switch ($row->kode_unit) {
                    case 'G001':
                        return "Gudang";
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }],
            'tanggal',
            ['label'=>'Tipe','attribute'=>'qty_in','value'=>function($row){
                if($row->qty_in > $row->qty_out){
                    return 'In';
                }
                else{
                    return 'Out';
                }
            }],
            ['label'=>'QTY','attribute'=>'qty_out','value'=>function($row){
                if($row->qty_in > $row->qty_out){
                    return $row->qty_in;
                }
                else{
                    return $row->qty_out; 
                }
            }],
            'stok',
        ]
    ]);
    ?>
</div>
