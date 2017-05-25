<?php

/*
 * @date:2015-05-15
 * @copyright:北京福福科技咨询有限公司
 */
namespace fufudao\weui;
use Yii;
use yii\helpers\VarDumper;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * Description of THtml
 *
 * @author arlent <cy@fufudao.cn>
 */
class Html extends \yii\helpers\BaseHtml{

	/**
     *
     */
    public static $parts = [];

    public static $cellTemplate = "{cellHd}\n{cellBd}\n{cellFt}";
    /**
     * $href 点击跳转链接
     * $img 九宫格显示的图片
     * 
     */
    public static function NineGrids($href="#",$img,$title,$orginalPrice,$nowPrice)
    {   
        if(mb_strlen($title, "UTF-8") > 8){
            $title = mb_substr($title,0,7,'utf-8').'..';
        }
        if(mb_strlen($nowPrice, "UTF-8") > 7){
            $nowPrice = mb_substr($nowPrice,0,6,'utf-8').'..';
        }
        if(mb_strlen($orginalPrice, "UTF-8") > 4){
            $orginalPrice = mb_substr($orginalPrice,0,3,'utf-8').'..';
        }
        if(empty($img))return false;
        $str='';
        $str .="<a href='{$href}' class='weui-grid'>";
        $str .=    '<div class="weui-grid__icon" style="width: 106px;height: 94px;">';
        $str .=        "<img width='10px;' src='{$img}' alt=''>";
        $str .=    '</div>';
        $str .=    "<p class='weui-grid__label'>{$title}</p>";
        $str .=    "<p class='weui-grid__label'>";
        $str .=      "<div style='float:left;'>{$nowPrice}</div>";
        $str .=      "<div style='float:right;'><del>{$orginalPrice}</del></div>";
        $str .=    "</p>";
        $str .='</a>';
        // var_dump($str);
        return $str;
    }
    /**
     *结合template输出cell
     * 
     */
    public static function renderCell($content = null, $options=[])
    {
        if ($content === null) {
        	$content = self::$cellTemplate;
            if (!isset(self::$parts['{cellHd}'])) {
                $content = str_replace("{cellHd}", '', $content);
            }
            if (!isset(self::$parts['{cellBd}'])) {
                $content = str_replace("{cellBd}", '', $content);
            }
            if (!isset(self::$parts['{cellFt}'])) {
                $content = str_replace("{cellFt}", '', $content);
            }
            $content = strtr($content, self::$parts);
        } elseif (!is_string($content)) {
            $content = (string)$content;
        }
        return self::cell($content,$options);
    }





    /*cells的标题*/
	public static function cellsTitle($content, $options=[]){
		$defOptions = ['class'=>"weui-cells__title"];
		return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
	}

	/*cells begin and end*/
	public static function beginCells($options=[]){
		$defOptions = ['class'=>"weui-cells"];
		return self::beginTag('div', ArrayHelper::merge($defOptions,$options));
	}
	public static function endCells(){
		return self::endTag('div');
	}
	// cell
	public static function cell($content, $options=[])
    {
    	$defOptions = ['class'=>"weui-cell"];
		return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
    }
    public static function cellGreenCode($content, $options=[])
    {
        $defOptions = ['class'=>"weui-cell weui-cell_vcode"];
        return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
    }
    // weui-cell__hd
	public static function cellHd($content, $options=[])
    {
    	$defOptions = ['class'=>"weui-cell__hd"];
		return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
    }
    // weui-cell__bd
	public static function cellBd($content, $options=[])
    {
    	$defOptions = ['class'=>"weui-cell__bd"];
		return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
    }
    // weui-cell__ft
	public static function cellFt($content, $options=[])
    {
    	$defOptions = ['class'=>"weui-cell__ft"];
		return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
    }

	// 提交按钮外层
    public static function btnArea($content, $options=[])
    {
    	$defOptions = ['class'=>"weui-btn-area"];
		return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
    }
    /*
		提交按钮
    */
    public static function weuiSubmitButton($content = 'Submit', $options = [])
    {
        $defOptions = ['class'=>"weui-btn weui-btn_primary",'type'=>'submit'];
        return self::btnArea(static::button($content, ArrayHelper::merge($defOptions,$options)));
    }

