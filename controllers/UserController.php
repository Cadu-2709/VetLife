<?php

namespace app\controllers;

use app\models\User;
use app\models\UserSearch; // Lembre-se de criar este ficheiro com o Gii
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class UserController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

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
        // Atributo virtual para receber a senha do formulário
        $model->password = ''; 

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Define a senha hasheada antes de salvar
                $model->setPassword($model->password);
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Utilizador criado com sucesso.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->password = '';

        if ($this->request->isPost && $model->load($this->request->post())) {
             // Só atualiza a senha se uma nova for fornecida
            if (!empty($model->password)) {
                $model->setPassword($model->password);
            }
            if($model->save()){
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
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('A página solicitada não existe.');
    }
}