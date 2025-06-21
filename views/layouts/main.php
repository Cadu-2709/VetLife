<?php
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
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
        $userRole = Yii::$app->user->identity->role;
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Agendamentos', 'url' => ['/scheduling/index']],
            ['label' => 'Animais', 'url' => ['/animal/index']],
            ['label' => 'Histórico Clínico', 'url' => ['/medical-history/index'], 'visible' => ($userRole === 'admin' || $userRole === 'veterinario')],
            ['label' => 'Clientes', 'url' => ['/client/index'], 'visible' => ($userRole === 'admin' || $userRole === 'recepcionista')],
            [
                'label' => 'Administração',
                'visible' => ($userRole === 'admin'),
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
            . Html::submitButton('Logout ('.Yii::$app->user->identity->email.')', ['class' => 'nav-link btn btn-link logout text-white'])
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget(['options' => ['class' => 'navbar-nav ms-auto mb-2 mb-md-0'], 'items' => $menuItems]);
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