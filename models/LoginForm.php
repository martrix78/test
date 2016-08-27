<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model {

	public $email;

	/**
	 * @return array the validation rules.
	 */
	public function rules() {
		return [
			[['email'], 'required'],
			['email', 'email'],
			['email', 'trim'],
		];
	}

	/**
	 * Отправка письма с кодом
	 * @return boolean
	 */
	public function sendCode() {
		if ($this->validate()) {
			Yii::$app->mailer->compose('@app/mail/auth',['code' => $this->makeAuthCode()])
			->setTo($this->email)
			->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
			->setSubject('Авторизация на '.Yii::$app->name)
			->send();
			return true;
		}
		return false;
	}


	/**
	 * Создаем код авторизации и пишем его в табличку
	 * @return string авторизационный код
	 */
	public function makeAuthCode(){
		$code = sha1(md5(time().$this->email));

		$model = new Code([
			'email' => $this->email,
			'code'  => $code
		]);
		$model->save();
		return $code;
	}

}
