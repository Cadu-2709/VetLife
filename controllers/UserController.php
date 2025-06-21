<?php
namespace app\controllers;

use app\models\User;
use app\models\UserSearch;
use yii\web\NotFoundHttpException;
use Yii;

class UserController extends BaseController
{
    /**
     * @inheritdoc
     */
    protected $permissions = [
        '*' => 'admin', // Todas as ações requerem role admin
    ];

    /**
     * @inheritdoc
     */
    protected $customErrorMessages = [
        'index' => 'Apenas administradores podem visualizar a lista de usuários do sistema.',
        'view' => 'Apenas administradores podem visualizar detalhes de usuários.',
        'create' => 'Apenas administradores podem criar novos usuários no sistema.',
        'update' => 'Apenas administradores podem editar informações de usuários.',
        'delete' => 'Apenas administradores podem remover usuários do sistema.',
    ];

    public function actionIndex()
    {
        $searchModel = new UserSearch();
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
        $model = new User();
        $model->scenario = 'create';
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->setPassword($model->password);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Utilizador criado com sucesso.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post())) {
            if (!empty($model->password)) {
                $model->setPassword($model->password);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Utilizador atualizado com sucesso.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Utilizador removido com sucesso.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('A página solicitada não existe.');
    }
}