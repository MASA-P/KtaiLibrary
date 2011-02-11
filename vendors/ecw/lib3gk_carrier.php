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
 * @version			0.4.1
 * @lastmodified	$Date: 2011-02-11 18:00:00 +0900 (Fri, 11 Feb 2011) $
 * @license			http://www.gnu.org/licenses/gpl.html The GNU General Public Licence
 */

/**
 * defines
 */
require_once(dirname(__FILE__).'/lib3gk_def.php');

/**
 * Lib3gkCarrier sub class
 *
 * @package       KtaiLibrary
 * @subpackage    KtaiLibrary.vendors.ecw
 */
class Lib3gkCarrier {
	
	//================================================================
	//Properties
	//================================================================
	//------------------------------------------------
	//Parameters
	//------------------------------------------------
	/**
	 * Ktai Libraryパラメータ
	 *
	 * @var array
	 * @access protected
	 */
	var $_params = array(
		'iphone_user_agent_belongs_to_ktai'      => false, 
		'iphone_user_agent_belongs_to_softbank'  => false, 
		'iphone_email_belongs_to_ktai_email'     => false, 
		'iphone_email_belongs_to_softbank_email' => false, 
		'android_user_agent_belongs_to_ktai'     => false, 
	);
	
	//------------------------------------------------
	//Machine information
	//------------------------------------------------
	/**
	 * キャリアコード
	 *
	 * @var integer
	 * @access protected
	 */
	var $_carrier      = null;
	
	/**
	 * キャリア名
	 *
	 * @var string
	 * @access protected
	 */
	var $_carrier_name = null;
	
	/**
	 * 端末名
	 *
	 * @var string
	 * @access protected
	 */
	var $_machine_name = null;
	
	
	//================================================================
	//Methods
	//================================================================
	//------------------------------------------------
	//Basics
	//------------------------------------------------
	/**
	 * インスタンスの取得
	 *
	 * @return object 自分自身のインスタンス
	 * @access public
	 * @static
	 */
	function &get_instance(){
		static $instance = array();
		if(!$instance){
			$instance[0] =& new Lib3gkCarrier();
			$instance[0]->initialize();
		}
		return $instance[0];
	}
	
	
	/**
	 * 初期化
	 *
	 * @return (なし)
	 * @access public
	 */
	function initialize(){
		$this->get_carrier();
	}
	
	
	/**
	 * 後始末
	 *
	 * @return (なし)
	 * @access public
	 */
	function shutdown(){
	}
	
	
	//------------------------------------------------
	//Lib3gkCarrier methods
	//------------------------------------------------
	/**
	 * ユーザエージェントの解析
	 *
	 * @param $user_agent string ユーザエージェント文字列
	 * @return array 端末情報
	 * @access public
	 */
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
			if(preg_match('_DoCoMo/2\.0\s([\w\+]+)\(_', $user_agent, $m)){
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
			if(preg_match('/KDDI\-([\w]+)\s/', $user_agent, $m)){
				$arr['machine_name'] = $m[1];
			}
		
		//EMOBILE
		//
		}else
		if(strpos($user_agent, 'emobile') !== false){
			$arr['carrier'] = KTAI_CARRIER_EMOBILE;
			$arr['carrier_name'] = 'emobile';
			if(preg_match('/\(([\w]+);/', $user_agent, $m)){
				$arr['machine_name'] = $m[1];
			}
		
		//iPhone
		//
		}else
		if(strpos($user_agent, 'iPhone') !== false){
			$arr['carrier'] = KTAI_CARRIER_IPHONE;
			$arr['carrier_name'] = 'iPhone';
			$arr['machine_name'] = 'default';
		
		//Android
		//
		}else
		if(strpos($user_agent, 'Android') !== false){
			$arr['carrier'] = KTAI_CARRIER_ANDROID;
			$arr['carrier_name'] = 'Android';
			$arr['machine_name'] = 'default';
		
		//PHS
		//
		}else
		if(strpos($user_agent, 'WILLCOM') !== false){
			$arr['carrier'] = KTAI_CARRIER_PHS;
			$arr['carrier_name'] = 'WILLCOM';
			if(preg_match('_WILLCOM;[\w]+/([A-Za-z0-9\-]+)/_', $user_agent, $m)){
				$arr['machine_name'] = $m[1];
			}
		}else
		if(strpos($user_agent, 'DDIPOCKET') !== false){
			$arr['carrier'] = KTAI_CARRIER_PHS;
			$arr['carrier_name'] = 'DDIPOCKET';
			$arr['machine_name'] = 'default';
			if(preg_match('_DDIPOCKET;[\w]+/([A-Za-z0-9\-]+)/_', $user_agent, $m)){
				$arr['machine_name'] = $m[1];
			}
		}
		
