<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Scheduling $model */

$this->title = 'Update Scheduling: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Schedulings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="scheduling-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
