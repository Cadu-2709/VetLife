<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SchedulingStatus $model */

$this->title = 'Create Scheduling Status';
$this->params['breadcrumbs'][] = ['label' => 'Scheduling Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduling-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
