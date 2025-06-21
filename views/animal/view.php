<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Animal: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Animais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="animal-view">
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
            ['label' => 'Tutor', 'value' => $model->client->name],
            'name',
            'species',
            'race',
            'sex',
            'color',
            'weight',
            'obs:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
</div>