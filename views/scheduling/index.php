<?php
use app\models\Scheduling;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Agendamentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduling-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Criar Agendamento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id_animal',
                'label' => 'Animal',
                'value' => 'animal.name',
            ],
            [
                'attribute' => 'id_vet',
                'label' => 'Veterinário',
                'value' => 'vet.name',
            ],
            [
                'attribute' => 'id_service',
                'label' => 'Serviço',
                'value' => 'service.name',
            ],
            [
                'attribute' => 'id_status',
                'label' => 'Status',
                'value' => 'status.name',
            ],
            'date:date',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Scheduling $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
</div>