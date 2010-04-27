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
 * defines
 */
require_once(dirname(__FILE__).'/lib3gk_def.php');

/**
 * Ktai Library html sub class
 */
class Lib3gkHtml {
	
	//------------------------------------------------
	//Library sub classes
	//------------------------------------------------
	var $__carrier = null;
	var $__machine = null;
	
	//------------------------------------------------
	//Parameters
	//------------------------------------------------
	var $_params = array(
		
		//Encoding params
		//
		'input_encoding' => 'UTF-8', 
		'output_encoding' => 'UTF-8', 
		
		//Virtual screen params
		//
		'default_screen_size' => array(240, 320), 
		
		//XML params
		//
		'use_xml' => false, 
		
		//Inline stylesheet params
		//
		'style' => array(), 
	);
	
	//------------------------------------------------
	//Callbacks
	//------------------------------------------------
	var $_url_callback = null;
	
	//------------------------------------------------
	//Get instance
	//------------------------------------------------
	function &get_instance(){
		static $instance = array();
		if(!$instance){
			$instance[0] =& new Lib3gkHtml();
			$instance[0]->initialize();
		}
		return $instance[0];
	}
	
	
	//------------------------------------------------
	//Initialize process
	//------------------------------------------------
	function initialize(){
		$this->_url_callback = array($this, '__url_callback_func');
	}
	
	
	//------------------------------------------------
	//Shutdown process
	//------------------------------------------------
	function shutdown(){
	}
	
	
	//------------------------------------------------
	//Load carrier class
	//------------------------------------------------
	function __load_carrier(){
		if(!class_exists('lib3gkecarrier')){
			require_once(dirname(__FILE__).'/lib3gk_carrier.php');
		}
		$this->__carrier = Lib3gkCarrier::get_instance();
		$this->_params = array_merge($this->_params, $this->__carrier->_params);
		$this->__carrier->_params = &$this->_params;
	}
	
	//------------------------------------------------
	//Load machine info class
	//------------------------------------------------
	function __load_machine(){
		if(!class_exists('lib3gkmachine')){
			require_once(dirname(__FILE__).'/lib3gk_machine.php');
		}
		$this->__machine = Lib3gkMachine::get_instance();
	}
	
	//------------------------------------------------
	//call URL function
	//------------------------------------------------
	function url($url){
		return call_user_func($this->_url_callback, $url);
	}
	
	
	//------------------------------------------------
	//URL callback function
	//------------------------------------------------
	function __url_callback_func($url){
		return htmlspecialchars($url, ENT_QUOTES);
	}
	
	//------------------------------------------------
	//Create image tags adding width and height params 
	//that is calculated by virtual screen size and 
	//machine screen size
	//------------------------------------------------
	function image($url, $htmlAttribute = array(), $stretch = true){
		
		$url = $this->url($url);
		$str = '<img src="'.$url.'"';
		if(isset($htmlAttribute['width']) && isset($htmlAttribute['height'])){
			if($stretch){
				$arr = $this->stretch_image_size($htmlAttribute['width'], $htmlAttribute['height']);
				$htmlAttribute['width'] = $arr[0];
				$htmlAttribute['height'] = $arr[1];
			}
		}
		foreach($htmlAttribute as $fkey => $fvalue){
			$str .= ' '.$fkey.'="'.$fvalue.'"';
		}
		if($this->_params['use_xml']){
			$str .= ' /';
		}
		$str .= '>';
		
		return $str;
	}
	
	
	//------------------------------------------------
	//Adjiust image size
	//------------------------------------------------
	function stretch_image_size($width, $height, $default_width = null, $default_height = null){
		
		$this->__load_machine();
		
		if($default_width === null){
			$default_width = $this->_params['default_screen_size'][0];
		}
		if($default_height === null){
			$default_height = $this->_params['default_screen_size'][1];
		}
		
		$arr = $this->__machine->get_machineinfo();
		$sx = $arr['screen_size'][0];
		$sy = $arr['screen_size'][1];
		
		$dx = $sx * $width  / $default_width;
		$dy = $sx * $height / $default_width;
		
		return array($dx, $dy);
	}
	
	
	//------------------------------------------------------------------------------
	//Get inline stylesheet
	//------------------------------------------------------------------------------
	function style($name, $display = true){
		
		$str = '';
		
		if(isset($this->_params['style'][$name])){
			$str = $this->_params['style'][$name];
		}
		if($display){
			echo $str;
		}
		
		return $str;
	}
	
