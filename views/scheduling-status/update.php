<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SchedulingStatus $model */

$this->title = 'Update Scheduling Status: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Scheduling Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="scheduling-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
