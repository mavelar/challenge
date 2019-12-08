<?php

namespace app\controllers;

use Yii;
use yii\data\Pagination;
use app\models\Post;
use app\models\ImageForm;
use yii\web\UploadedFile;
use yii\web\Response;

class PostController extends \yii\web\Controller
{
    public function beforeAction($action)
    {            
        if ($action->id == 'upload') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
}

    public function actionCreate()
    {
        $this->layout = 'page';
        $model = new Post;
        $post = Yii::$app->request->post();

        if($post) {
            try {
                if($model->load($post)) {
                    if (!$model->save()) {
                        return null;
                    }
                }

                return $this->redirect(['/post', 'uid' => $model->author]);
            } catch (\Exception $e) {
                Yii::warning($e->getMessage());
                throw $e;
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionIndex($uid=null)
    {
        $this->layout = 'page';
        $query = Post::find()->orderBy(['date_created' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        
        return $this->render('index', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }

    public function actionUpdate($id)
    {
        $this->layout = 'page';

        $model = Post::findOne($id);
        $post = Yii::$app->request->post();

        if($post) {
            try {
                if($model->load($post)) {
                    if (!$model->save()) {
                        return null;
                    }
                }

                return $this->redirect(['/post', 'uid' => $model->author]);
            } catch (\Exception $e) {
                Yii::warning($e->getMessage());
                throw $e;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $this->layout = 'page';
        $model = Post::findOne($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionUpload() {
        $base_path = Yii::getAlias('@app');
        $web_path = Yii::getAlias('@web');
        $model = new ImageForm();
    
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstanceByName('file');
    
            if ($model->validate()) {
                $model->file->saveAs($base_path . '/web/uploads/' . $model->file->baseName . '.' . $model->file->extension);
            }
        }
    
        // Get file link
        $res = [
            'link' => $web_path . '/uploads/' . $model->file->baseName . '.' . $model->file->extension,
        ];
    
        // Response data
        Yii::$app->response->format = Yii::$app->response->format = Response::FORMAT_JSON;
        return $res;
    }
}
