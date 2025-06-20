<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Scheduling $model */

$this->title = 'Create Scheduling';
$this->params['breadcrumbs'][] = ['label' => 'Schedulings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduling-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
