# yii2-weui


WeUI for Yii 2
======================

为Yii2封装weui组件,让微信开发更简单

本组件为车卡通微信会员管理系统而做,

[![项目主页]https://github.com/fufudao/yii2-weui](https://github.com/fufudao/yii2-weui)]
[![系统主页]http://www.chekatong.cn](http://www.chekatong.cn)]

author
------------
fufudao
anu-zhang
nuowei000

Installation
------------

### Install With Composer

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require fufudao/yii2-weui "~1.0"

or for the dev-master

```
php composer.phar require fufudao/yii2-weui "1.x-dev"
```

Or, you may add

```
"fufudao/yii2-weui": "~1.0"
```

to the require section of your `composer.json` file and execute `php composer.phar update`.

Example
------------
use fufudao\weui\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use fufudao\weui\ActiveForm;


<?php $form = ActiveForm::begin([
	'method'=>'GET',
	'action'=> Html::getUri(),
	]); ?>

<?php
echo $form->cells('title');
echo $form->beginCells(['class'=>['weui-cells_form']
]);
echo $form->field($searchModel,'cardNO')->textInput(['maxlength'=>true,'required'=>true,'pattern'=>"REG_IDNUM",'placeholder'=>"输入你的身份证号码",'emptytips'=>"请输入身份证号码",'notmatchtips'=>"请输入正确的身份证号码"])->label('发发');

echo $form->endCells();
?>
<span class="action">
<?= Html::submitButton(Html::t('sys','query'),['class'=>'button white']);?>
</span>
<?php ActiveForm::end() ?>
