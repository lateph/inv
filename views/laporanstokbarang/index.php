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

$this->title = 'Laporan Stok Barang';
$this->params['breadcrumbs'][] = $this->title;
$url = \yii\helpers\Url::to(['ajax/barang']);
$js = '
$("#laporanstokbarangsearch-kode_barang").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Barang -","language":"en-US",
    "minimumInputLength" : 3,
    "ajax" : {
        "url" : "'.$url.'",
        "dataType" : "json",
        "data" : function(params) { return {q:params.term}; }
    },
    "escapeMarkup" : function (markup) { return markup; },
    "templateResult" : function(city) { return city.text; },
    "templateSelection" : function (city) { return city.text; },});
$("#laporanstokbarangsearch-kode_kategori").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Kategori -","language":"en-US"});
$("#laporanstokbarangsearch-kode_satuan").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Satuan -","language":"en-US"});
$("#laporanstokbarangsearch-tampil_stok_kosong").select2({"theme":"bootstrap","width":"100%","language":"en-US"});
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
        <?= $form->field($searchModel, "kode_barang")->dropDownList( $ar,['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>

        <?= $form->field($searchModel, "kode_kategori")->dropDownList(ArrayHelper::map(KategoriBarang::find()->all(), 'kode_kategori', 'kategori_barang'),['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>

        <?= $form->field($searchModel, 'nama_barang')->textInput() ?>


        <?= $form->field($searchModel, "kode_satuan")->dropDownList(ArrayHelper::map(Satuan::find()->all(), 'kode_satuan', 'satuan_barang'),['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>

        <?= $form->field($searchModel, 'deskripsi')->textarea(['rows' => 6]) ?>

        <?= $form->field($searchModel, "tampil_stok_kosong")->dropDownList(['1'=>'Ya','2'=>'Tidak'],['target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>      

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

            'kode_barang',
            'nama_barang',
            'kategori.kategori_barang',
            'satuan.satuan_barang',
            'stok',
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

            'kode_barang',
            'nama_barang',
            'kategori.kategori_barang',
            'satuan.satuan_barang',
            'stok',
        ]
    ]);

    ?>
</div>
