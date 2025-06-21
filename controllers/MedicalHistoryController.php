<?php
namespace app\controllers;

use app\models\MedicalHistory;
use app\models\MedicalHistorySearch;
use yii\web\NotFoundHttpException;
use Yii;

class MedicalHistoryController extends BaseController
{
    /**
     * @inheritdoc
     */
    protected $permissions = [
        'index' => ['admin', 'veterinarian', 'client'],
        'view' => ['admin', 'veterinarian', 'client'],
        'create' => ['admin', 'veterinarian'],
        'update' => ['admin', 'veterinarian'],
        'delete' => ['admin'],
    ];

    /**
     * @inheritdoc
     */
    protected $customErrorMessages = [
        'index' => 'Você não tem permissão para visualizar histórico clínico.',
        'view' => 'Você não tem permissão para visualizar este histórico clínico.',
        'create' => 'Apenas veterinários e administradores podem criar registos de histórico clínico.',
        'update' => 'Apenas veterinários e administradores podem editar histórico clínico.',
        'delete' => 'Apenas administradores podem remover registos de histórico clínico.',
    ];
    
    public function actionIndex()
    {
        $searchModel = new MedicalHistorySearch();
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
        $model = new \app\models\MedicalHistory();

        // Define a data atual como valor padrão
        $model->date = date('Y-m-d');

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Registo de histórico clínico criado com sucesso.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
            // Garante que a data padrão seja mantida se o formulário não for postado
            if (empty($model->date)) {
                 $model->date = date('Y-m-d');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Histórico clínico atualizado com sucesso.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Registo de histórico clínico removido com sucesso.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = MedicalHistory::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('A página solicitada não existe.');
    }
}