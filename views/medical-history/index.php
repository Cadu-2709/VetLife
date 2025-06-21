<?php
use app\models\MedicalHistory;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Históricos Clínicos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medical-history-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Criar Histórico Clínico', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            ['attribute' => 'id_animal', 'label' => 'Animal', 'value' => 'animal.name'],
            ['attribute' => 'id_vet', 'label' => 'Veterinário', 'value' => 'vet.name'],
            'date',
            'symptoms:ntext',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, MedicalHistory $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
</div>
