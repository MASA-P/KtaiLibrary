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
 * Ktai component class for CakePHP1.2
 */
class KtaiComponent extends Object {
	
	var $_lib3gk = null;
	var $_controller = null;
	
	var $_options = array(
		'img_emoji_url' => "/img/emoticons/", 
		'enable_ktai_session' => true, 
		'use_redirect_session_id' => false, 
		'imode_session_name' => 'csid', 
		'session_save' => 'php', 
	);
	
	//--------------------------------------------------
	//Initialize ktai library
	//--------------------------------------------------
	function initialize(&$controller){
		
		$this->_controller = &$controller;
		
		$this->_options['input_encoding'] = 
		$this->_options['output_encoding'] = Configure::read('App.encoding');
		
		$this->_lib3gk = Lib3gk::get_instance();
		$this->_lib3gk->_url_callback = array($this, 'url_callback_func');
		$this->_lib3gk->_params = array_merge($this->_lib3gk->_params, $this->_options);
		if(isset($controller->ktai)){
			$this->_lib3gk->_params = array_merge($this->_lib3gk->_params, $controller->ktai);
			$controller->ktai = &$this->_lib3gk->_params;
		}
		$this->_options = &$this->_lib3gk->_params;
		
		if($this->_options['enable_ktai_session']){
			$this->_options['session_save'] = Configure::read('Session.save');
			Configure::write('Session.save', 'ktai_session');
		}
	}
	
	//--------------------------------------------------
	//Send params for ktai helper
	//--------------------------------------------------
	function beforeRender(&$controller){
		if(isset($controller->ktai)){
			Configure::write('Ktai', $this->_options);
		}
	}
	
	//--------------------------------------------------
	//Convert encoding with emoji(optional)
	//--------------------------------------------------
	function shutdown(&$controller){
		$this->_lib3gk->shutdown();
	}
	
	//--------------------------------------------------
	//URL callback function
	//--------------------------------------------------
	function url_callback_func($url){
		return Router::url($url);
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
	function is_phs_email($email){
		return $this->_lib3gk->is_phs_email($email);
	}
	function is_ktai_email($email){
		return $this->_lib3gk->is_ktai_email($email);
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
	function emoji($code, $disp = true, $carrier = null, $input_encoding = null, $output_encoding = null, $binary = null){
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
	//Get UID
	//----------------------------------------------------------
	function get_uid(){
		return $this->_lib3gk->get_uid();
	}
	
}
