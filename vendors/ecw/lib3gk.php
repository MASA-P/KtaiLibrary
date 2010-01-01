<?php
/**
 * Ktai library, supports Japanese mobile phone sites coding.
 * It provides many functions such as a carrier check to use Referer or E-mail, 
 * conversion of an Emoji, and more.
 *
 * PHP versions 4 and 5
 *
 * Ktai Library for CakePHP1.2
 * Copyright 2009, ECWorks.
 
 * Licensed under The GNU General Public Licence
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright		Copyright 2009, ECWorks.
 * @link			http://www.ecworks.jp/ ECWorks.
 * @version			0.2.1
 * @lastmodified	$Date: 2009-12-23 06:00:00 +0900 (Wed, 23 Dec 2009) $
 * @license			http://www.gnu.org/licenses/gpl.html The GNU General Public Licence
 */

/**
 * defines
 */

define('KTAI_CARRIER_UNKNOWN',  0);
define('KTAI_CARRIER_DOCOMO',   1);
define('KTAI_CARRIER_KDDI',     2);
define('KTAI_CARRIER_SOFTBANK', 3);
define('KTAI_CARRIER_EMOBILE',  4);
define('KTAI_CARRIER_IPHONE',   5);
define('KTAI_CARRIER_PHS',      6);

define('KTAI_ENCODING_SJIS', 'SJIS');
define('KTAI_ENCODING_SJISWIN', 'SJIS-win');
define('KTAI_ENCODING_UTF8', 'UTF-8');

/**
 * Ktai Library class
 */
class Lib3gk {
	
	//------------------------------------------------
	//General informations
	//------------------------------------------------
	var $_version = '0.2.0';
	
	//------------------------------------------------
	//Machine information
	//------------------------------------------------
	var $_carrier      = null;
	var $_carrier_name = 'others';
	var $_machine_name = 'default';
	
	//------------------------------------------------
	//Sub library classes
	//------------------------------------------------
	var $__emoji   = null;
	var $__machine = null;
	
	//------------------------------------------------
	//Callbacks
	//------------------------------------------------
	var $_url_callback = null;
	
	//------------------------------------------------
	//Parameters
	//------------------------------------------------
	var $_params = array(
		
		//Encoding params
		//
		'input_encoding'  => KTAI_ENCODING_SJISWIN, 
		'output_encoding' => KTAI_ENCODING_SJISWIN, 
		'use_binary_emoji' => true, 
		
		//Emoji image params
		//
		'use_img_emoji' => false, 
		'img_emoji_url' => './img/emoticons/', 
		'img_emoji_ext' => 'gif', 
		'img_emoji_size' => array(16, 16), 
		
		//iPhone params
		//
		'iphone_user_agent_belongs_to_ktai'      => false, 
		'iphone_user_agent_belongs_to_softbank'  => false, 
		'iphone_email_belongs_to_ktai_email'     => false, 
		'iphone_email_belongs_to_softbank_email' => false, 
		
		//Virtual screen params
		//
		'default_screen_size' => array(240, 320), 
		
		//Session params
		//
		'enable_ktai_session' => true, 
		'use_redirect_session_id' => false, 
		
		//XML params
		//
		'use_xml' => false, 
		
		//Inline stylesheet params
		//
		'style' => array(), 
	);
	
