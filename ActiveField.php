<?php
/**
 * @author Arlent <cy@fufudao.cn>
 * @date 2017-03-16 05:17:30
 * @copyright 北京福福科技咨询有限公司
 */
namespace fufudao\weui;

// use Yii;
use yii\helpers\ArrayHelper;
use fufudao\weui\Html;
use wms\modules\mobile\models\SysUpload;

class ActiveField extends \yii\widgets\ActiveField
{
	public $options = ['class' => 'weui-cell'];

    /**
     * @var string the template that is used to arrange the label, the input field, the error message and the hint text.
     * The following tokens will be replaced when [[render()]] is called: `{label}`, `{input}`, `{footer}`.
     */
    public $template = "<div class=\"weui-cell__hd\">{label}</div><div class=\"weui-cell__bd\">{input}</div><div class=\"weui-cell__ft\">{footer}</div>{error}";
    /**
     * @var array the default options for the input tags. The parameter passed to individual input methods
     * (e.g. [[textInput()]]) will be merged with this property when rendering the input tag.
     *
     * If you set a custom `id` for the input element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $inputOptions = ['class' => 'weui-input'];
    public $textAreaOptions=['class'=>'weui-textarea'];
    public $selectOptions = ['class' => 'weui-select'];
    /**
     * @var array the default options for the error tags. The parameter passed to [[error()]] will be
     * merged with this property when rendering the error tag.
     * The following special options are recognized:
     *
     * - `tag`: the tag name of the container element. Defaults to `div`. Setting it to `false` will not render a container tag.
     *   See also [[\yii\helpers\Html::tag()]].
     * - `encode`: whether to encode the error output. Defaults to `true`.
     *
     * If you set a custom `id` for the error element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $errorOptions = ['class' => 'weui-cell_warn'];
    /**
     * @var array the default options for the label tags. The parameter passed to [[label()]] will be
     * merged with this property when rendering the label tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $labelOptions = ['class' => 'weui-label'];
    /**
     * @var array the default options for the hint tags. The parameter passed to [[hint()]] will be
     * merged with this property when rendering the hint tag.
     * The following special options are recognized:
     *
     * - `tag`: the tag name of the container element. Defaults to `div`. Setting it to `false` will not render a container tag.
     *   See also [[\yii\helpers\Html::tag()]].
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $hintOptions = ['class' => 'hint-block'];
    
    public $tipsOptions = ['class' => 'weui-toptips weui-toptips_warn', 'style'=>'display:block'];




    /**
     * Renders the whole field.
     * This method will generate the label, error tag, input tag and hint tag (if any), and
     * assemble them into HTML according to [[template]].
     * @param string|callable $content the content within the field container.
     * If `null` (not set), the default methods will be called to generate the label, error tag and input tag,
     * and use them as the content.
     * If a callable, it will be called to generate the content. The signature of the callable should be:
     *
     * ```php
     * function ($field) {
     *     return $html;
     * }
     * ```
     *
     * @return string the rendering result.
     */
    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{input}'])) {
                $this->textInput();
            }
            if (!isset($this->parts['{label}'])) {
                $this->label();
            }
            if (!isset($this->parts['{footer}'])) {
                $this->footer();
            }
            if (!isset($this->parts['{error}'])) {
                $this->error();
            }
            if (!isset($this->parts['{hint}'])) {
                $this->hint(null);
            }
            $content = strtr($this->template, $this->parts);
        } elseif (!is_string($content)) {
            $content = call_user_func($content, $this);
        }

        return $this->begin() . "\n" . $content . "\n" . $this->end();
    }	
    
    
    /**
     * Generates a tag that contains the first validation error of [[attribute]].
     * Note that even if there is no validation error, this method will still return an empty error tag.
     * @param array|false $options the tag options in terms of name-value pairs. It will be merged with [[errorOptions]].
     * The options will be rendered as the attributes of the resulting tag. The values will be HTML-encoded
     * using [[Html::encode()]]. If this parameter is `false`, no error tag will be rendered.
     *
     * The following options are specially handled:
     *
     * - `tag`: this specifies the tag name. If not set, `div` will be used.
     *   See also [[\yii\helpers\Html::tag()]].
     *
     * If you set a custom `id` for the error element, you may need to adjust the [[$selectors]] accordingly.
     * @see $errorOptions
     * @return $this the field object itself.
     */
    public function error($options = [])
    {
        if ($options === false) {
            $this->parts['{error}'] = '';
            return $this;
        }
        $errorMsg = Html::error($this->model, $this->attribute, $options);
        if($errorMsg==='<div></div>'){
            $this->parts['{error}'] = '';
        }else{
            $this->options['class'] .= (' '.$this->errorOptions['class']);
            $this->options['onclick'] = 'removeTipsElement("errorShow")';
            $this->parts['{error}'] = '<div class="weui-toptips weui-toptips_warn errorShow " style="display:block">'.$errorMsg.'</div>';
        }
        return $this;
    }

    /**
     * Renders the hint tag.
     * @param string|bool $content the hint content.
     * If `null`, the hint will be generated via [[Model::getAttributeHint()]].
     * If `false`, the generated field will not contain the hint part.
     * Note that this will NOT be [[Html::encode()|encoded]].
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the hint tag. The values will be HTML-encoded using [[Html::encode()]].
     *
     * The following options are specially handled:
     *
     * - `tag`: this specifies the tag name. If not set, `div` will be used.
     *   See also [[\yii\helpers\Html::tag()]].
     *
     * @return $this the field object itself.
     */
    public function footer($content="", $options = [])
    {
        if(isset($options['required'])){
             $this->parts['{footer}']='<i class="weui-icon-warn"></i>{footer}';
        }
        if ($content === false) {
            $this->parts['{footer}'] = '';
            return $this;
        }

        // $options = array_merge($this->hintOptions, $options);
        if ($content !== null) {
            $options['footer'] = $content;
        }
        // $this->parts['{footer}'] = Html::activeHint($this->model, $this->attribute, $options);
        $this->parts['{footer}'] = $content;

        return $this;
    }
	// public function footer($content="", $options = [])
 //    {
 //        if(isset($options['required'])){
 //             $this->parts['{footer}']='<i class="weui-icon-warn"></i>{footer}';
 //        }
 //        if ($content === false) {
 //            $this->parts['{footer}'] = '';
 //            return $this;
 //        }

 //        // $options = array_merge($this->hintOptions, $options);
 //        if ($content !== null) {
 //            $options['footer'] = $content;
 //        }
 //        // $this->parts['{footer}'] = Html::activeHint($this->model, $this->attribute, $options);
 //        $this->parts['{footer}'] = $content;

 //        return $this;
 //    }
	    /**
     * Returns the JS options for the field.
     * @return array the JS options.
     */
    protected function getClientOptions()
    {
        $attribute = Html::getAttributeName($this->attribute);
        if (!in_array($attribute, $this->model->activeAttributes(), true)) {
            return [];
        }

        $clientValidation = $this->isClientValidationEnabled();
        $ajaxValidation = $this->isAjaxValidationEnabled();

        if ($clientValidation) {
            $validators = [];
            foreach ($this->model->getActiveValidators($attribute) as $validator) {
                /* @var $validator \yii\validators\Validator */
                // $js = $validator->clientValidateAttribute($this->model, $attribute, $this->form->getView());
                // if ($validator->enableClientValidation && $js != '') {
                    // if ($validator->whenClient !== null) {
                        // $js = "if (({$validator->whenClient})(attribute, value)) { $js }";
                    // }
                    // $validators[] = $js;
                // }
            }
        }

        if (!$ajaxValidation && (!$clientValidation || empty($validators))) {
            return [];
        }

        $options = [];

        $inputID = $this->getInputId();
        $options['id'] = Html::getInputId($this->model, $this->attribute);
        $options['name'] = $this->attribute;

        $options['container'] = isset($this->selectors['container']) ? $this->selectors['container'] : ".field-$inputID";
        $options['input'] = isset($this->selectors['input']) ? $this->selectors['input'] : "#$inputID";
        if (isset($this->selectors['error'])) {
            $options['error'] = $this->selectors['error'];
        } elseif (isset($this->errorOptions['class'])) {
            $options['error'] = '.' . implode('.', preg_split('/\s+/', $this->errorOptions['class'], -1, PREG_SPLIT_NO_EMPTY));
        } else {
            $options['error'] = isset($this->errorOptions['tag']) ? $this->errorOptions['tag'] : 'span';
        }

        $options['encodeError'] = !isset($this->errorOptions['encode']) || $this->errorOptions['encode'];
        if ($ajaxValidation) {
            $options['enableAjaxValidation'] = true;
        }
        foreach (['validateOnChange', 'validateOnBlur', 'validateOnType', 'validationDelay'] as $name) {
            $options[$name] = $this->$name === null ? $this->form->$name : $this->$name;
        }

        if (!empty($validators)) {
            $options['validate'] = new JsExpression("function (attribute, value, messages, deferred, \$form) {" . implode('', $validators) . '}');
        }

        if ($this->addAriaAttributes === false) {
            $options['updateAriaInvalid'] = false;
        }

        // only get the options that are different from the default ones (set in yii.activeForm.js)
        return array_diff_assoc($options, [
            'validateOnChange' => true,
            'validateOnBlur' => true,
            'validateOnType' => false,
            'validationDelay' => 500,
            'encodeError' => true,
            'error' => '.help-block',
            'updateAriaInvalid' => true,
        ]);
    }
    
    /*滑动开关*/
    public function switchInput($options=[])
    {
        $options = array_merge($this->inputOptions, $options);
        $opt['class'] = 'weui-cell_switch';
        $this->options['class'] .= ' weui-cell_switch';
        $this->parts['{input}'] = $options['label'];
        $this->parts['{footer}'] = Html::activeInput('checkbox', $this->model, $this->attribute, $options);
        
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        return $this;
    }
    public function noHeaderInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * b端添加产品有例子
     */
    public function textarea($options = [])
    {
        $options = array_merge($this->textAreaOptions, $options);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * b端添加产品有例子
     */
    public function dropDownList($items, $options = [])
    {
        $options = array_merge($this->selectOptions, $options);
        $this->adjustLabelFor($options);
        $this->options['class'] .= ' weui-cell_select';
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);

        return $this;
    }
   


    // 自动上传图片
    public function autoUploaderImg($titleOptions=[], $count=[], $options=[])
    {
        $for = static::getInputId($this->model, $this->attribute);
        $imgStr = $this->model[$this->attribute];
        $img_m = [];
        if(!empty($imgStr)){
            $img_m = SysUpload::findAll(explode(',', $imgStr));
        }
        $html = Html::autoUploader($titleOptions, $count, $for, $img_m);
        $html .= Html::activeHiddenInput($this->model, $this->attribute, $options);
        $this->parts['{input}'] = $html;
        return $this;
    }

    //微信Radio
    public function wxRadioList($items, $options = [])
    {
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        // $this->parts['{input}'] = Html::activeRadioList($this->model, $this->attribute, $items, $options);
        $this->parts['{input}'] = Html::activeWxRadioList($this->model, $this->attribute, $items, $options);

        return $this;
    }


    public function checkbox($options = [], $enclosedByLabel = true)
    {
         if ($enclosedByLabel) {
            $this->parts['{input}'] = Html::activeCheckbox($this->model, $this->attribute, $options);
            $this->parts['{label}'] = '';
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $this->labelOptions = $options['labelOptions'];
                }
            }
            unset($options['labelOptions']);
            $options['label'] = null;
            $this->parts['{input}'] = Html::activeCheckbox($this->model, $this->attribute, $options);
        }
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        return $this;
    }
    
}


 ?>