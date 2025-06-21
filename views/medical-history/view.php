<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Histórico de ' . $model->animal->name;
$this->params['breadcrumbs'][] = ['label' => 'Históricos Clínicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="medical-history-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => ['confirm' => 'Tem certeza que deseja apagar este item?', 'method' => 'post'],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['label' => 'Animal', 'value' => $model->animal->name],
            ['label' => 'Veterinário', 'value' => $model->vet->name],
            'date',
            'symptoms:ntext',
            'diagnosis:ntext',
            'treatment:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
</div>