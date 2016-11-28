<?php

use yii\helpers\Html;
use yii\grid\GridView;
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

$this->title = 'Laporan Stok Warning';
$this->params['breadcrumbs'][] = $this->title;

$js = '
$("#laporanstokwarningsearch-kode_barang").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Barang -","language":"en-US"});
$("#laporanstokwarningsearch-kode_kategori").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Kategori -","language":"en-US"});
$("#laporanstokwarningsearch-kode_satuan").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Satuan -","language":"en-US"});
$("#laporanstokwarningsearch-tampil_stok_kosong").select2({"theme":"bootstrap","width":"100%","language":"en-US"});
';

$this->registerJs($js);
Select2Asset::register($this);
?>
<div class="adjustment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="distribusi-barang-form">

        <?php $form = ActiveForm::begin(['layout' => 'horizontal','id' => 'dynamic-form','method' => 'get']); ?>

        <?= $form->field($searchModel, "kode_barang")->dropDownList(ArrayHelper::map(Barang::find()->all(), 'kode_barang', 'kodenama'),['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>

        <?= $form->field($searchModel, "kode_kategori")->dropDownList(ArrayHelper::map(KategoriBarang::find()->all(), 'kode_kategori', 'kategori_barang'),['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>

        <?= $form->field($searchModel, 'nama_barang')->textInput() ?>

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
            'stock_warning',
            'stok',
            // 'keterangan',
            // 'kode_unit',
            // 'penanggung_jawab',

            // ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
    ]); ?>
</div>
