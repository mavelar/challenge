<?php

namespace app\controllers;

use Yii;
use yii2mod\user\models\UserModel;
use app\models\UserSocial;

class ProfileController extends \yii\web\Controller {
    public function actionDelete() {
        return $this->render('delete');
    }

    public function actionIndex() {
        $this->layout = 'page';

        $model = self::findModel();
        $modelSocial = self::socialProfiles($model->id);
        
        return $this->render('index', [
            'model' => $model,
            'modelSocial' => $modelSocial,
        ]);
    }

    public function actionUpdate()
    {
        $transaction = Yii::$app->getDb()->beginTransaction();

        try {
            $model = self::findModel();
            $post = Yii::$app->request->post();

            if($model->load($post)) {
                if($post['UserModel']['plainPassword']!=='')
                    $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->plainPassword);

                if (!$model->save()) {
                    $transaction->rollBack();

                    return null;
                }
            }

            $modelSocial = self::socialProfiles($model->id);

            if($modelSocial->load($post)) {
                $modelSocial->user_id = $model->id;

                if (!$modelSocial->save()) {
                    $transaction->rollBack();

                    return null;
                }
            }

            $transaction->commit();

            return $this->redirect('/profile');
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::warning($e->getMessage());
            throw $e;
        }

        return $this->render('update');
    }

    private function findModel() {
        return UserModel::findOne(Yii::$app->user->id);
    }

    private function socialProfiles($id) {
        $profile = UserSocial::find()->where(['user_id' => $id])->one();

        if($profile)
            return $profile;
        else
            return new UserSocial;
    }
}