	//------------------------------------------------
	//Get instance
	//------------------------------------------------
	function &get_instance(){
		static $instance = array();
		if(!$instance){
			$instance[0] =& new Lib3gk();
			$instance[0]->initialize();
		}
		return $instance[0];
	}
	
	
	//------------------------------------------------
	//Initialize process
	//------------------------------------------------
	function initialize(){
		$this->get_carrier();
		$this->_url_callback = array($this, '__url_callback_func');
	}
	
	
	//------------------------------------------------
	//Shutdown process
	//------------------------------------------------
	function shutdown(){
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
	//URL callback function
	//------------------------------------------------
	function __convertEmojiChractor($code, $oekey, $binary){
		$replace = '';
		if($code != 0){
//«‰½ŒÌ‚±‚Ì‚Ì‚æ‚¤‚È•ÏX‚ð‚µ‚½‚Ì‚©–Y‚ê‚Ä‚µ‚Ü‚Á‚½c(^^;;;
//			if($carrier ==  KTAI_CARRIER_DOCOMO || !$binary){
			if(!$binary){
				if($oekey == 0){
					$replace = '&#'.$code.';';
				}else{
					$replace = '&#x'.dechex($code).';';
				}
			}else{
				if($oekey == 0){
					$replace = $this->int2str($code);
				}else{
					$replace = $this->int2utf8($code);
				}
			}
		}
		return $replace;
	}
	
	//------------------------------------------------
	//Load emoji class
	//------------------------------------------------
	function _load_emoji(){
		if(!class_exists('lib3gkemoji')){
			require_once(dirname(__FILE__).'/lib3gk_emoji.php');
		}
		$this->__emoji = Lib3gkEmoji::get_instance();
	}
	
	//------------------------------------------------
	//Load machine info class
	//------------------------------------------------
	function _load_machine(){
		if(!class_exists('lib3gkmachine')){
			require_once(dirname(__FILE__).'/lib3gk_machine.php');
		}
		$this->__machine = Lib3gkMachine::get_instance();
	}
	
	//------------------------------------------------
	//Normal encoding strings
	//------------------------------------------------
	function normal_encoding_str($str){
		$enc = mb_internal_encoding();
		
		mb_internal_encoding($str);
		$str = mb_internal_encoding();
		
		mb_internal_encoding($enc);
		
		return $str;
	}
	
	//------------------------------------------------
	//Create emoji image tags
	//------------------------------------------------
	function create_image_emoji($name){
		$url = $this->_params['img_emoji_url'].$name.'.'.$this->_params['img_emoji_ext'];
		$htmlAttribute = array(
			'border' => 0, 
			'width' => $this->_params['img_emoji_size'][0], 
			'height' => $this->_params['img_emoji_size'][1], 
		);
		return $this->image($url, $htmlAttribute);
	}
	
	//------------------------------------------------
	//Create image tags adding width and height params 
	//that is calculated by virtual screen size and 
	//machine screen size
	//------------------------------------------------
	function image($url, $htmlAttribute = array()){
		
		$url = $this->url($url);
		$str = '<img src="'.$url.'"';
		if(isset($htmlAttribute['width']) && isset($htmlAttribute['height'])){
			$arr = $this->stretch_image_size($htmlAttribute['width'], $htmlAttribute['height']);
			$htmlAttribute['width'] = $arr[0];
			$htmlAttribute['height'] = $arr[1];
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
		
		if($default_width === null){
			$default_width = $this->_params['default_screen_size'][0];
		}
		if($default_height === null){
			$default_height = $this->_params['default_screen_size'][1];
		}
		
		$arr = $this->get_machineinfo();
		$sx = $arr['screen_size'][0];
		$sy = $arr['screen_size'][1];
		
		$dx = $sx * $width  / $default_width;
		$dy = $sx * $height / $default_width;
		
		return array($dx, $dy);
	}
	
	
	//------------------------------------------------
	//Convert integer to charactor code of emoji
	//------------------------------------------------
	function int2str($value){
		if($value < 0){
			return false;
		}
		$str = '';
		do {
			$str = chr($value & 0x0ff) . $str;
			$value = $value >> 8;
		}while($value > 0);
		
		return $str;
	}
	
	//------------------------------------------------
	//Conbert unicode to UTF-8 charactor code of emoji
	//------------------------------------------------
	function int2utf8($value){
		$str = $this->int2str($value);
		if($str === false){
			return false;
		}
		return mb_convert_encoding($str, 'UTF-8', 'Unicode');
	}
	
	//------------------------------------------------
	//Get version information
	//------------------------------------------------
	function get_version(){
		return $this->_version;
	}
	
	//------------------------------------------------
	//Get carrier code
	//------------------------------------------------
	function get_carrier($user_agent = null, $refresh = false){
		
		if($this->_carrier === null || $user_agent !== null || $refresh){
			$arr = $this->analyze_user_agent($user_agent);
			
			if($this->_carrier === null || $refresh){
				$this->_carrier = $arr['carrier'];
				$this->_carrier_name = $arr['carrier_name'];
				$this->_machine_name = $arr['machine_name'];
			}
			
			return $arr['carrier'];
		}
		return $this->_carrier;
	}
	
	
	//------------------------------------------------
	//Create machine informations from HTTP_USER_AGENT
	//------------------------------------------------
	function analyze_user_agent($user_agent = null){
		
		$arr = array(
			'carrier'      => KTAI_CARRIER_UNKNOWN, 
			'carrier_name' => 'others', 
			'machine_name' => 'default', 
		);
		
		if($user_agent === null){
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
		}
		
		//DoCoMo
		//
		if(strpos($user_agent, 'DoCoMo') !== false){
			$arr['carrier'] = KTAI_CARRIER_DOCOMO;
			$arr['carrier_name'] = 'DoCoMo';
			if(preg_match('_DoCoMo/1\.0/([\w]+)/_', $user_agent, $m)){
				$arr['machine_name'] = $m[1];
			}else
			if(preg_match('_DoCoMo/2\.0\s([\w]+)\(_', $user_agent, $m)){
				$arr['machine_name'] = $m[1];
			}
		
		//Softbank
		//
		}else
		if(strpos($user_agent, 'SoftBank') !== false){
			$arr['carrier'] = KTAI_CARRIER_SOFTBANK;
			$arr['carrier_name'] = 'SoftBank';
			if(preg_match('_SoftBank/\d\.\d/([\w]+)_', $user_agent, $m)){
				$arr['machine_name'] = $m[1];
			}
		
		}else
		if(strpos($user_agent, 'Vodafone') !== false){
			$arr['carrier'] = KTAI_CARRIER_SOFTBANK;
			$arr['carrier_name'] = 'Vodafone';
			if(preg_match('_Vodafone/\d\.\d/([\w]+)_', $user_agent, $m)){
				$arr['machine_name'] = $m[1];
			}
		
		}else
		if(strpos($user_agent, 'J-PHONE') !== false){
			$arr['carrier'] = KTAI_CARRIER_SOFTBANK;
			$arr['carrier_name'] = 'J-PHONE';
			if(preg_match('_J-PHONE/\d\.\d/([\w]+)_', $user_agent, $m)){
				$arr['machine_name'] = $m[1];
			}
			
		}else
		if(strpos($user_agent, 'MOT-C980') !== false){
			$arr['carrier'] = KTAI_CARRIER_SOFTBANK;
			$arr['carrier_name'] = 'MOT-C980';
			$arr['machine_name'] = 'default';
			
		}else
		if(strpos($user_agent, 'MOT-V980') !== false){
			$arr['carrier'] = KTAI_CARRIER_SOFTBANK;
			$arr['carrier_name'] = 'MOT-V980';
			$arr['machine_name'] = 'default';
			
		//KDDI
		//
		}else
		if(strpos($user_agent, 'KDDI-') !== false){
			$arr['carrier'] = KTAI_CARRIER_KDDI;
			$arr['carrier_name'] = 'KDDI';
			preg_match('/KDDI\-([\w]+)\s/', $user_agent, $m);
			$arr['machine_name'] = $m[1];
		
		//EMOBILE
		//
		}else
		if(strpos($user_agent, 'emobile') !== false){
			$arr['carrier'] = KTAI_CARRIER_EMOBILE;
			$arr['carrier_name'] = 'emobile';
			preg_match('/\(([\w]+);/', $user_agent, $m);
			$arr['machine_name'] = $m[1];
		
		//iPhone
		//
		}else
		if(strpos($user_agent, 'iPhone') !== false){
			$arr['carrier'] = KTAI_CARRIER_IPHONE;
			$arr['carrier_name'] = 'iPhone';
			$arr['machine_name'] = 'default';
		
		//PHS
		//
		}else
		if(strpos($user_agent, 'WILLCOM') !== false){
			$arr['carrier'] = KTAI_CARRIER_PHS;
			$arr['carrier_name'] = 'WILLCOM';
			preg_match('_WILLCOM;[\w]+/([A-Za-z0-9\-]+)/_', $user_agent, $m);
			$arr['machine_name'] = $m[1];
		}else
		if(strpos($user_agent, 'DDIPOCKET') !== false){
			$arr['carrier'] = KTAI_CARRIER_PHS;
			$arr['carrier_name'] = 'DDIPOCKET';
			$arr['machine_name'] = 'default';
			preg_match('_DDIPOCKET;[\w]+/([A-Za-z0-9\-]+)/_', $user_agent, $m);
			$arr['machine_name'] = $m[1];
		}
		
		return $arr;
	}
	
	
	//------------------------------------------------
	//Checking iMODE
	//------------------------------------------------
	function is_imode(){
		return $this->get_carrier() == KTAI_CARRIER_DOCOMO;
	}
	
	
	//------------------------------------------------
	//Checking Softbank
	//------------------------------------------------
	function is_softbank(){
		return $this->get_carrier() == KTAI_CARRIER_SOFTBANK || 
			($this->_params['iphone_user_agent_belongs_to_softbank'] && $this->is_iphone());
	}
	
	
	//------------------------------------------------
	//Checking Vodafone
	//  This is legacy function. 
	//  Normally, use is_softbank()
	//------------------------------------------------
	function is_vodafone(){
		
		$flag = false;
		
		$this->get_carrier();
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Vodafone') !== false){
			$flag = true;
		}else
		if($this->is_jphone()){
			$flag = true;
		}
		
		return $flag;
	}
	
	
	//------------------------------------------------
	//Checking J-PHONE
	//  This is legacy function. 
	//  Normally, use is_softbank()
	//------------------------------------------------
	function is_jphone(){
		$this->get_carrier();
		return strpos($_SERVER['HTTP_USER_AGENT'], 'J-PHONE') !== false;
	}
	
	
	//------------------------------------------------
	//Checking EZweb
	//------------------------------------------------
	function is_ezweb(){
		return $this->get_carrier() == KTAI_CARRIER_KDDI;
	}
	
	
	//------------------------------------------------
	//Checking EMOBILE
	//------------------------------------------------
	function is_emobile(){
		return $this->get_carrier() == KTAI_CARRIER_EMOBILE;
	}
	
	
	//------------------------------------------------
	//Checking iPhone
	//------------------------------------------------
	function is_iphone(){
		return $this->get_carrier() == KTAI_CARRIER_IPHONE;
	}
	
	
	//------------------------------------------------
	//Checking Ktai
	//------------------------------------------------
	function is_ktai(){
		return 	$this->is_imode() || 
				$this->is_softbank() || 
				$this->is_ezweb() || 
				$this->is_emobile() || 
				($this->_params['iphone_user_agent_belongs_to_ktai'] && $this->is_iphone());
	}
	
	
	//------------------------------------------------
	//Checking PHS
	//------------------------------------------------
	function is_phs(){
		return $this->get_carrier() == KTAI_CARRIER_PHS;
	}
	
	//------------------------------------------------
	//Checking iMODE email
	//------------------------------------------------
	function is_imode_email($email){
		return stripos($email, '@docomo.ne.jp') !== false;
	}
	
	
	//------------------------------------------------
	//Checking Softbank email
	//------------------------------------------------
	function is_softbank_email($email){
		if(stripos($email, '@softbank.ne.jp') !== false) return true;
		if($this->_params['iphone_email_belongs_to_softbank_email'] && $this->is_iphone_email($email)) return true;
		return $this->is_vodafone_email($email);
	}
	
	
	//------------------------------------------------
	//Checking iPhone email
	//------------------------------------------------
	function is_iphone_email($email){
		return stripos($email, '@i.softbank.jp') !== false;
	}
	
	
	//------------------------------------------------
	//Checking VODAFONE email
	//  This is legacy function. 
	//  Normally, use is_softbank_email()
	//------------------------------------------------
	function is_vodafone_email($email){
		if(preg_match('/@[dhtckrsnq]\.vodafone\.ne\.jp/i', $email)) return true;
		return $this->is_jphone_email($email);
	}
	
	
	//------------------------------------------------
	//Checking JPHONE email
	//  This is legacy function. 
	//  Normally, use is_softbank_email()
	//------------------------------------------------
	function is_jphone_email($email){
		return(preg_match('/@jp\-[dhtckrsnq]\.ne\.jp/i', $email)) ? true : false;
	}
	
	
	//------------------------------------------------
	//Checking EZweb email
	//------------------------------------------------
	function is_ezweb_email($email){
		return (stripos($email, '@ezweb.ne.jp') !== false) || 
			(preg_match('/@[a-z-]{2,10}\.biz\.ezweb\.ne\.jp/i', $email) ? true : false);
	}
	
	
	//------------------------------------------------
	//Checking EMOBILE email
	//------------------------------------------------
	function is_emobile_email($email){
		return stripos($email, '@emnet.ne.jp') !== false;
	}
	
	
	//------------------------------------------------
	//Checking Ktai email
	//------------------------------------------------
	function is_ktai_email($email){
		return 	$this->is_imode_email($email) || 
				$this->is_softbank_email($email) || 
				$this->is_ezweb_email($email) ||
				$this->is_emobile_email($email) ||
				($this->_params['iphone_email_belongs_to_ktai_email'] && $this->is_iphone_email($email));
	}
	
	
	//------------------------------------------------
	//Checking PHS email
	//------------------------------------------------
	function is_phs_email($email){
		if(preg_match('/@[\w]+\.pdx\.ne\.jp/i', $email)) return true;
		return stripos($email, '@willcom.com') !== false;
	}
	
	
	//------------------------------------------------
	//Get carrier code from email
	//------------------------------------------------
	function get_email_carrier($email){
		
		$carrier = KTAI_CARRIER_UNKNOWN;
		
		if($this->is_imode_email($email)){
			$carrier = KTAI_CARRIER_DOCOMO;
		}else
		if($this->is_ezweb_email($email)){
			$carrier = KTAI_CARRIER_KDDI;
		}else
		if($this->is_iphone_email($email)){
			$carrier = KTAI_CARRIER_IPHONE;
		}else
		if($this->is_softbank_email($email)){
			$carrier = KTAI_CARRIER_SOFTBANK;
		}else
		if($this->is_emobile_email($email)){
			$carrier = KTAI_CARRIER_EMOBILE;
		}else
		if($this->is_phs_email($email)){
			$carrier = KTAI_CARRIER_PHS;
		}
		
		return $carrier;
	}
	
	//------------------------------------------------
	//Create link tags for mailto
	//------------------------------------------------
	function mailto($title, $email, $subject = null, $body = null, $input_encoding = null, $output_encoding = null, $display = true){
		if($input_encoding === null){
			$input_encoding = $this->_params['input_encoding'];
		}
		$input_encoding = $this->normal_encoding_str($input_encoding);
		
		if($output_encoding === null){
			$output_encoding = $this->_params['output_encoding'];
		}
		$output_encoding = $this->normal_encoding_str($output_encoding);
		
		if($this->is_iphone()){
			$subject = mb_ereg_replace("\r", "", $subject);
			$subject = mb_ereg_replace("\n", "%0D%0A", $subject);
			$body = mb_ereg_replace("\r", "\n", $body);
			$body = mb_ereg_replace("\n", "%0D%0A", $body);
		}else
		if($this->is_softbank()){
			if($subject !== null){
				if($input_encoding != KTAI_ENCODING_UTF8){
					$subject = mb_convert_encoding($subject, KTAI_ENCODING_UTF8, $input_encoding);
				}
				$subject = urlencode($subject);
			}
			if($body !== null){
				if($input_encoding != KTAI_ENCODING_UTF8){
					$body = mb_convert_encoding($body, KTAI_ENCODING_UTF8, $input_encoding);
				}
				$body = urlencode($body);
			}
		}else{
			if($subject !== null){
				if($input_encoding != KTAI_ENCODING_SJIS && $input_encoding != KTAI_ENCODING_SJISWIN){
					$subject = mb_convert_encoding($subject, KTAI_ENCODING_SJISWIN, $input_encoding);
				}
				$subject = urlencode($subject);
			}
			if($body !== null){
				if($input_encoding != KTAI_ENCODING_SJIS && $input_encoding != KTAI_ENCODING_SJISWIN){
					$body = mb_convert_encoding($body, KTAI_ENCODING_SJISWIN, $input_encoding);
				}
				$body = urlencode($body);
			}
		}
		
		$str = '';
		if($subject !== null){
			$str .= 'subject='.$subject;
		}
		if($body !== null){
			if($str != ''){
				$str .= '&';
			}
			$str .= 'body='.$body;
		}
		if($str != ''){
			$str = '?'.$str;
		}
		$str = '<a href="mailto:'.$email.$str.'">'.$title.'</a>';
		
		if($display){
			echo $str;
		}
		return $str;
	}
	
	
	//------------------------------------------------------------------------------
	//Convert iMODE Emoji to other carriers
	//------------------------------------------------------------------------------
	function convert_emoji(&$str, $carrier = null, $input_encoding = null, $output_encoding = null, $binary = null){
		
		if($carrier === null){
			$carrier = $this->get_carrier();
		}
		
		if($binary === null){
			$binary = $this->_params['use_binary_emoji'];
		}
		
		if($input_encoding === null){
			$input_encoding = $this->_params['input_encoding'];
		}
		$input_encoding = $this->normal_encoding_str($input_encoding);
		if($input_encoding == KTAI_ENCODING_UTF8){
			$iekey = 1;
		}else
		if($input_encoding == KTAI_ENCODING_SJIS || $input_encoding == KTAI_ENCODING_SJISWIN){
			$iekey = 0;
		}else{
			$iekey = -1;
		}
		
		if($output_encoding === null){
			$output_encoding = $this->_params['output_encoding'];
		}
		$output_encoding = $this->normal_encoding_str($output_encoding);
		if($output_encoding == KTAI_ENCODING_UTF8){
			if($carrier == KTAI_CARRIER_KDDI && $binary){
				$oekey = 2;
			}else{
				$oekey = 1;
			}
		}else{
			$oekey = 0;
		}
		
		if($this->_params['use_img_emoji']){
			$default_key = 4;
		}else{
			$default_key = 3;
		}
		
		switch($carrier){
		case KTAI_CARRIER_DOCOMO:
		case KTAI_CARRIER_EMOBILE:
			$key = 0;
			break;
			
		case KTAI_CARRIER_KDDI:
			$key = 1;
			break;
			
		case KTAI_CARRIER_SOFTBANK:
			$key = 2;
			break;
			
		default:
			$key = $default_key;
		}
		
		$this->_load_emoji();
		foreach($this->__emoji->emoji_table as $fvalue){
			
			$search = array();
			$replace = '';
			
			$c = $fvalue[0][0];
			$search[] = '&#'.$c.';';
			if($iekey == 0){
				$search[] = $this->int2str($c);
			}
			$c = $fvalue[0][1];
			$search[] = '&#x'.dechex($c).';';
			if($iekey == 1){
				$search[] = $this->int2utf8($c);
			}
			
			if($key == 0 || $key == 1){
				$replace = $this->__convertEmojiChractor($fvalue[$key][$oekey], $oekey, $binary);
			}else
			if($key == 2){
				$replace = $fvalue[$key];
			}
			
			if($replace == ''){
				if($default_key == 4){
					$replace = $this->create_image_emoji($fvalue[$default_key]);
				}else{
					$replace = $fvalue[$default_key];
					if($oekey == 1){
						$replace = mb_convert_encoding($replace, KTAI_ENCODING_UTF8, KTAI_ENCODING_SJISWIN);
					}
				}
			}
			$str = str_replace($search, $replace, $str);
		}
	}
	
	
	//------------------------------------------------------------------------------
	//Create Emoji charactor code
	//------------------------------------------------------------------------------
	function emoji($code, $disp = true, $carrier = null, $output_encoding = null, $binary = null){
		
		if($carrier === null){
			$carrier = $this->get_carrier();
		}
		
		if($binary === null){
			$binary = $this->_params['use_binary_emoji'];
		}
		
		if($output_encoding === null){
			$output_encoding = $this->_params['output_encoding'];
		}
		$output_encoding = $this->normal_encoding_str($output_encoding);
		if($output_encoding == KTAI_ENCODING_UTF8){
			if($carrier == KTAI_CARRIER_KDDI && $binary){
				$oekey = 2;
			}else{
				$oekey = 1;
			}
		}else{
			$oekey = 0;
		}
		
		if($this->_params['use_img_emoji']){
			$default_key = 4;
		}else{
			$default_key = 3;
		}
		
		switch($carrier){
		case KTAI_CARRIER_DOCOMO:
		case KTAI_CARRIER_EMOBILE:
			$key = 0;
			break;
			
		case KTAI_CARRIER_KDDI:
			$key = 1;
			break;
			
		case KTAI_CARRIER_SOFTBANK:
			$key = 2;
			break;
			
		default:
			$key = $default_key;
		}
		
		$this->_load_emoji();
		if(is_int($code)){
			if($code >= $this->__emoji->emoji_table[0][0][0]){
				$iekey = 0;
			}else{
				$iekey = 1;
			}
		}
		
		$table = null;
		foreach($this->__emoji->emoji_table as $emoji_table){
			if(is_int($code)){
				$check = $emoji_table[0][$iekey];
				if($check == $code){
					$table = $emoji_table;
					break;
				}
			}else{
				$check = $this->int2str($emoji_table[0][0]);
				if($check == $code){
					$table = $emoji_table;
					break;
				}
				$check = $this->int2utf8($emoji_table[0][1]);
				if($check == $code){
					$table = $emoji_table;
					break;
				}
			}
		}
		
		$str = '';
		if($table !== null){
			if($key == 0 || $key == 1){
				$str = $this->__convertEmojiChractor($table[$key][$oekey], $oekey, $binary);
			}else
			if($key == 2){
				$str = $table[$key];
			}
			
			if($str == ''){
				if($default_key == 4){
					$str = $this->create_image_emoji($table[$default_key]);
				}else{
					$str = $table[$default_key];
					if($oekey == 1){
						$str = mb_convert_encoding($str, KTAI_ENCODING_UTF8, KTAI_ENCODING_SJISWIN);
					}
				}
			}
		}
		
		if($disp){
			echo $str;
		}
		return $str;
	}
	
	//------------------------------------------------------------------------------
	//Redirect process
	//------------------------------------------------------------------------------
	function redirect($url, $exit = true){
		
		if($this->_params['enable_ktai_session'] && 
			($this->_params['use_redirect_session_id'] || $this->is_imode())){
			if(strpos($url, '?') === false){
				$url .= '?';
			}else{
				$url .= '&';
			}
			$url .= sprintf("%s=%s", session_name(),urlencode(session_id()));
		}
		header('Location: '.$url);
		
		if($exit){
			exit();
		}
	}
	
	//------------------------------------------------------------------------------
	//Get machine informations
	//------------------------------------------------------------------------------
	function get_machineinfo($carrier_name = null, $machine_name = null){
		
		if($carrier_name === null || $machine_name === null){
			$this->get_carrier();
			$carrier_name = $this->_carrier_name;
			$machine_name = $this->_machine_name;
		}
		
		$this->_load_machine();
		$default = false;
		if(!isset($this->__machine->machine_table[$carrier_name])){
			$carrier_name = 'others';
			$default = true;
		}
		if(!isset($this->__machine->machine_table[$carrier_name][$machine_name])){
			$machine_name = 'default';
			$default = true;
		}
		$arr = $this->__machine->machine_table[$carrier_name][$machine_name];
		
		$arr['carrier'] = $this->_carrier;
		$arr['carrier_name'] = $this->_carrier_name;
		$arr['machine_name'] = $this->_machine_name;
		$arr['default'] = $default;
		
		return $arr;
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
	//Get uid
	//------------------------------------------------------------------------------
	function get_uid(){
		
		$uid = false;
		
		if($this->is_imode()){
			if(isset($_SERVER['HTTP_X_DCMGUID'])){
				$uid = $_SERVER['HTTP_X_DCMGUID'];
			}
		}else
		if($this->is_ezweb()){
			if(isset($_SERVER['HTTP_X_UP_SUBNO'])){
				$uid = $_SERVER['HTTP_X_UP_SUBNO'];
			}
		}else
		if($this->is_softbank() && !$this->is_iphone()){
			if(isset($_SERVER['HTTP_X_JPHONE_UID'])){
				$uid = $_SERVER['HTTP_X_JPHONE_UID'];
			}
		}else
		if($this->is_emobile()){
			if(isset($_SERVER['HTTP_X_EM_UID'])){
				$uid = $_SERVER['HTTP_X_EM_UID'];
			}
		}
		
		return $uid;
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
	
}