		return $arr;
	}
	
	
	/**
	 * キャリア番号の入手
	 *
	 * @param $user_agent string ユーザエージェント文字列
	 * @param $refresh boolean trueの場合は解析結果をキャッシュに反映させます
	 * @return integer キャリア番号
	 * @access public
	 */
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
	
	
	/**
	 * docomo端末かのチェック
	 *
	 * @return boolean trueの場合はdocomo端末
	 * @access public
	 */
	function is_imode(){
		return $this->get_carrier() == KTAI_CARRIER_DOCOMO;
	}
	
	
	/**
	 * SoftBank端末かのチェック
	 *
	 * @return boolean trueの場合はSoftBank端末
	 * @access public
	 */
	function is_softbank(){
		return $this->get_carrier() == KTAI_CARRIER_SOFTBANK || 
			($this->_params['iphone_user_agent_belongs_to_softbank'] && $this->is_iphone());
	}
	
	
	/**
	 * vodafone端末かのチェック
	 * ※レガシーな機能です。通常の判定にはis_softbank()を使ってください
	 *
	 * @return boolean trueの場合はvodafone端末
	 * @access public
	 */
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
	
	
	/**
	 * J-PHONE端末かのチェック
	 * ※レガシーな機能です。通常の判定にはis_softbank()を使ってください
	 *
	 * @return boolean trueの場合はJ-PHONE端末
	 * @access public
	 */
	function is_jphone(){
		$this->get_carrier();
		return strpos($_SERVER['HTTP_USER_AGENT'], 'J-PHONE') !== false;
	}
	
	
	/**
	 * AU端末かのチェック
	 *
	 * @return boolean trueの場合はAU端末
	 * @access public
	 */
	function is_ezweb(){
		return $this->get_carrier() == KTAI_CARRIER_KDDI;
	}
	
	
	/**
	 * EMOBILE端末かのチェック
	 * 詳しくはLib3gkCarrier::is_emobile()を参照
	 *
	 * @return boolean trueの場合はEMOBILE端末
	 * @access public
	 */
	function is_emobile(){
		return $this->get_carrier() == KTAI_CARRIER_EMOBILE;
	}
	
	
	/**
	 * iPhone端末かのチェック
	 * 詳しくはLib3gkCarrier::is_iphone()を参照
	 *
	 * @return boolean trueの場合はiPhone端末
	 * @access public
	 */
	function is_iphone(){
		return $this->get_carrier() == KTAI_CARRIER_IPHONE;
	}
	
	
	/**
	 * Android端末かのチェック
	 * 詳しくはLib3gkCarrier::is_Android()を参照
	 *
	 * @return boolean trueの場合はAndroid端末
	 * @access public
	 */
	function is_android(){
		return $this->get_carrier() == KTAI_CARRIER_ANDROID;
	}
	
	
	/**
	 * 携帯かチェック
	 *
	 * @return boolean trueの場合は携帯
	 * @access public
	 */
	function is_ktai(){
		return 	$this->is_imode() || 
				$this->is_softbank() || 
				$this->is_ezweb() || 
				$this->is_emobile() || 
				($this->_params['iphone_user_agent_belongs_to_ktai'] && $this->is_iphone()) ||
				($this->_params['android_user_agent_belongs_to_ktai'] && $this->is_android());
	}
	
	
	/**
	 * PHSかチェック
	 *
	 * @return boolean trueの場合はPHS
	 * @access public
	 */
	function is_phs(){
		return $this->get_carrier() == KTAI_CARRIER_PHS;
	}
	
	
	/**
	 * docomoのメールアドレスかチェック
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はdocomoのメールアドレス
	 * @access public
	 */
	function is_imode_email($email){
		return stripos($email, '@docomo.ne.jp') !== false;
	}
	
	
	/**
	 * SoftBankのメールアドレスかチェック
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はSoftBankのメールアドレス
	 * @access public
	 */
	function is_softbank_email($email){
		if(stripos($email, '@softbank.ne.jp') !== false) return true;
		if($this->_params['iphone_email_belongs_to_softbank_email'] && $this->is_iphone_email($email)) return true;
		return $this->is_vodafone_email($email);
	}
	
	
	/**
	 * iPhoneのメールアドレスかチェック
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はiPhoneのメールアドレス
	 * @access public
	 */
	function is_iphone_email($email){
		return stripos($email, '@i.softbank.jp') !== false;
	}
	
	
	/**
	 * vodafoneのメールアドレスかチェック
	 * ※レガシーな機能です。通常の判定にはis_softbank_email()を使ってください
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はvodafoneのメールアドレス
	 * @access public
	 */
	function is_vodafone_email($email){
		if(preg_match('/@[dhtckrsnq]\.vodafone\.ne\.jp/i', $email)) return true;
		return $this->is_jphone_email($email);
	}
	
	
	/**
	 * J-PHONEのメールアドレスかチェック
	 * ※レガシーな機能です。通常の判定にはis_softbank_email()を使ってください
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はJ-PHONEのメールアドレス
	 * @access public
	 */
	function is_jphone_email($email){
		return(preg_match('/@jp\-[dhtckrsnq]\.ne\.jp/i', $email)) ? true : false;
	}
	
	
	/**
	 * AUのメールアドレスかチェック
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はvodafoneのメールアドレス
	 * @access public
	 */
	function is_ezweb_email($email){
		return (stripos($email, '@ezweb.ne.jp') !== false) || 
			(preg_match('/@[a-z-]{2,10}\.biz\.ezweb\.ne\.jp/i', $email) ? true : false);
	}
	
	
	/**
	 * EMOBILEのメールアドレスかチェック
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はEMOBILEのメールアドレス
	 * @access public
	 */
	function is_emobile_email($email){
		return stripos($email, '@emnet.ne.jp') !== false;
	}
	
	
	/**
	 * 携帯のメールアドレスかチェック
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合は携帯のメールアドレス
	 * @access public
	 */
	function is_ktai_email($email){
		return 	$this->is_imode_email($email) || 
				$this->is_softbank_email($email) || 
				$this->is_ezweb_email($email) ||
				$this->is_emobile_email($email) ||
				($this->_params['iphone_email_belongs_to_ktai_email'] && $this->is_iphone_email($email));
	}
	
	
	/**
	 * PHSのメールアドレスかチェック
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はPHSのメールアドレス
	 * @access public
	 */
	function is_phs_email($email){
		if(preg_match('/@[\w]+\.pdx\.ne\.jp/i', $email)) return true;
		return stripos($email, '@willcom.com') !== false;
	}
	
	
	/**
	 * メールアドレスからキャリアコードの入手
	 *
	 * @param $email string メールアドレス
	 * @return integer キャリアコード
	 * @access public
	 */
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
	
	
}
