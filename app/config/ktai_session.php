<?php
/**
 * Ktai library, supports Japanese mobile phone sites coding.
 * It provides many functions such as a carrier check to use Referer or E-mail, 
 * conversion of an Emoji, and more.
 *
 * PHP versions 4 and 5
 *
 * Ktai Library for CakePHP
 * Copyright 2009-2011, ECWorks.
 
 * Licensed under The GNU General Public Licence
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright		Copyright 2009-2011, ECWorks.
 * @link			http://www.ecworks.jp/ ECWorks.
 * @version			0.4.2
 * @lastmodified	$Date: 2011-06-27 09:00:00 +0900 (Mon, 27 Jun 2011) $
 * @license			http://www.gnu.org/licenses/gpl.html The GNU General Public Licence
 */

//Replacement function ini_set('session.use_trans_sid')
//
if(!defined('__KTAI_SESSION__')){
	define('__KTAI_SESSION__', 1);
	function session_use_trans_sid($flag){
		if(ini_set('session.use_trans_sid', $flag) === false){
			if($flag){
				$session_name = session_name();
				if(isset($_REQUEST[$session_name]) && preg_match('/^\w+$/', $_REQUEST[$session_name])){
					session_id($_REQUEST[$session_name]);
					output_add_rewrite_var($session_name, $_REQUEST[$session_name]);
				}
			}
		}
	}
}

//Get Lib3gk instance.
//
if(!class_exists('lib3gk')){
	App::import('Vendor', 'ecw'.DS.'Lib3gk');
}
$ktai = Lib3gk::get_instance();

if(!isset($ktai->_params['session_save'])){
	$ktai->_params['session_save'] = 'php';
}
Configure::write('Session.save', $ktai->_params['session_save']);

if(!isset($ktai->_params['imode_session_name'])){
	$ktai->_params['imode_session_name'] = 'csid';
}
if($ktai->is_imode()){
	Configure::write('Session.cookie', $ktai->_params['imode_session_name']);
}

//Session settings.
//
$filepath = 'ecw'.DS.'session'.DS;
if(version_compare(Configure::version(), '1.3') < 0){
	$filepath .= 'ktai_session_12.php';
}else{
	$filepath .= 'ktai_session_13.php';
}
if(file_exists(APP.'vendors'.DS.$filepath)){
	include(APP.'vendors'.DS.$filepath);
}else
if(file_exists(VENDORS.$filepath)){
	include(VENDORS.$filepath);
}

//iMODE session settings.
//
if($ktai->is_imode()){
	
	ini_set('session.use_only_cookies', 0);
	$this->_userAgent = '';
	if(Configure::read('Security.level') == 'high'){
		Configure::write('Security.level', 'medium');
	}
	
	ini_set('url_rewriter.tags', 'a=href,area=href,frame=src,input=src,form=fakeentry,fieldset=');
	session_use_trans_sid(1);
}
