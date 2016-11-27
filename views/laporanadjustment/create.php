<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Adjustment */

$this->title = 'Create Adjustment';
$this->params['breadcrumbs'][] = ['label' => 'Adjustments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjustment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
