<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\KategoriBarang;
use app\models\Satuan;


/* @var $this yii\web\View */
/* @var $searchModel app\models\BarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Barang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Barang', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nama_barang',
            [
                'attribute' => 'kategori',
                'value' => 'kategori.kategori_barang',
                'filter' => ArrayHelper::map(KategoriBarang::find()->all(), 'kode_kategori', 'kategori_barang')
            ],
            [
                'attribute' => 'satuan',
                'value' => 'satuan.satuan_barang',
                'filter' => ArrayHelper::map(Satuan::find()->all(), 'kode_satuan', 'satuan_barang')
            ],
            // 'deskripsi:ntext',
            'stock_warning',

              ['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}'],
        ],
    ]); ?>
</div>
