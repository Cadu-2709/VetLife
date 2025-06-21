<?php
namespace app\controllers;

use app\models\Scheduling;
use app\models\SchedulingSearch;
use yii\web\NotFoundHttpException;
use Yii;

class SchedulingController extends BaseController
{
    /**
     * @inheritdoc
     */
    protected $permissions = [
        'index' => ['admin', 'receptionist', 'veterinarian', 'client'],
        'view' => ['admin', 'receptionist', 'veterinarian', 'client'],
        'create' => ['admin', 'receptionist', 'client'],
        'update' => ['admin', 'receptionist', 'veterinarian', 'client'],
        'delete' => ['admin', 'receptionist'],
    ];

    /**
     * @inheritdoc
     */
    protected $customErrorMessages = [
        'index' => 'Você não tem permissão para visualizar agendamentos.',
        'view' => 'Você não tem permissão para visualizar este agendamento.',
        'create' => 'Você não tem permissão para criar agendamentos. Entre em contacto com a recepção.',
        'update' => 'Você não tem permissão para editar este agendamento.',
        'delete' => 'Apenas administradores e recepcionistas podem cancelar agendamentos.',
    ];

    public function actionIndex()
    {
        $searchModel = new SchedulingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Scheduling();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Agendamento criado com sucesso.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Agendamento atualizado com sucesso.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Agendamento removido com sucesso.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Scheduling::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('A página solicitada não existe.');
    }
}
