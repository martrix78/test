<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use \app\models\User;

class SiteController extends Controller {

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only'  => ['logout', 'profile'],
				'rules' => [
					[
						'actions' => ['logout', 'profile'],
						'allow'   => true,
						'roles'   => ['@'],
					],
				],
			],
			'verbs' => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex() {
		return $this->render('index');
	}

	/**
	 * Login action.
	 *
	 * @return string
	 */
	public function actionLogin() {

		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->sendCode()) {
			Yii::$app->session->setFlash('success', 'На ваш емейл выслано письмо с ссылкой авторизации');
			return $this->goBack();
		}
		return $this->render('login', [
					'model' => $model,
		]);
	}

	/**
	 * Авторизация по коду
	 * @param string $code
	 */
	public function actionAuth($code) {

		if ($code and $user = User::findByCode($code) and User::login($user)) {
			Yii::$app->session->setFlash('success', 'Вы авторизованы');
			return $this->redirect(['/site/profile']);
		} else {
			Yii::$app->session->setFlash('danger', 'Ошибка авторизации');
		}

		return $this->goHome();
	}

	/**
	 * Личный кабинет
	 * @return string
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionProfile() {
		if ($model = User::findOne(Yii::$app->user->getId())) {
			if ($model->load(Yii::$app->request->post()) and $model->save()) {
				Yii::$app->session->setFlash('success', 'Данные сохранены');
				return $this->goHome();
			}

			return $this->render('profile', ['model' => $model]);
		} else {
			throw new \yii\web\NotFoundHttpException;
		}
	}

	/**
	 * Logout action.
	 *
	 * @return string
	 */
	public function actionLogout() {
		Yii::$app->user->logout();
		return $this->goHome();
	}

}
