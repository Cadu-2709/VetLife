<?php
use app\models\Animal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

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
            ['attribute' => 'id_client', 'label' => 'Tutor', 'value' => 'client.name'],
            'name',
            'species',
            'race',
            'sex',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Animal $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
</div>
