<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Adjustment */

$this->title = 'Update Adjustment: ' . $model->no_adjustment;
$this->params['breadcrumbs'][] = ['label' => 'Adjustments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->no_adjustment, 'url' => ['view', 'id' => $model->no_adjustment]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="adjustment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
