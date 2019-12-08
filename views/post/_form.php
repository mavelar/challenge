<?php
  use yii\widgets\ActiveForm;
  use froala\froalaeditor\FroalaEditorWidget;
  use yii\helpers\Html;
?>

<div class="row">
  <div class="col-12">
    <?php $form = ActiveForm::begin([
        'id' => 'form-post',
    ]); ?>
      <?=$form->field($model, 'title')->textInput() ?>
      <?=$form->field($model, 'excerpt')->textarea() ?>
      <div class="form-group">
        <label for="post-content">Content</label>
        <?=FroalaEditorWidget::widget([
          'model' => $model,
          'attribute' => 'content',
          'clientOptions' => [
            'toolbarInline' => false,
            'theme' => 'dark',
            'language' => 'en_us',
            'imageUploadParam' => 'file', 
            'imageUploadURL' => \yii\helpers\Url::to(['post/upload/'])
          ]
        ]); ?>
      </div>
      <?=$form->field($model, 'image')->fileInput()?>
      <div class="form-group">
        <?php echo Html::submitButton('Post', ['class' => 'btn btn-primary', 'name' => 'post']) ?>
      </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>