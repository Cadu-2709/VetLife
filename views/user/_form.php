<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php // CORREÇÃO: Usar o campo 'password' em vez de 'pwd_hash'.
    // O campo será do tipo password, que esconde os caracteres.
    // Deixe em branco ao editar para não alterar a palavra-passe existente.
    ?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Deixe em branco para não alterar']) ?>

    <?php // CORREÇÃO: Substituído o campo de texto por um dropdown de funções.
    // Isto garante que apenas as funções predefinidas possam ser selecionadas.
    ?>
    <?= $form->field($model, 'role')->dropDownList(
        [
            'admin' => 'Administrador',
            'veterinario' => 'Veterinário',
            'recepcionista' => 'Recepcionista',
        ],
        ['prompt' => 'Selecione uma Função']
    ) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>