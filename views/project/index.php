<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Unit;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_project',
            'nama_project',
            // 'lokasi',
            'tanggal_mulai',
            'tanggal_selesai',
            [
                'attribute' => 'perusahaan',
                'value' => 'unit.unit_kerja',
                'filter' => ArrayHelper::map(Unit::find()->all(), 'kode_unit', 'unit_kerja')
            ],

             ['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}'],
        ],
    ]); ?>
</div>
