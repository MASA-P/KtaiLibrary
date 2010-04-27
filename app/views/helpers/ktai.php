<?php
/**
 * Ktai library, supports Japanese mobile phone sites coding.
 * It provides many functions such as a carrier check to use Referer or E-mail, 
 * conversion of an Emoji, and more.
 *
 * PHP versions 4 and 5
 *
 * Ktai Library for CakePHP1.2
 * Copyright 2009-2010, ECWorks.
 
 * Licensed under The GNU General Public Licence
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright		Copyright 2009-2010, ECWorks.
 * @link			http://www.ecworks.jp/ ECWorks.
 * @version			0.3.0
 * @lastmodified	$Date: 2010-04-27 12:00:00 +0900 (Thu, 27 Apr 2010) $
 * @license			http://www.gnu.org/licenses/gpl.html The GNU General Public Licence
 */

/**
 * includes
 */
if(!class_exists('lib3gk')){
	require_once(VENDORS.'ecw'.DS.'lib3gk.php');
}

/**
 * Ktai helper class for CakePHP1.2
 */
class KtaiHelper extends Helper {
	
	var $helpers = array('Html');
	
	var $_lib3gk = null;
	
	//--------------------------------------------------
	//Configure ktai library
	//--------------------------------------------------
	var $options = array(
		'img_emoji_url' => "/img/emoticons/", 
		
		'output_auto_encoding' => false, 
		'output_auto_convert_emoji' => false, 
		'output_convert_kana' => false, 
	);
	
	//--------------------------------------------------
	//Initialize ktai library
	//--------------------------------------------------
	function beforeRender(){
		
		parent::beforeRender();
		
		$this->options['input_encoding'] = Configure::read('App.encoding');
		$this->options['output_encoding'] = Configure::read('App.encoding');
		
		$this->_lib3gk = Lib3gk::get_instance();
		$this->_lib3gk->_url_callback = array($this, 'url_callback_func');
		$this->_lib3gk->_params = array_merge($this->_lib3gk->_params, $this->options);
		
		$params = Configure::read('Ktai');
		if(!empty($params)){
			$this->_lib3gk->_params = array_merge($this->_lib3gk->_params, $params);
		}
		$this->options = &$this->_lib3gk->_params;
	}
	
	//--------------------------------------------------
	//Shutdown ktai library
	//--------------------------------------------------
	function afterLayout(){
		
		parent::afterLayout();
		
		$view =& ClassRegistry::getObject('view');
		
		if($this->options['output_convert_kana'] != false){
			$view->output = mb_convert_kana(
				$view->output, 
				$this->options['output_convert_kana'], 
				$this->options['input_encoding']
			);
		}
		
		if($this->options['output_auto_convert_emoji']){
			$this->convert_emoji($view->output);
		}else{
			if($this->options['output_auto_encoding'] && 
				($this->options['input_encoding'] != $this->options['output_encoding'])){
				$view->output = mb_convert_encoding(
					$view->output, 
					$this->options['output_encoding'], 
					$this->options['input_encoding']
				);
			}
		}
		
		$this->_lib3gk->shutdown();
	}
	
	//------------------------------------------------
	//URL callback function
	//------------------------------------------------
	function url_callback_func($url){
		return Router::url($url);
	}
	
	//------------------------------------------------
	//HTML img streching.
	//------------------------------------------------
	function image($path, $htmlAttributes = array()){
		
		if(isset($htmlAttributes['width']) && isset($htmlAttributes['height'])){
			$arr = $this->_lib3gk->stretch_image_size($htmlAttributes['width'], $htmlAttributes['height']);
			$htmlAttributes['width']  = $arr[0];
			$htmlAttributes['height'] = $arr[1];
		}
		
		return $this->Html->image($path, $htmlAttributes);
	}
	
	//------------------------------------------------
	//HTML link adding accesskey emoji.
	//------------------------------------------------
	function link($title, $url = null, $htmlAttributes = array(), $confirmMessage = false, $escapeTitle = true){
		
		$str = '';
		
		$this->options['input_encoding'] = $this->_lib3gk->normal_encoding_str($this->options['input_encoding']);
		$this->options['output_encoding'] = $this->_lib3gk->normal_encoding_str($this->options['output_encoding']);
		
		if(isset($htmlAttributes['accesskey'])){
			if(is_numeric($htmlAttributes['accesskey'])){
				$accesskey = intval($htmlAttributes['accesskey']);
				if($accesskey >= 0 && $accesskey < 10){
					if($accesskey == 0){
						$accesskey += 10;
					}
					//
					$binary = true;
					if($this->options['output_encoding'] == KTAI_ENCODING_UTF8){
						$default_code = 0xe6e1;
						if($this->options['output_auto_encoding']){
							$binary = false;
						}
					}else{
						$default_code = 0xf986;
					}
					$str = $this->emoji($accesskey + $default_code, false, null, null, null, $binary);
				}
			}
			
		}
		
		return $str.$this->Html->link($title, $url, $htmlAttributes, $confirmMessage, $escapeTitle);
	}
	
