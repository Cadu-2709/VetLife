<?php
namespace app\controllers;

use app\models\Client;
use app\models\ClientSearch;
use yii\web\NotFoundHttpException;
use Yii;

class ClientController extends BaseController
{
    /**
     * @inheritdoc
     */
    protected $permissions = [
        '*' => ['admin', 'receptionist'], // Todas as ações requerem admin ou recepcionista
    ];

    /**
     * @inheritdoc
     */
    protected $customErrorMessages = [
        'index' => 'Apenas administradores e recepcionistas podem visualizar a lista de clientes.',
        'view' => 'Apenas administradores e recepcionistas podem visualizar dados de clientes.',
        'create' => 'Apenas administradores e recepcionistas podem cadastrar novos clientes.',
        'update' => 'Apenas administradores e recepcionistas podem editar dados de clientes.',
        'delete' => 'Apenas administradores e recepcionistas podem remover clientes do sistema.',
    ];
    
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
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
        $model = new Client();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Cliente registado com sucesso.');
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
            Yii::$app->session->setFlash('success', 'Dados do cliente atualizados com sucesso.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Cliente removido com sucesso.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('A página solicitada não existe.');
    }
}
