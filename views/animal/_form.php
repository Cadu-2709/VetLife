<?php

// IMPORTANTE: As linhas 'use' abaixo são essenciais para o formulário funcionar.
use yii\helpers\Html;
use yii\widgets\ActiveForm; // <-- Esta linha corrige o erro 'ActiveForm not found'
use app\models\Animal; // Importar o model para usar o método getClientList()

/** @var yii\web\View $this */
/** @var app\models\Animal $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="animal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_client')->dropDownList(
        Animal::getClientList(),
        ['prompt' => 'Selecione um Tutor']
    ) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'species')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'race')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'obs')->textarea(['rows' => 6]) ?>

    <!-- Os campos created_at e updated_at foram removidos daqui -->

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
