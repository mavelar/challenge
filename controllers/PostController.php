<?php

namespace app\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\data\Pagination;
use app\models\Post;
use app\models\ImageForm;
use app\models\UserSocial;
use yii2mod\user\models\UserModel as User;

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
                    $model->image = UploadedFile::getInstance($model, 'image');
                    
                    if (!$model->save()) {
                        return null;
                    }

                    if(!$model->upload()) {
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

    public function actionDelete($id)
    {
        $model = Post::findOne($id);

        $model->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionIndex($uid=null)
    {
        $this->layout = 'page';
        $query = Post::find()->orderBy(['date_created' => SORT_DESC]);
        $author = null;
        $social = null;

        if($uid) {
            $query->where(['author' => $uid]);

            $author = User::findOne($uid);
            $social = UserSocial::findOne(['user_id' => $uid]);
        } else {
            return $this->redirect('/');
        }

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        
        return $this->render('index', [
            'model' => $model,
            'pages' => $pages,
            'author' => $author,
            'social' => $social,
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
                    $model->image = UploadedFile::getInstance($model, 'image');

                    if (!$model->save()) {
                        return null;
                    }

                    if($model->image) {
                        if(!$model->upload()) {
                            return null;
                        }
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