	//------------------------------------------------
	//Create "mailto" link.
	//------------------------------------------------
	function mailto($title, $email, $subject = null, $body = null, $input_encoding = null, $output_encoding = null, $display = true){
		return $this->_lib3gk->mailto($title, $email, $subject, $body, $input_encoding, $output_encoding, $display);
	}
	
	//------------------------------------------------
	//Get this version.
	//------------------------------------------------
	function get_version(){
		return $this->_lib3gk->get_version();
	}
	
	//------------------------------------------------
	//Check carrier.
	//------------------------------------------------
	function get_carrier($user_agent = null, $refresh = false){
		return $this->_lib3gk->get_carrier($user_agent, $refresh);
	}
	function analyze_user_agent($user_agent = null){
		return $this->_lib3gk->analyze_user_agent($user_agent);
	}
	function is_imode(){
		return $this->_lib3gk->is_imode();
	}
	function is_softbank(){
		return $this->_lib3gk->is_softbank();
	}
	function is_vodafone(){
		return $this->_lib3gk->is_vodafone();
	}
	function is_jphone(){
		return $this->_lib3gk->is_jphone();
	}
	function is_ezweb(){
		return $this->_lib3gk->is_ezweb();
	}
	function is_emobile(){
		return $this->_lib3gk->is_emobile();
	}
	function is_iphone(){
		return $this->_lib3gk->is_iphone();
	}
	function is_phs(){
		return $this->_lib3gk->is_phs();
	}
	function is_ktai(){
		return $this->_lib3gk->is_ktai();
	}
	
	//------------------------------------------------
	//Check email carrier.
	//------------------------------------------------
	function get_email_carrier($email){
		return $this->_lib3gk->get_email_carrier($email);
	}
	function is_imode_email($email){
		return $this->_lib3gk->is_imode_email($email);
	}
	function is_softbank_email($email){
		return $this->_lib3gk->is_softbank_email($email);
	}
	function is_vodafone_email($email){
		return $this->_lib3gk->is_vodafone_email($email);
	}
	function is_jphone_email($email){
		return $this->_lib3gk->is_jphone_email($email);
	}
	function is_ezweb_email($email){
		return $this->_lib3gk->is_ezweb_email($email);
	}
	function is_emobile_email($email){
		return $this->_lib3gk->is_emobile_email($email);
	}
	function is_iphone_email($email){
		return $this->_lib3gk->is_iphone_email($email);
	}
	function is_ktai_email($email){
		return $this->_lib3gk->is_ktai_email($email);
	}
	function is_phs_email($email){
		return $this->_lib3gk->is_phs_email($email);
	}
	
	//----------------------------------------------------------
	//Convert emoji code.
	//If you feed strings that is coded with iMODE emoji code, it replaces a 
	//code for a carrier of using.
	//----------------------------------------------------------
	function convert_emoji(&$str, $carrier = null, $input_encoding = null, $output_encoding = null, $binary = null){
		return $this->_lib3gk->convert_emoji($str, $carrier, $input_encoding, $output_encoding, $binary);
	}
	
	//----------------------------------------------------------
	//Call emoji code.
	//If you feed iMODE emoji number or code, it creates a code for a carrier of 
	//using.
	//----------------------------------------------------------
	function emoji($code, $disp = true, $carrier = null, $output_encoding = null, $binary = null){
		return $this->_lib3gk->emoji($code, $disp, $carrier, $output_encoding, $binary);
	}
	
	//----------------------------------------------------------
	//Get machine information.
	//Search machine information using by User Agent.
	//You can get informations about carrier name, machine name, 
	//screen size, count of charactors, max size of pixels, and 
	//valid flag of picture format(gif / jpg / png).
	//----------------------------------------------------------
	function get_machineinfo($carrier = null, $name = null){
		return $this->_lib3gk->get_machineinfo($carrier, $name);
	}
	
	//----------------------------------------------------------
	//Get QR code image tag.
	//The generated tag is linked to Google chart API.
	//Options array paramaters is normally used to generate 
	//image tag, however, 'ec' and 'margin' keys are only used 
	//to this API. And 'width', 'height' are commons.
	//----------------------------------------------------------
	function get_qrcode($str, $options = array(), $input_encoding = null, $output_encoding = null){
		return $this->_lib3gk->get_qrcode($str, $options, $input_encoding, $output_encoding);
	}
	
	//----------------------------------------------------------
	//Get UID
	//----------------------------------------------------------
	function get_uid(){
		return $this->_lib3gk->get_uid();
	}
	
	//----------------------------------------------------------
	//Get inline stylesheet params
	//----------------------------------------------------------
	function style($name, $display = true){
		return $this->_lib3gk->style($name, $display);
	}
	
}
