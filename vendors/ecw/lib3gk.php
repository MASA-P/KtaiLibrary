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
 * Ktai Library class
 */
class Lib3gk {
	
	//------------------------------------------------
	//General informations
	//------------------------------------------------
	var $_version = '0.3.0';
	
	//------------------------------------------------
	//Library sub classes
	//------------------------------------------------
	var $__carrier = null;
	var $__emoji   = null;
	var $__html    = null;
	var $__machine = null;
	var $__ip      = null;
	var $__tools   = null;
	
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
		
		//Session params
		//
		'enable_ktai_session' => true, 
		'use_redirect_session_id' => false, 
		
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
		$this->_params = array_merge($this->__carrier->_params, $this->_params);
		$this->__carrier->_params = &$this->_params;
	}
	
	//------------------------------------------------
	//Load emoji class
	//------------------------------------------------
	function __load_emoji(){
		if(!class_exists('lib3gkemoji')){
			require_once(dirname(__FILE__).'/lib3gk_emoji.php');
		}
		$this->__emoji = Lib3gkEmoji::get_instance();
		$this->_params = array_merge($this->__emoji->_params, $this->_params);
		$this->__emoji->_params = &$this->_params;
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
	//Load html class
	//------------------------------------------------
	function __load_html(){
		if(!class_exists('lib3gkhtml')){
			require_once(dirname(__FILE__).'/lib3gk_html.php');
		}
		$this->__html = Lib3gkHtml::get_instance();
		$this->_params = array_merge($this->__html->_params, $this->_params);
		$this->__html->_params = &$this->_params;
	}
	
	//------------------------------------------------
	//Load IP table class
	//------------------------------------------------
	function __load_ip(){
		if(!class_exists('lib3gkip')){
			require_once(dirname(__FILE__).'/lib3gk_ip.php');
		}
		$this->__ip = Lib3gkIp::get_instance();
	}
	
	//------------------------------------------------
	//Load tools class
	//------------------------------------------------
	function __load_tools(){
		if(!class_exists('lib3gktools')){
			require_once(dirname(__FILE__).'/lib3gk_tools.php');
		}
		$this->__tools = Lib3gkTools::get_instance();
		$this->_params = array_merge($this->__tools->_params, $this->_params);
		$this->__tools->_params = &$this->_params;
	}
	
	//------------------------------------------------
	//Get version information
	//------------------------------------------------
	function get_version(){
		return $this->_version;
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
	//Lib3gkCarrier wrapping methods.
	//------------------------------------------------------------------------------
	
	function analyze_user_agent($user_agent = null){
		$this->__load_carrier();
		return $this->__carrier->analyze_user_agent($user_agent);
	}
	
	function get_carrier($user_agent = null, $refresh = false){
		$this->__load_carrier();
		return $this->__carrier->get_carrier($user_agent, $refresh);
	}
	
	function is_imode(){
		$this->__load_carrier();
		return $this->__carrier->is_imode();
	}
	
	function is_softbank(){
		$this->__load_carrier();
		return $this->__carrier->is_softbank();
	}
	
	function is_vodafone(){
		$this->__load_carrier();
		return $this->__carrier->is_vodafone();
	}
	
	function is_jphone(){
		$this->__load_carrier();
		return $this->__carrier->is_jphone();
	}
	
	function is_ezweb(){
		$this->__load_carrier();
		return $this->__carrier->is_ezweb();
	}
	
	function is_emobile(){
		$this->__load_carrier();
		return $this->__carrier->is_emobile();
	}
	
	function is_iphone(){
		$this->__load_carrier();
		return $this->__carrier->is_iphone();
	}
	
	function is_ktai(){
		$this->__load_carrier();
		return $this->__carrier->is_ktai();
	}
	
	function is_phs(){
		$this->__load_carrier();
		return $this->__carrier->is_phs();
	}
	
	function is_imode_email($email){
		$this->__load_carrier();
		return $this->__carrier->is_imode_email($email);
	}
	
	function is_softbank_email($email){
		$this->__load_carrier();
		return $this->__carrier->is_softbank_email($email);
	}
	
	function is_iphone_email($email){
		$this->__load_carrier();
		return $this->__carrier->is_iphone_email($email);
	}
	
	function is_vodafone_email($email){
		$this->__load_carrier();
		return $this->__carrier->is_vodafone_email($email);
	}
	
	function is_jphone_email($email){
		$this->__load_carrier();
		return $this->__carrier->is_jphone_email($email);
	}
	
	function is_ezweb_email($email){
		$this->__load_carrier();
		return $this->__carrier->is_ezweb_email($email);
	}
	
	function is_emobile_email($email){
		$this->__load_carrier();
		return $this->__carrier->is_emobile_email($email);
	}
	
	function is_ktai_email($email){
		$this->__load_carrier();
		return $this->__carrier->is_ktai_email($email);
	}
	
	function is_phs_email($email){
		$this->__load_carrier();
		return $this->__carrier->is_phs_email($email);
	}
	
	function get_email_carrier($email){
		$this->__load_carrier();
		return $this->__carrier->get_email_carrier($email);
	}
	
	
	//------------------------------------------------------------------------------
	//Lib3gkEmoji wrapping methods.
	//------------------------------------------------------------------------------
	
	function create_image_emoji($name){
		$this->__load_emoji();
		return $this->__emoji->create_image_emoji($name);
	}
	
	function emoji($code, $disp = true, $carrier = null, $output_encoding = null, $binary = null){
		$this->__load_emoji();
		return $this->__emoji->emoji($code, $disp, $carrier, $output_encoding, $binary);
	}
	
	function convert_emoji(&$str, $carrier = null, $input_encoding = null, $output_encoding = null, $binary = null){
		$this->__load_emoji();
		return $this->__emoji->convert_emoji($str, $carrier, $input_encoding, $output_encoding, $binary);
	}
	
	//------------------------------------------------------------------------------
	//Lib3gkMachine wrapping methods.
	//------------------------------------------------------------------------------
	
	function get_machineinfo($carrier_name = null, $machine_name = null){
		$this->__load_machine();
		return $this->__machine->get_machineinfo($carrier_name, $machine_name);
	}
	
	//------------------------------------------------------------------------------
	//Lib3gkHtml wrapping methods.
	//------------------------------------------------------------------------------
	function url($url){
		$this->__load_html();
		return $this->__html->url($url);
	}
	
	function image($url, $htmlAttribute = array()){
		$this->__load_html();
		return $this->__html->image($url, $htmlAttribute);
	}
	
	function stretch_image_size($width, $height, $default_width = null, $default_height = null){
		$this->__load_html();
		return $this->__html->stretch_image_size($width, $height, $default_width, $default_height);
	}
	
	function style($name, $display = true){
		$this->__load_html();
		return $this->__html->style($name, $display);
	}
	
	function get_qrcode($str, $options = array(), $input_encoding = null, $output_encoding = null){
		$this->__load_html();
		return $this->__html->get_qrcode($str, $options, $input_encoding, $output_encoding);
	}
	
	//------------------------------------------------------------------------------
	//Lib3gkIp wrapping methods.
	//------------------------------------------------------------------------------
	
	function ip2long($ip){
		$this->__load_ip();
		return $this->__ip->ip2long($ip);
	}
	
	function is_inclusive($ip, $check_addr){
		$this->__load_ip();
		return $this->__ip->is_inclusive($ip, $check_addr);
	}
	
	function get_ip_carrier($ip = null){
		$this->__load_ip();
		return $this->__ip->get_ip_carrier($ip);
	}
	
	//------------------------------------------------------------------------------
	//Lib3gkTools wrapping methods.
	//------------------------------------------------------------------------------
	
	function int2str($value){
		$this->__load_tools();
		return $this->__tools->int2str($value);
	}
	
	function int2utf8($value){
		$this->__load_tools();
		return $this->__tools->int2utf8($value);
	}
	
	function str2int($str){
		$this->__load_tools();
		return $this->__tools->str2int($str);
	}
	
	function utf82int($str){
		$this->__load_tools();
		return $this->__tools->utf82int($str);
	}
	
	function normal_encoding_str($str){
		$this->__load_tools();
		return $this->__tools->normal_encoding_str($str);
	}
	
	function mailto($title, $email, $subject = null, $body = null, $input_encoding = null, $output_encoding = null, $display = true){
		$this->__load_tools();
		return $this->__tools->mailto($title, $email, $subject, $body, $input_encoding, $output_encoding, $display);
	}
	
	function get_uid(){
		$this->__load_tools();
		return $this->__tools->get_uid();
	}
	
}
