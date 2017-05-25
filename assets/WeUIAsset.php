<?php
/**
 * @author Arlent <cy@fufudao.cn>
 * @date 2017-03-16 05:17:30
 * @copyright 北京福福科技咨询有限公司
 * Weui前端css
 */
namespace fufudao\weui\assets;

use yii\web\AssetBundle;

class WeUIAsset extends AssetBundle
{
	public $sourcePath = '@bower/weui/dist/style';
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $css = [
		'weui.min.css'
    ];
}