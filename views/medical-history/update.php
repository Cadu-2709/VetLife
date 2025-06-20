<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MedicalHistory $model */

$this->title = 'Update Medical History: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Medical Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="medical-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
