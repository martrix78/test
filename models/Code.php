<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "code".
 *
 * @property integer $id
 * @property string $email
 * @property string $code
 */
class Code extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'code'], 'required'],
            [['email'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 255],
        ];
    }

	public function beforeSave($insert) {
		if ($insert) {
			self::deleteAll('email=:email', [':email' => $this->email]);
		}
		return parent::beforeSave($insert);
	}

	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => 'ID',
            'email' => 'Email',
            'code'  => 'Code',
        ];
    }
}
