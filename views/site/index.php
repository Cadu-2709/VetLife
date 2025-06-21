<?php

/** @var yii\web\View $this */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'VetLife - Dashboard';
$user = Yii::$app->user->identity;
?>
<div class="site-index">

    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Bem-vindo(a) ao VetLife!</h1>
            <p class="fs-5 fw-light text-muted">Sistema de Gestão para Clínica Veterinária.</p>
            <p>Utilizador logado: <strong><?= Html::encode($user->email) ?></strong></p>
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <h2>Agendamentos</h2>
                <p>Veja a agenda do dia, crie novos agendamentos e gira o fluxo de atendimento da clínica.</p>
                <p><?= Html::a('Gerir Agendamentos &raquo;', ['/scheduling/index'], ['class' => 'btn btn-outline-secondary']) ?></p>
            </div>
            <div class="col-lg-4 mb-3">
                <h2>Clientes e Animais</h2>
                <p>Consulte a ficha dos seus clientes, registe novos tutores e os seus respetivos animais de estimação.</p>
                 <p><?= Html::a('Gerir Clientes &raquo;', ['/client/index'], ['class' => 'btn btn-outline-secondary']) ?></p>
                 <p><?= Html::a('Gerir Animais &raquo;', ['/animal/index'], ['class' => 'btn btn-outline-secondary mt-2']) ?></p>
            </div>
            <div class="col-lg-4 mb-3">
                <h2>Administração</h2>
                <p>Gira os serviços oferecidos pela clínica, a equipa de veterinários e os utilizadores do sistema.</p>
                <p><?= Html::a('Gerir Serviços &raquo;', ['/service/index'], ['class' => 'btn btn-outline-secondary']) ?></p>
                <p><?= Html::a('Gerir Veterinários &raquo;', ['/veterinarian/index'], ['class' => 'btn btn-outline-secondary mt-2']) ?></p>
                <p><?= Html::a('Gerir Utilizadores &raquo;', ['/user/index'], ['class' => 'btn btn-outline-secondary mt-2']) ?></p>
            </div>
        </div>

    </div>
</div>
