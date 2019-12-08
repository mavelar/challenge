<?php
    use yii\bootstrap4\Nav;
    use yii\bootstrap4\NavBar;

    $items = [
        ['label' => 'Login', 'url' => ['/login']],
        ['label' => 'Signup', 'url' => ['/signup']],
    ];

    if(!Yii::$app->user->isGuest) {
        $items = [
            ['label' => 'New Post', 'url' => ['/post/create']],
            ['label' => 'My Posts', 'url' => ['/post','uid' => Yii::$app->user->id]],
            ['label' => 'Profile', 'url' => ['/profile']],
            ['label' => 'Logout', 'url' => ['/logout'], 'linkOptions' => ['data-method' => 'post']],
        ];
    }
?>

<?php NavBar::begin([
    'brandLabel' => '<img src="/img/logo.png" width="30" height="30">',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-light bg-light',
    ],
]) ?>

<?=Nav::widget([
    'options' => ['class' => 'navbar-nav ml-auto mt-2 mt-lg-0'],
    'items' => $items,
]) ?>

<?php NavBar::end();?>