    //uploader
    public static function weuiUploader($content, $options=[])
    {
    	$defOptions = ['class'=>"weui-uploader"];
		return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
    }
    public static function weuiUploaderHd($content, $options=[])
    {
    	$defOptions = ['class'=>"weui-uploader__hd"];
		return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
    }
    public static function weuiUploaderInfo($content, $options=[])
    {
    	$defOptions = ['class'=>"weui-uploader__info"];
		return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
    }
    public static function weuiUploaderBd($content, $options=[])
    {
    	$defOptions = ['class'=>"weui-uploader__bd"];
		return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
    }

    public static function weuiUploaderFiles($content='', $options=[])
    {
    	$defOptions = ['class'=>"weui-uploader__files", 'id'=>'uploaderFiles'];
		return self::tag('ul', $content, ArrayHelper::merge($defOptions,$options));
    }
    public static function weuiUploaderFilesLi($content='', $options=[])
    {
    	$defOptions = ['class'=>"weui-uploader__file"];
		return self::tag('li', $content, ArrayHelper::merge($defOptions,$options));
    }
    public static function weuiUploaderInputbox($content, $options=[])
    {
    	$defOptions = ['class'=>"weui-uploader__input-box"];
		return self::tag('div', $content, ArrayHelper::merge($defOptions,$options));
    }

    //uploader 自动上传组件
    public static function autoUploader($titleOptions=[], $count=[], $for='', $img_m=[])
    {
    	//uploaderHd
    	//title
    	$defaultTitleOptions = ['class'=>'weui-uploader__title'];
    	$titleOptionsToStr = $titleOptions = array_merge($defaultTitleOptions, $titleOptions);
    	if(isset($titleOptionsToStr['content'])){
    		unset($titleOptionsToStr['content']);
    	}
    	$uploaderHd = '<p '.(self::AryToStr($titleOptionsToStr)).'>'.(isset($titleOptions['content'])?$titleOptions['content']:'').'</p>';
    	//title info
    	$existNumber = 0;
    	if(count($img_m) > 0){
			$existNumber = count($img_m);
    	}
    	if(!isset($count['totalNum']) || ($count['totalNum'] < 1)){
    		$count['totalNum'] = 1;
    	}
    	$countStr = '<span id="uploadCount">'.$existNumber.'</span>/<span id="uploadMaxCount">'.$count['totalNum'].'</span>';
    	$uploaderHd .= self::weuiUploaderInfo($countStr);

    	//uploaderBd
    	//uploader li
    	$imgLi = '';
    	if(!empty($img_m)){
    		foreach ($img_m as $key => $value) {
    			$imgLi .= self::weuiUploaderFilesLi('', ['data-id'=>($key+1), 'style'=>'background-image: url(/'.$value["file_uri"].');']);
    		}
    	}

    	$uploaderBd = self::weuiUploaderFiles($imgLi);
    	$input = self::input('file', 'name', 'value', ['id'=>'uploaderInput','class'=>'weui-uploader__input', 'for'=>$for,'accept'=>'image/*','capture'=>'camera','multiple'=>true]);
    	$uploaderBd .= self::weuiUploaderInputbox($input);

    	$content = self::weuiUploaderHd($uploaderHd);
    	$content .= self::weuiUploaderBd($uploaderBd);
		return self::weuiUploader($content);
    }


    //标签属性数组转字符串
   	public static function AryToStr($array)
   	{
   		$str = '';
   		if(!empty($array) && is_array($array)){
   			foreach ($array as $k => $v) {
	    		$str.=($k.'="'.$v.'" ');
	    	}
   		}
    	return $str;
   	}

