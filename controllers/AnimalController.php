<?php
namespace app\controllers;

use app\models\Animal;
use app\models\AnimalSearch;
use yii\web\NotFoundHttpException;
use Yii;

class AnimalController extends BaseController
{
    /**
     * @inheritdoc
     */
    protected $permissions = [
        'index' => ['admin', 'receptionist', 'veterinarian', 'client'],
        'view' => ['admin', 'receptionist', 'veterinarian', 'client'],
        'create' => ['admin', 'receptionist'],
        'update' => ['admin', 'receptionist'],
        'delete' => ['admin', 'receptionist'],
    ];

    /**
     * @inheritdoc
     */
    protected $customErrorMessages = [
        'index' => 'Você não tem permissão para visualizar a lista de animais.',
        'view' => 'Você não tem permissão para visualizar dados deste animal.',
        'create' => 'Apenas administradores e recepcionistas podem cadastrar novos animais.',
        'update' => 'Apenas administradores e recepcionistas podem editar dados de animais.',
        'delete' => 'Apenas administradores e recepcionistas podem remover animais do sistema.',
    ];

    public function actionIndex()
    {
        $searchModel = new AnimalSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider,]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id),]);
    }

    public function actionCreate()
    {
        $model = new Animal();
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Animal cadastrado com sucesso!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('create', ['model' => $model,]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Dados do animal atualizados com sucesso!');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model,]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Registro do animal foi removido.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Animal::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('A página solicitada não existe.');
    }
}