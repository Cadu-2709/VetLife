<?php

use app\models\Animal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AnimalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Animais';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="animal-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cadastrar Novo Animal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // Mostra o nome do tutor em vez do ID
            [
                'attribute' => 'id_client',
                'value' => 'client.name',
                'label' => 'Tutor'
            ],
            'name',
            'species',
            'race',
            'sex',
            'weight',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Animal $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

</div>
