<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\unit */

$this->title = 'Create Unit';
$this->params['breadcrumbs'][] = ['label' => 'Unit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>