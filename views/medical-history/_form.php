<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MedicalHistory $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="medical-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_animal')->textInput() ?>

    <?= $form->field($model, 'id_vet')->textInput() ?>

    <?= $form->field($model, 'date')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'symptoms')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'diagnosis')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'treatment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
