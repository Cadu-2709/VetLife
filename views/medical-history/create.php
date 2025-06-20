<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MedicalHistory $model */

$this->title = 'Create Medical History';
$this->params['breadcrumbs'][] = ['label' => 'Medical Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medical-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
