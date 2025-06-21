<?php
use app\models\Scheduling;
use app\helpers\AuthHelper;
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
        <?php if (AuthHelper::can('scheduling.create')): ?>
            <?= Html::a('Criar Agendamento', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
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
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        if (AuthHelper::can('scheduling.view')) {
                            return Html::a('<i class="fas fa-eye"></i>', $url, [
                                'title' => 'Ver',
                                'class' => 'btn btn-sm btn-outline-primary',
                            ]);
                        }
                        return '';
                    },
                    'update' => function ($url, $model, $key) {
                        if (AuthHelper::can('scheduling.update')) {
                            return Html::a('<i class="fas fa-edit"></i>', $url, [
                                'title' => 'Editar',
                                'class' => 'btn btn-sm btn-outline-warning',
                            ]);
                        }
                        return '';
                    },
                    'delete' => function ($url, $model, $key) {
                        if (AuthHelper::can('scheduling.delete')) {
                            return Html::a('<i class="fas fa-trash"></i>', $url, [
                                'title' => 'Excluir',
                                'class' => 'btn btn-sm btn-outline-danger',
                                'data-confirm' => 'Tem certeza que deseja excluir este agendamento?',
                                'data-method' => 'post',
                            ]);
                        }
                        return '';
                    },
                ],
                'urlCreator' => function ($action, Scheduling $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
</div>