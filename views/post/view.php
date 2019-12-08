<?php
use yii\helpers\Html;
?>
<?php if($model->image) : ?>
    <img src="/uploads/<?=$model->image?>" class="card-img-top" alt="<?=$model->title?>">
<?php else : ?>
    <img src="https://via.placeholder.com/1800x600?text=No Image" class="card-img-top" alt="Placeholder">
<?php endif ?>
<h1><?=$model->title?></h1>
<p>By <?=Html::a($model->user->username, ['/post/','uid' => $model->author])?> on <?=Yii::$app->formatter->asDate($model->date_created)?></p>
<p><?=($model->author==Yii::$app->user->id?Html::a('Edit', ['/post/update', 'id' => $model->id]):'')?></p>
<div>
    <?=$model->content?>
</div>
