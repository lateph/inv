<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Adjustment */

$this->title = 'Adjustment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjustment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
  		<div class="alert alert-success alert-dismissable">
			<?= Yii::$app->session->getFlash('success') ?>
	 	</div>
	<?php endif; ?>
	
    <?= $this->render('_form', [
        'modelDetails' => $modelDetails,
        'model' => $model,
    ]) ?>

</div>
