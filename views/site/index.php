<?php
    $this->title = 'Personal Blog';
?>
<div class="container">
    <?=$this->render('_articles', [
        'model' => $model,
        'pages' => $pages,
    ])?>
</div>