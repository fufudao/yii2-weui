<?php 
/**
 * @author Arlent <cy@fufudao.cn>
 * @date 2017-03-16 05:17:30
 * @copyright 北京福福科技咨询有限公司
 */
namespace fufudao\weui;
use fufudao\weui\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ActiveForm extends \yii\widgets\ActiveForm
{
	public $fieldClass = 'fufudao\weui\ActiveField';
	public $enableClientValidation=false;
	public $options = ['id'=>'form'];	


    public function Cells($content = '', $options = []){
		$defOptions = ['class'=>"weui-cells__title"];
		
		return Html::tag('div', $content, ArrayHelper::merge($defOptions,$options));
	}
	
	public function beginCells($options = []){
		$defOptions = ['class'=>['weui-cells']];
		return Html::beginTag('div', ArrayHelper::merge($defOptions,$options));
	}
	public function endCells(){
		return Html::endTag('div');
	}
        
    public function init()
    {   
        assets\WeUIAsset::register($this->view);
        parent::init();
    }

	 /**
     * Runs the widget.
     * This registers the necessary JavaScript code and renders the form close tag.
     * @throws InvalidCallException if `beginField()` and `endField()` calls are not matching.
     */
    public function run()
    {
        if (!empty($this->_fields)) {
            throw new InvalidCallException('Each beginField() should have a matching endField() call.');
        }

        $content = ob_get_clean();
        echo Html::beginForm($this->action, $this->method, $this->options);
        echo $content;


        if ($this->enableClientScript) {
            $id = $this->options['id'];
            $options = Json::htmlEncode($this->getClientOptions());
            $attributes = Json::htmlEncode($this->attributes);
            $view = $this->getView();
            // ActiveFormAsset::register($view);
            // $view->registerJs("jQuery('#$id').yiiActiveForm($attributes, $options);");
        }

        echo Html::endForm();
    }
}


 ?>