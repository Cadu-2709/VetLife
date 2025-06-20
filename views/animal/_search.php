<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AnimalSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="animal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_client') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'species') ?>

    <?= $form->field($model, 'race') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'obs') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
