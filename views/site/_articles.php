<?php
  use yii\helpers\Html;
  use yii\widgets\LinkPager;
?>
<section>
  <?php foreach($model as $post) : ?>
    <div class="card mb-3 border-0">
      <div class="row no-gutters">
        <div class="col-md-2">
          <img src="https://via.placeholder.com/600" class="card-img" alt="Placeholder">
        </div>
        <div class="col-md-10">
          <div class="card-body">
            <h2 class="card-title"><a href="/post/<?=$post->id?>" class="text-decoration-none"><?=$post->title?></a></h2>
            <p class="card-text"><?=$post->excerpt?></p>
            <p class="card-text font-weight-light">Posted by <a href="/author"><?=$post->user->username?></a> on <?=Yii::$app->formatter->asDate($post->date_created)?> <?=($post->author==Yii::$app->user->id?Html::a('Edit', ['/post/update', 'id' => $post->id]):'')?></p>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>

  <?=LinkPager::widget([
    'pagination' => $pages,
  ]);?>
</section>  