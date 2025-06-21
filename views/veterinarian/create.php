<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Veterinarian $model */

$this->title = 'Create Veterinarian';
$this->params['breadcrumbs'][] = ['label' => 'Veterinarians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="veterinarian-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
