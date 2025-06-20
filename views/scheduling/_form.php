<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Scheduling $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="scheduling-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_animal')->textInput() ?>

    <?= $form->field($model, 'id_vet')->textInput() ?>

    <?= $form->field($model, 'id_service')->textInput() ?>

    <?= $form->field($model, 'id_status')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
