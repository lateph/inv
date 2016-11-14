<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\unit */

$this->title = 'Update Unit: ' . $model->kode_unit;
$this->params['breadcrumbs'][] = ['label' => 'Unit', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Update - '.$model->kode_unit];
?>
<div class="unit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
