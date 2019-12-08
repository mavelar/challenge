<?php
namespace app\models;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * ImageForm is the model behind the upload form.
 */
class ImageForm extends Model
{
	/**
	 * @var UploadedFile|Null file attribute
	 */
	public $file;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['file'], 'file']
		];
	}
}