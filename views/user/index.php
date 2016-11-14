<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Unit;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_user',
            'username',
            // 'password',
            'nama',
            [
                'attribute' => 'unit',
                'value' => 'unit.unit_kerja',
                'filter' => ArrayHelper::map(Unit::find()->all(), 'kode_unit', 'unit_kerja')
            ],
            'hak_akses',

              ['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}'],
            
        ],
    ]); ?>
</div>