	//------------------------------------------------------------------------------
	//Get QR code tag
	//------------------------------------------------------------------------------
	function get_qrcode($str, $options = array(), $input_encoding = null, $output_encoding = null){
		
		$options = array_merge(array('width' => 220, 'height' => 220), $options);
		
		if($input_encoding === null){
			$input_encoding = $this->_params['input_encoding'];
		}
		if($output_encoding === null){
			$output_encoding = $this->_params['output_encoding'];
		}
		
		$url = 'http://chart.apis.google.com/chart?cht=qr';
		$url .= '&chs='.$options['width'].'x'.$options['height'];
		if($input_encoding != KTAI_ENCODING_UTF8){
			$str = mb_convert_encoding($str, 'UTF-8', $input_encoding);
		}
		$url .= '&chl='.$str;
		if($output_encoding == KTAI_ENCODING_SJIS || $output_encoding == KTAI_ENCODING_SJISWIN){
			$url .= '&choe=Shift_JIS';
		}else{
			$url .= '&choe=UTF-8';
		}
		$ec = '';
		if(isset($options['ec'])){
			$ec = $options['ec'];
			unset($options['ec']);
		}
		if(isset($options['margin'])){
			if($ec != ''){
				$ec .= '|';
			}
			$ec .= $options['margin'];
			unset($options['margin']);
		}
		if($ec != ''){
			$url .= 'chld='.$ec;
		}
		return $this->image($url, $options);
	}
	
	//------------------------------------------------------------------------------
	//Get Google Static Maps image
	//------------------------------------------------------------------------------
	function get_static_maps( $lat, $lon, $options = array(), $api_key = null){
		
		$default_options = array(
			'zoom' => 15, 
			'format' => 'jpg', 
			'maptype' => 'mobile', 
			'sensor' => false,
		);
		$options = array_merge($default_options, $options);
		
		//center
		//
		if($lat == '' || $lon == ''){
			if(!empty($options['center'])){
				if(is_array($options['center'])){
					$lat = $options['center'][0];
					$lon = $options['center'][1];
				}else{
					list($lat, $lon) = explode(',', $options['center']);
				}
			}else{
				return null;
			}
			unset($options['center']);
		}
		
		//size
		//
		if(!empty($options['size'])){
			if(is_array($options['size'])){
				$width  = $options['size'][0];
				$height = $options['size'][1];
			}else{
				list($width, $height) = explode('x', $options['size']);
			}
			unset($options['center']);
		}else{
			$width =  $this->_params['default_screen_size'][0];
			$height = $width;
		}
		list($width, $height) = $this->stretch_image_size($width, $height);
		
		
		//markers
		//
		if(!empty($options['markers'])){
			$markers = $options['markers'];
			if(is_array($markers)){
				if(!is_array($markers[0])){
					$arr = $markers;
					$markers = array($arr);
				}
				$str = '';
				foreach($markers as $fvalue){
					if($str != ''){
						$str .= '|';
					}
					$str .= array_shift($fvalue).','.array_shift($fvalue);
					$s = '';
					foreach($fvalue as $fvalue2){
						$s .= $fvalue2;
					}
					if($s != ''){
						$str .= ','.$s;
					}
				}
				$markers = $str;
			}
			unset($options['markers']);
		}
		
		//path
		//
		if(!empty($options['path'])){
			$path = $options['path'];
			if(!isset($path['rgb']) && !isset($path['rgba'])){
				return null;
			}
			if(empty($path['points']) || count($path['points']) < 1){
				return null;
			}
			$points = $path['points'];
			unset($path['points']);
			
			$str = '';
			foreach($path as $fkey => $fvalue){
				if($str != ''){
					$str .= ',';
				}
				$str .= $fkey.':'.$fvalue;
			}
			foreach($points as $fvalue){
				$str .= '|';
				$str .= $fvalue[0].','.$fvalue[1];
			}
			$path = $str;
			unset($options['path']);
		}
		
		//span
		//
		if(!empty($options['span'])){
			$span = $options['span'];
			if(is_array($span)){
				$span = $span[0].','.$span[1];
			}else{
				return null;
			}
			unset($options['span']);
		}
		
		//sensor
		//
		$sensor = $options['sensor'];
		unset($options['sensor']);
		
		//api_key
		//
		if($api_key === null){
			if(!empty($options['key'])){
				$api_key = $options['key'];
			}else
			if(!empty($this->_params['google_api_key'])){
				$api_key = $this->_params['google_api_key'];
			}else{
				return null;
			}
			unset($options['key']);
		}
		
		$url = 'http://maps.google.com/staticmap?';
		$url .= 'center='.$lat.','.$lon;
		$url .= '&size='.$width.'x'.$height;
		if(!empty($markers)){
			$url .= '&markers='.$markers;
		}
		if(!empty($path)){
			$url .= '&path='.$path;
		}
		if(!empty($span)){
			$url .= '&span='.$span;
		}
		foreach($options as $fkey => $fvalue){
			$url .= '&'.$fkey.'='.$fvalue;
		}
		$url .= '&sensor='.($sensor ? 'true' : 'false');
		$url .= '&key='.$api_key;
		
		return $this->image($url, array('width' => $width, 'height' => $height), false);
	}
}
