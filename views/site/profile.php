<?php

/**
 * Description of profile
 *
 * @author Andrew Russkin <andrew.russkin@gmail.com>
 */
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$form = ActiveForm::begin([
	'id'          => 'login-form',
	'options'     => ['class' => 'form-horizontal'],
	'fieldConfig' => [
		'template'     => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
		'labelOptions' => ['class' => 'col-lg-1 control-label'],
	],
]);
?>
	<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
	<div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
	<?= Html::a('Выйти', ['/site/logout'], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>