    /*
		echo Html::beginCells();

		echo Html::listShow(
			[
				'href'=>'/bwechat/site/index'
			], 
			[
				'src'=>'/images/index-user.png', 
				'style'=>'width: 70px;display: block;'
			], 
			[
				'content'=>'p2文字，XXX汽修店'
			], 
			[
				'content'=>'p1文字，电话：18888888888', 
				'style'=>'font-size: 14px;color: #888888;'
			],
			[
				'content'=>'右侧文字',
				'mark'=>true
			]
		);

		echo Html::endCells();

    多结构的list显示
    可配置左侧图标，中间2行文字，右侧箭头与文字
    */
    public static function listShow($AOption=[], $ImgOption=[], $TitleOption=[], $BriefOption=[], $ftOption=[]){
		
		if(empty($ImgOption)){
			$hdContent = '';
		}else{
			$hdContent = self::img(isset($ImgOption['src'])?$ImgOption['src']:'#', $ImgOption);
		}

		$titleAry = $TitleOption;
		if(isset($titleAry['content'])){
			unset($titleAry['content']);
		}		
    	$bdContent = '<p '.(self::AryToStr($titleAry)).'>'.(isset($TitleOption['content'])?$TitleOption['content']:'').'</p>';

    	$briefAry = $BriefOption;
		if(isset($briefAry['content'])){
			unset($briefAry['content']);
		}
    	$bdContent .= '<p '.(self::AryToStr($briefAry)).'>'.(isset($BriefOption['content'])?$BriefOption['content']:'').'</p>';

    	self::$parts['{cellHd}'] = self::cellHd($hdContent,['style'=>'position: relative;margin-right: 10px;']);
    	self::$parts['{cellBd}'] = self::cellBd($bdContent);

    	if(empty($ftOption)){
    		self::$parts['{cellFt}'] = self::cellFt('<p></p>');
    	}else{
    		$ftAry = $ftOption;
    		if(isset($ftAry['content'])){
				unset($ftAry['content']);
			}
    		self::$parts['{cellFt}'] = self::cellFt('<p '.(self::AryToStr($ftAry)).'>'.(isset($ftOption['content'])?$ftOption['content']:'').'</p>');
    	}

    	$style['style'] = 'border-bottom:1px solid #d9d9d9;';
    	if(isset($ftOption['mark']) && ($ftOption['mark']===true)){
    		$style['class'] = 'weui-cell weui-cell_access';
    	}else{
    		$style['class'] = 'weui-cell';
    	}

    	$content = self::renderCell(null, $style);

    	$defAOptions = [];
    	
    	return self::a($content, isset($AOption['href'])?$AOption['href']:'#', ArrayHelper::merge($defAOptions,$AOption));
    }

    public static function isChecked($value){
		$checked = '';
		if(isset($value['checked']) && $value['checked']==='checked'){
			$checked = ' checked="checked" ';
		}
		return $checked;
	}

    //微信radio  //暂有bug 点击边缘才能触发事件
	public static function activeWxRadioList($model, $attribute, $items, $options=[])
    {

        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        $selection = isset($options['value']) ? $options['value'] : static::getAttributeValue($model, $attribute);

        if (!array_key_exists('unselect', $options)) {
            $options['unselect'] = '';
        }
        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }


    	$html='<div class="weui-cells weui-cells_radio">';

        foreach ($items as $key => $value) {
            $html.='<label class="weui-cell weui-check__label" for="'.$name.'_'.$key.'">
                                <div class="weui-cell__bd">'.$value.'</div>
                                <div class="weui-cell__ft">
                                    <input type="radio" class="weui-check" name="'.$name.'" id="'.$name.'_'.$key.'" value="'.$key.'" >
                                    <span class="weui-icon-checked"></span>
                                </div>
                            </label>';

        }


