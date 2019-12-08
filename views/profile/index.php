<?php
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;

  $this->title = 'Profile Page';
  $gravatarHash = md5($model->email);
?>

<h1>Profile</h1>

<div class="row">
  <div class="col-9">
    <?php $form = ActiveForm::begin([
        'id' => 'form-profile',
        'action' => '/profile/update',
    ]); ?>
      <?=$form->field($model, 'username')->textInput(['readonly'=> true]) ?>
      <?=$form->field($model, 'email')->textInput() ?>
      <?=$form->field($modelSocial, 'twitter')->textInput() ?>
      <?=$form->field($model, 'plainPassword')->passwordInput() ?>

      <div class="form-group">
        <?php echo Html::submitButton('Update Profile', ['class' => 'btn btn-primary', 'name' => 'update-profile']) ?>
      </div>
    <?php ActiveForm::end(); ?>
  </div>
  <div class="col-3">
    <img src="https://www.gravatar.com/avatar/<?=$gravatarHash?>?s=600" alt="<?=$model->username?>" class="img-fluid img-thumbnail">
  </div>
</div>