<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii2mod\user\models\UserModel as User;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string|null $image
 * @property string|null $excerpt
 * @property string|null $content
 * @property string|null $date_created
 * @property int|null $author
 *
 * @property User $User
 */
class Post extends ActiveRecord
{
    public function behaviors() {
		return [
			'timestamp' => [
				'class' => '\yii\behaviors\TimestampBehavior',
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['date_created'],
				],
				'value' => function() {
					return date("Y-m-d H:i:s");
				},
			],
			'user' => [
				'class' => '\yii\behaviors\BlameableBehavior',
                'createdByAttribute' => 'author',
                'updatedByAttribute' => null,
			],
		];
	}

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['excerpt', 'content'], 'string'],
            [['date_created'], 'safe'],
            [['author'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'id']],
            [
				'image',
				'image',
				'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
				'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'],
			],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'image' => Yii::t('app', 'Image'),
            'excerpt' => Yii::t('app', 'Excerpt'),
            'content' => Yii::t('app', 'Content'),
            'date_created' => Yii::t('app', 'Date Created'),
            'author' => Yii::t('app', 'Author'),
        ];
    }

    public function upload()
	{
		if ($this->validate()) {
			$imageTmp = $this->image->tempName;
			$imagefile = Image::getImagine()->open($imageTmp);
			$imagePath = Yii::getAlias('@app/web/uploads/');
			$imageName = 'img_'.$this->id.'.'.$this->image->extension;

			Image::thumbnail($imageTmp, 1800, 600)->save($imagePath.$imageName);
            $this->image = $imageName;
            
			$this->save();

			return true;
		} else {
			return false;
		}
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    
    /**
     * {@inheritdoc}
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }
}
