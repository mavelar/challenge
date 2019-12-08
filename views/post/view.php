<?php
use yii\helpers\Html;
?>
<h1><?=$model->title?></h1>
<p>By <?=Html::a($model->user->username, ['/post/','author' => $model->author])?> on <?=Yii::$app->formatter->asDate($model->date_created)?></p>
<div>
    <?=$model->content?>
</div>
