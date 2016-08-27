<?php

/**
 * шаблон авторизации
 *
 * @author Andrew Russkin <andrew.russkin@gmail.com>
 */
use yii\helpers\Html;
use yii\helpers\Url;
$link = Url::toRoute(['site/auth', 'code' => $code],true);
?>
<div>
	Ваша ссылка авторизации: <?= Html::a($link, $link)?>
</div>



