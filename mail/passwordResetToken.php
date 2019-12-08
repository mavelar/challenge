<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/password-reset', 'token' => $user->password_reset_token]);
?>

<p>Hello <?php echo Html::encode($user->username) ?>,</p>

<p>Follow the link below to reset your password:</p>

<p>x<?php echo Html::a(Html::encode($resetLink), $resetLink) ?></p>