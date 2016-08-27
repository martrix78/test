<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'user';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['email',], 'required'],
			[['username', 'email'], 'string', 'max' => 100],
			['email', 'email'],
			['email', 'unique', 'message' => 'Этот емейл занят!'],
			['email', 'trim'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id'       => 'ID',
			'username' => 'Имя пользователя',
			'email'    => 'Email',
		];
	}

	/**
	 * Создание юзера
	 * @param string $email
	 * @return User | boolean
	 */
	public static function createUser($email) {
		$user = new User(['email' => $email]);
		if ($user->save()) {
			return $user;
		}
		return FALSE;
	}

	/**
	 * Поиск по авторизационному коду, если пользователя нет, то создаем его
	 * @param string $code
	 */
	public static function findByCode($code) {
		$user = FALSE;
		if ($codeModel = Code::findOne(['code' => $code])) {
			if (!$user = self::findOne(['email' => $codeModel->email])) {
				$user = self::createUser($codeModel->email);
			}
		}
		return $user;
	}

	/**
	 * Авторизация пользователя
	 * @param \app\models\User $user
	 */
	public static function login(User $user) {
		$result = false;
		if ($result = Yii::$app->user->login($user)) {
			Code::deleteAll('email=:email', [':email' => $user->email]);
		}
		return $result;
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		return static::findOne($id);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		return false;
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username) {
		return static::findOne(['username' => $username]);
	}

	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->getPrimaryKey();
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return null;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return true;
	}

}
