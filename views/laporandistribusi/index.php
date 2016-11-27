<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use app\models\Barang;
use app\models\Unit;
use app\models\Project;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2Asset;
 use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LaporanDistribusiBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Distribusi';
$this->params['breadcrumbs'][] = $this->title;

$js = '
$("#laporandistribusibarangsearch-kode_barang").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Barang -","language":"en-US"});
$("#laporandistribusibarangsearch-kode_unit").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Unit -","language":"en-US"});
$("#laporandistribusibarangsearch-kode_project").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Project -","language":"en-US"});
';

$this->registerJs($js);
Select2Asset::register($this);
?>
<div class="distribusi-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="distribusi-barang-form">

        <?php $form = ActiveForm::begin(['layout' => 'horizontal','id' => 'dynamic-form','method' => 'get']); ?>

        <?= $form->field($searchModel, "kode_unit")->dropDownList(ArrayHelper::map(Unit::find()->all(), 'kode_unit', 'unit_kerja'),['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>
        <?= $form->field($searchModel, "kode_project")->dropDownList(ArrayHelper::map(Project::find()->all(), 'kode_project', 'nama_project'),['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>

        <?= $form->field($searchModel, "kode_barang")->dropDownList(ArrayHelper::map(Barang::find()->all(), 'kode_barang', 'kodenama'),['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>

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

            'no_distribusi',
            'tanggal_distribusi',
            'unit.unit_kerja',
            'no_request',
            // 'keterangan',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
    ]); ?>
</div>
