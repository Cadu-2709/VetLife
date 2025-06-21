<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Agendamento: ' . $model->animal->name . ' em ' . Yii::$app->formatter->asDate($model->date);
$this->params['breadcrumbs'][] = ['label' => 'Agendamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="scheduling-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja apagar este agendamento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['label' => 'Animal', 'value' => $model->animal->name],
            ['label' => 'Veterinário', 'value' => $model->vet->name],
            ['label' => 'Serviço', 'value' => $model->service->name],
            ['label' => 'Status', 'value' => $model->status->name],
            'date:date',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
</div>
