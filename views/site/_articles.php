<?php
  use yii\helpers\Html;
  use yii\widgets\LinkPager;
?>
<section>
  <?php foreach($model as $post) : ?>
    <div class="card mb-3 border-0">
      <?php if($post->image) : ?>
        <img src="/uploads/<?=$post->image?>" class="card-img-top" alt="<?=$post->title?>">
      <?php else : ?>
        <img src="https://via.placeholder.com/1800x600?text=No Image" class="card-img-top" alt="Placeholder">
      <?php endif ?>
      <div class="card-body">
        <h2 class="card-title"><a href="/post/<?=$post->id?>" class="text-decoration-none"><?=$post->title?></a></h2>
        <p class="card-text"><?=$post->excerpt?></p>
        <p class="card-text font-weight-light">Posted by <?=Html::a($post->user->username, ['/post', 'uid' => $post->author])?> on <?=Yii::$app->formatter->asDate($post->date_created)?></p>
        <p><?=($post->author==Yii::$app->user->id?Html::a('Edit', ['/post/update', 'id' => $post->id]).' | '.Html::a('Delete', ['/post/delete', 'id' => $post->id], ['data-method' => 'post', 'data-confirm' => 'Are you sure to delete this post?', 'class' => 'text-danger']):'')?></p>
      </div>
    </div>
  <?php endforeach ?>

  <?=LinkPager::widget([
    'pagination' => $pages,
  ]);?>
</section>  