        $html.='</div>';
        return $html;

// <div class="weui-cell__ft"> <input required="" type="radio" class="weui-check" name="sex" value="male" id="r1" tips="请选择性别"> <span class="weui-icon-checked"></span> </div>



    	
   //  	if(!empty($list)){
			// foreach ($list as $k => $value) {
			// 	$checked = self::isChecked($value);
	  //   		$html.='<label class="weui-cell weui-check__label" for="'.$name.'_'.$k.'">
	  //       					<div class="weui-cell__bd">
	  //           					<p>'.$value['label'].'</p>
			// 			        </div>
			// 			        <div class="weui-cell__ft">
			// 			            <input type="radio" class="weui-check" name="'.$name.'" id="'.$name.'_'.$k.'" '.$checked.' >
			// 			            <span class="weui-icon-checked"></span>
			// 			        </div>
   //  						</label>';
	  //   	}
   //  	}

    	
    }

    /*
	 *	@param string $name 
     * @param array $list 
     * @param string $title
		echo Html::cellsCheckbox('checkboxName',[
            [
                'label'=>'选项1',
                'checked'=>'checked'
            ],
            [
                'label'=>'选项2',
                'checked'=>''
            ],
            [
                'label'=>'选项3',
            ],
            [
                'label'=>'选项4',
                'checked'=>'checked'
            ],
            
        ],'多选框标题'); 
    */
    public static function cellsCheckbox($name, $list=[], $title='')
    {
    	$html='';
    	if(!empty($title)){
    		$html = self::cellsTitle($title);
    	}
    	$html.='<div class="weui-cells weui-cells_checkbox">';
    	if(!empty($list)){
			foreach ($list as $k => $value) {
				$checked = self::isChecked($value);
	    		$html.='<label class="weui-cell weui-check__label" for="'.$name.'_'.$k.'">
	        					<div class="weui-cell__hd">
	            					<input type="checkbox" class="weui-check" name="'.$name.'" id="'.$name.'_'.$k.'" '.$checked.'>
                    				<i class="weui-icon-checked"></i>
						        </div>
						        <div class="weui-cell__bd">
						            <p>'.$value['label'].'</p>
						        </div>
    						</label>';
	    	}
    	}
    	$html.='</div>';
    	return $html;
    }

    /*返回模型验证错误信息*/
    public static function WeuiTips($model, $attribute, $options = [])
    {
        $attribute = static::getAttributeName($attribute);
        $errorMsg = $model->getFirstError($attribute);
//        var_dump($errorMsg);die;
        return $errorMsg;
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //////////
	public static function dump($var){		
		VarDumper::dump($var, 5, true);
	}

		//添加空格组合功能
	public static function t($category, $message, $params=array(), $source=NULL, $language=NULL) 
	{
		$many = explode('.',$message);
		$text ='';
		foreach($many as $one){
			$text.= Yii::t($category,$one,$params,$source,$language);
		}
		return $text;
	}
	
	/*
	权限链接
	htmlOptions[permission] 权限项目，false不检查权限，默认null，使用Url作为权限item
	*/
	public static function link($text,$url='#',$htmlOptions=array())
	{	
//		if($url!=='')
//			$htmlOptions[0]=$url;
		
		//权限检查
		
		$right = isset($htmlOptions['permission'])?$htmlOptions['permission']:$url;
		if(is_array($right))$right=Url::to($right);
//		echo $right;
		unset($htmlOptions['permission']);
		if( !Yii::$app->user->checkAccessURI($right))return '';
		
//		self::clientChange('click',$htmlOptions);
		return self::a($text,$url,$htmlOptions);
//		return self::tag('a',$htmlOptions,$text);
	}


	
	public static function LabelAndField($model,$attribute,$htmlOptions=array())
	{
	
	if(isset($htmlOptions['for']))
    {
        $for=$htmlOptions['for'];
        unset($htmlOptions['for']);
    }
    else
        $for=self::getInputId ($model, $attribute);
		
    if(isset($htmlOptions['label']))
    {
        if(($label=$htmlOptions['label'])===false)
            return '';
        unset($htmlOptions['label']);
    }
    else
        $label=$model->getAttributeLabel($attribute);
	
	$htmlOptions = array_merge(array(
		'id'=>$for,
		'class'=>'text'),	
		$htmlOptions);

	// self::clientChange('change',$htmlOptions);
	$value='';
	if(isset($htmlOptions['value'])){
		$value = $htmlOptions['value'];
		unset($htmlOptions['value']);
	}else if(isset($htmlOptions['type'])){
		$value = self::getAttributeValue($model,$attribute);
		switch ($htmlOptions['type']){
			case 'date':
				$value = empty($value)?'':date('Y-m-d',strtotime($value));
				break;
			case 'datetime':
				$value = empty($value)?'':date('Y-m-d H:i:s',strtotime($value));
				break;
		}
		unset($htmlOptions['type']);
	}else{
		$value=self::getAttributeValue($model,$attribute);
	}

	return self::tag('label',$label,['for'=>$for]).self::tag('span',self::encode($value),$htmlOptions);
	
	}
	
	/*
	 * 获取_Get请求，如果包含query的数组，优先
	 */
	public static function getParams(){
		$params = Yii::$app->request->getQueryParams();
		if( !empty($params['query'])){
			foreach($params['query'] as $key=>$value){
				$params[$key]= $value;
			}
		}
		return $params;
	}
	
	public static function getUri(){
		return '/'.Yii::$app->requestedRoute;
	}

	/**
	* 时间通用格式转换
	* @param unknown_type $timestr
	* @param unknown_type $format
	* @return string
	*/
	public static function datetime($timestr=null,$format='Y-m-d H:i:s'){
	return empty($timestr)?'':date($format,strtotime($timestr));
	}

	/**
	 * 
	 * @param unknown_type $str 时间字符串
	 * @param unknown_type $return 是否返回 还是直接显示
	 * @return string 返回 Y.m.d格式的日期
	 */
	 public static function time2Ymd($str,$return = false){
		$date=date('Y年m月d日',strtotime($str));
		if($return) return $date;
		else echo $date;
	 }
	 
	 
	/*
	controller->setFlash($mess,$name='flashbox') 
	*/
	public static function FlashBox($view,$flashName='flashbox',$divId='flashmessage',$jsCallback='') {
		$ret = '';
		if (Yii::$app->session->hasFlash($flashName)){
			$ret = '<div id="'.$divId.'" class="msgbox">'.Yii::$app->session->getFlash($flashName,null,true).'</div>'; 
		   $view->registerJs(
			 '$(".msgbox").animate({opacity: 0}, 2000).fadeOut(500);'.$jsCallback,
			 yii\web\View::POS_READY
		   );
		}
		// else{echo 'none msg';}
		return $ret;
	}
	 
	/**
	 * 
	 * @param array $htmlOptions
	 * @param string $url url 优先 htmlOptions['href']
	 * @return bool
	 */
	protected static function checkAccessForHtmlOptions($htmlOptions,$url=null){
		//权限检查
		$right = FALSE;
		if( isset($htmlOptions['permission']) ){
			
			if($htmlOptions['permission'] === FALSE){
				$right = TRUE;
			}else{
				$right = Yii::$app->user->can($htmlOptions['permission']);
			}
			unset($htmlOptions['permission']);
		}else{
			if( empty($url) && isset($htmlOptions['href']))$url=$htmlOptions['href'];
			$right = Yii::$app->user->checkAccessURI($url);
		}
		return $right;
	}
	////////////////跳转的button，第二个参数必须传入href参数，第三个参数必须传入视图对象
    public static function Weuibutton($content = 'Button', $options = [],$viewObject=NULL)
    {   
        
        if(isset($options['href']) && isset($viewObject)){
            if(empty($options['id'])){
                $id = rand(111111111,999999999);
            }else{
                $id=$options['id'];
            }
            $options = array_merge(['id'=>$id],$options);
        $viewObject->registerJs('var href=document.getElementById("'.$id.'").getAttribute("href");document.getElementById("'.$id.'").onclick = function(e){window.location.href=href;};',yii\web\View::POS_END);
        }
        $options = array_merge(['href'=>'javascript:;'],$options);
        $options = array_merge(['class'=>'weui-btn'],$options);
        if (!isset($options['type'])) {
            $options['type'] = 'button';
        }
        return static::tag('button', $content, $options);
    }
    public static function area($title,$content,$rows=3,$nowNum='',$maxNum='')
    {
        $str='<div class="weui-cells__title">'.$title.'</div>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <textarea readonly="readonly" class="weui-textarea" placeholder="'.$content.'" rows="'.$rows.'"></textarea>
                        <div class="weui-textarea-counter"><span>'.$nowNum.'</span>'.$maxNum.'</div>
                    </div>
                </div>
            </div>';
        return $str;
    }
}
