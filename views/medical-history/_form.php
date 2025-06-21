<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// Importar os models para usar os métodos de lista
use app\models\Animal;
use app\models\Veterinarian;

/** @var yii\web\View $this */
/** @var app\models\MedicalHistory $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="medical-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_animal')->dropDownList(
        Animal::getAnimalList(), // Lista os nomes dos animais
        ['prompt' => 'Selecione o Animal']
    ) ?>

    <?= $form->field($model, 'id_vet')->dropDownList(
        Veterinarian::getVeterinarianList(), // Lista os nomes dos veterinários
        ['prompt' => 'Selecione o Veterinário']
    ) ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, [
        'language' => 'pt-BR',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control']
    ]) ?>

    <?= $form->field($model, 'symptoms')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'diagnosis')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'treatment')->textarea(['rows' => 6]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>