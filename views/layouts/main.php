<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use app\helpers\AuthHelper;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => 'VetLife',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top'],
    ]);

    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Agendamentos', 'url' => ['/scheduling/index'], 'visible' => AuthHelper::can('scheduling.index')],
            ['label' => 'Animais', 'url' => ['/animal/index'], 'visible' => AuthHelper::can('animal.index')],
            ['label' => 'Histórico Clínico', 'url' => ['/medical-history/index'], 'visible' => AuthHelper::can('medical-history.index')],
            ['label' => 'Clientes', 'url' => ['/client/index'], 'visible' => AuthHelper::can('client.index')],
            [
                'label' => 'Administração',
                'visible' => AuthHelper::isAdmin(),
                'items' => [
                     ['label' => 'Serviços', 'url' => ['/service/index']],
                     ['label' => 'Veterinários', 'url' => ['/veterinarian/index']],
                     ['label' => 'Utilizadores', 'url' => ['/user/index']],
                     '<div class="dropdown-divider"></div>',
                     ['label' => 'Status de Agendamento', 'url' => ['/scheduling-status/index']],
                ],
            ],
        ];
        $menuItems[] = '<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton('Logout (' . Yii::$app->user->identity->email . ' - ' . AuthHelper::getCurrentRoleName() . ')', ['class' => 'nav-link btn btn-link logout text-white'])
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container" style="padding-top: 70px;">
        <?= !empty($this->params['breadcrumbs']) ? Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) : '' ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; VetLife <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>