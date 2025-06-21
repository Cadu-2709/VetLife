<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// Importar os models para usar os métodos de lista
use app\models\Animal;
use app\models\Veterinarian;
use app\models\Service;
use app\models\SchedulingStatus;

/** @var yii\web\View $this */
/** @var app\models\Scheduling $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="scheduling-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_animal')->dropDownList(
        Animal::getAnimalList(),
        ['prompt' => 'Selecione o Animal']
    ) ?>

    <?= $form->field($model, 'id_vet')->dropDownList(
        Veterinarian::getVeterinarianList(),
        ['prompt' => 'Selecione o Veterinário']
    ) ?>

    <?= $form->field($model, 'id_service')->dropDownList(
        Service::getServiceList(),
        ['prompt' => 'Selecione o Serviço']
    ) ?>

    <?= $form->field($model, 'id_status')->dropDownList(
        SchedulingStatus::getStatusList(),
        ['prompt' => 'Selecione o Status']
    ) ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, [
        'language' => 'pt-BR',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control']
    ]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
