<?php

namespace app\models;

use Yii;
use yii2mod\user\models\UserModel as User;

/**
 * This is the model class for table "user_social".
 *
 * @property int $id
 * @property string|null $twitter
 * @property int|null $user_id
 *
 * @property User $user
 */
class UserSocial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_social';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['twitter'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'twitter' => Yii::t('app', 'Twitter'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserSocialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserSocialQuery(get_called_class());
    }
}
