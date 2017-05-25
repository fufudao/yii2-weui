<?php
/**
 * @author Arlent <cy@fufudao.cn>
 * @date 2017-03-16 05:17:30
 * @copyright 北京福福科技咨询有限公司
 * Weui前端css,js
 */
namespace fufudao\weui\assets;

use yii\web\AssetBundle;

class WeUIPageAsset extends AssetBundle
{
	public $sourcePath = '@vendor/fufudao/yii2-weui/assets';
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $css = [

    ];
	public $js=[
		'yii2weui.js'
	];
	public $depends=[
		'fufudao\weui\assets\WeUIAsset'
	];
}