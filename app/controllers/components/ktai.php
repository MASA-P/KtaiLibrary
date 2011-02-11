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
 * includes
 */
if(!class_exists('lib3gk')){
	App::import('Vendor', 'ecw'.DS.'Lib3gk');
}

/**
 * Ktai component class for CakePHP
 *
 * @package       KtaiLibrary
 * @subpackage    KtaiLibrary.app.controllers.components
 */
class KtaiComponent extends Object {
	
	//================================================================
	//Properties
	//================================================================
	/**
	 * Lib3gkのインスタンス
	 *
	 * @var object
	 * @access protected
	 */
	var $_lib3gk = null;
	
	/**
	 * コントローラのインスタンス
	 *
	 * @var object
	 * @access protected
	 */
	var $_controller = null;
	
	/**
	 * Ktai Libraryパラメータ
	 *
	 * @var array
	 * @access protected
	 */
	var $_options = array(
		'enable_ktai_session' => true, 
		'use_redirect_session_id' => false, 
		'imode_session_name' => 'csid', 
		'session_save' => 'php', 
		
		'output_auto_encoding' => false, 
		'output_auto_convert_emoji' => false, 
		'output_convert_kana' => false, 
		
		'img_emoji_url' => "/img/emoticons/", 
		
		'use_xml' => false, 
	);
	
	
	//================================================================
	//Methods
	//================================================================
	//------------------------------------------------
	//Basics
	//------------------------------------------------
	/**
	 * initializeコールバック
	 *
	 * @param $controller object& コントローラのインスタンス
	 * @return (なし)
	 * @access public
	 */
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
	
	
	/**
	 * beforeRenderコールバック
	 *
	 * @param $controller object& コントローラのインスタンス
	 * @return (なし)
	 * @access public
	 */
	function beforeRender(&$controller){
		if(isset($controller->ktai)){
			Configure::write('Ktai', $this->_options);
		}
		if($this->_options['use_xml'] && $this->is_imode() && Configure::read('debug') == 0){
			header('Content-type: application/xhtml+xml');
		}
	}
	
	
	/**
	 * shutdownコールバック
	 *
	 * @param $controller object& コントローラのインスタンス
	 * @return (なし)
	 * @access public
	 */
	function shutdown(&$controller){
		
		$out = $controller->output;
		
		$input_encoding  = $this->_options['input_encoding'];
		$output_encoding = $this->_options['output_encoding'];
		
		if($this->_options['output_convert_kana'] != false){
			$out = mb_convert_kana(
				$out, 
				$this->_options['output_convert_kana'], 
				$input_encoding
			);
		}
		
		if($this->_options['output_auto_convert_emoji']){
			$this->convert_emoji($out);
		}else{
			if($this->_options['output_auto_encoding'] && 
				($input_encoding != $output_encoding)){
				$out = mb_convert_encoding(
					$out, 
					$output_encoding, 
					$input_encoding
				);
			}
		}
		
		$controller->output = $out;
	
		$this->_lib3gk->shutdown();
	}
	
	
	//------------------------------------------------
	//Ktai Library methods
	//------------------------------------------------
	/**
	 * URLの生成
	 *
	 * @param $url string URL
	 * @return array 加工されたURL
	 * @access public
	 */
	function url_callback_func($url){
		return Router::url($url);
	}
	
	
	/**
	 * バージョンの入手
	 * 詳しくはLib3gk::get_version()を参照
	 *
	 * @return string バージョン番号
	 * @access public
	 */
	function get_version(){
		return $this->_lib3gk->get_version();
	}
	
	
	/**
	 * ユーザエージェントの解析
	 * 詳しくはLib3gkCarrier::analyze_user_agent()を参照
	 *
	 * @param $user_agent string ユーザエージェント文字列
	 * @return array 端末情報
	 * @access public
	 */
	function analyze_user_agent($user_agent = null){
		return $this->_lib3gk->analyze_user_agent($user_agent);
	}
	
	
	/**
	 * キャリア番号の入手
	 * 詳しくはLib3gkCarrier::get_carrier()を参照
	 *
	 * @param $user_agent string ユーザエージェント文字列
	 * @param $refresh boolean trueの場合は解析結果をキャッシュに反映させます
	 * @return integer キャリア番号
	 * @access public
	 */
	function get_carrier($user_agent = null, $refresh = false){
		return $this->_lib3gk->get_carrier($user_agent, $refresh);
	}
	
	
	/**
	 * docomo端末かのチェック
	 * 詳しくはLib3gkCarrier::is_imode()を参照
	 *
	 * @return boolean trueの場合はdocomo端末
	 * @access public
	 */
	function is_imode(){
		return $this->_lib3gk->is_imode();
	}
	
	
	/**
	 * SoftBank端末かのチェック
	 * 詳しくはLib3gkCarrier::is_softbank()を参照
	 *
	 * @return boolean trueの場合はSoftBank端末
	 * @access public
	 */
	function is_softbank(){
		return $this->_lib3gk->is_softbank();
	}
	
	
	/**
	 * vodafone端末かのチェック
	 * 詳しくはLib3gkCarrier::is_vodafone()を参照
	 *
	 * @return boolean trueの場合はvodafone端末
	 * @access public
	 */
	function is_vodafone(){
		return $this->_lib3gk->is_vodafone();
	}
	
	
	/**
	 * J-PHONE端末かのチェック
	 * 詳しくはLib3gkCarrier::is_jphone()を参照
	 *
	 * @return boolean trueの場合はJ-PHONE端末
	 * @access public
	 */
	function is_jphone(){
		return $this->_lib3gk->is_jphone();
	}
	
	
	/**
	 * AU端末かのチェック
	 * 詳しくはLib3gkCarrier::is_ezweb()を参照
	 *
	 * @return boolean trueの場合はAU端末
	 * @access public
	 */
	function is_ezweb(){
		return $this->_lib3gk->is_ezweb();
	}
	
	
	/**
	 * EMOBILE端末かのチェック
	 * 詳しくはLib3gkCarrier::is_emobile()を参照
	 *
	 * @return boolean trueの場合はEMOBILE端末
	 * @access public
	 */
	function is_emobile(){
		return $this->_lib3gk->is_emobile();
	}
	
	
	/**
	 * iPhone端末かのチェック
	 * 詳しくはLib3gkCarrier::is_iphone()を参照
	 *
	 * @return boolean trueの場合はiPhone端末
	 * @access public
	 */
	function is_iphone(){
		return $this->_lib3gk->is_iphone();
	}
	
	
	/**
	 * Android端末かのチェック
	 * 詳しくはLib3gkCarrier::is_android()を参照
	 *
	 * @return boolean trueの場合はAndroid端末
	 * @access public
	 */
	function is_android(){
		return $this->_lib3gk->is_android();
	}
	
	
	/**
	 * 携帯かチェック
	 * 詳しくはLib3gkCarrier::is_ktai()を参照
	 *
	 * @return boolean trueの場合は携帯
	 * @access public
	 */
	function is_ktai(){
		return $this->_lib3gk->is_ktai();
	}
	
	
	/**
	 * PHSかチェック
	 * 詳しくはLib3gkCarrier::is_phs()を参照
	 *
	 * @return boolean trueの場合はPHS
	 * @access public
	 */
	function is_phs(){
		return $this->_lib3gk->is_phs();
	}
	
	
	/**
	 * docomoのメールアドレスかチェック
	 * 詳しくはLib3gkCarrier::is_imode_email()を参照
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はdocomoのメールアドレス
	 * @access public
	 */
	function is_imode_email($email){
		return $this->_lib3gk->is_imode_email($email);
	}
	
	
	/**
	 * SoftBankのメールアドレスかチェック
	 * 詳しくはLib3gkCarrier::is_softbank_email()を参照
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はSoftBankのメールアドレス
	 * @access public
	 */
	function is_softbank_email($email){
		return $this->_lib3gk->is_softbank_email($email);
	}
	
	
	/**
	 * vodafoneのメールアドレスかチェック
	 * 詳しくはLib3gkCarrier::is_vodafone_email()を参照
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はvodafoneのメールアドレス
	 * @access public
	 */
	function is_vodafone_email($email){
		return $this->_lib3gk->is_vodafone_email($email);
	}
	
	
	/**
	 * J-PHONEのメールアドレスかチェック
	 * 詳しくはLib3gkCarrier::is_jphone_email()を参照
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はJ-PHONEのメールアドレス
	 * @access public
	 */
	function is_jphone_email($email){
		return $this->_lib3gk->is_jphone_email($email);
	}
	
	
	/**
	 * AUのメールアドレスかチェック
	 * 詳しくはLib3gkCarrier::is_ezweb_email()を参照
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はvodafoneのメールアドレス
	 * @access public
	 */
	function is_ezweb_email($email){
		return $this->_lib3gk->is_ezweb_email($email);
	}
	
	
	/**
	 * EMOBILEのメールアドレスかチェック
	 * 詳しくはLib3gkCarrier::is_emobile_email()を参照
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はEMOBILEのメールアドレス
	 * @access public
	 */
	function is_emobile_email($email){
		return $this->_lib3gk->is_emobile_email($email);
	}
	
	
	/**
	 * iPhoneのメールアドレスかチェック
	 * 詳しくはLib3gkCarrier::is_iphone_email()を参照
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はiPhoneのメールアドレス
	 * @access public
	 */
	function is_iphone_email($email){
		return $this->_lib3gk->is_iphone_email($email);
	}
	
	
	/**
	 * 携帯のメールアドレスかチェック
	 * 詳しくはLib3gkCarrier::is_ktai_email()を参照
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合は携帯のメールアドレス
	 * @access public
	 */
	function is_ktai_email($email){
		return $this->_lib3gk->is_ktai_email($email);
	}
	
	
	/**
	 * PHSのメールアドレスかチェック
	 * 詳しくはLib3gkCarrier::is_phs_email()を参照
	 *
	 * @param $email string メールアドレス
	 * @return boolean trueの場合はPHSのメールアドレス
	 * @access public
	 */
	function is_phs_email($email){
		return $this->_lib3gk->is_phs_email($email);
	}
	
	
	/**
	 * メールアドレスからキャリアコードの入手
	 * 詳しくはLib3gkCarrier::get_email_carrier()を参照
	 *
	 * @param $email string メールアドレス
	 * @return integer キャリアコード
	 * @access public
	 */
	function get_email_carrier($email){
		return $this->_lib3gk->get_email_carrier($email);
	}
	
	
	/**
	 * 絵文字の入手
	 * 詳しくはLib3gkEmoji::emoji()を参照
	 *
	 * @param $code mixed 絵文字コード(数値)もしくはバイナリ文字
	 * @param $disp boolean trueの場合、echoを行う(デフォルト)
	 * @param $carrier integer キャリアコード
	 * @param $input_encoding integer 入力エンコーディング
	 * @param $output_encoding integer 出力エンコーディング
	 * @param $binary boolean trueの場合はバイナリ出力
	 * @return string 絵文字(バイナリ・数値文字参照・imageタグ)
	 * @access public
	 */
	function emoji($code, $disp = true, $carrier = null, $input_encoding = null, $output_encoding = null, $binary = null){
		return $this->_lib3gk->emoji($code, $disp, $carrier, $output_encoding, $binary);
	}
	
	
	/**
	 * 絵文字変換
	 * 詳しくはLib3gkEmoji::convert_moji()を参照
	 *
	 * @param $code string& コンバート文字列
	 * @param $disp boolean trueの場合、echoを行う(デフォルト)
	 * @param $carrier integer キャリアコード
	 * @param $input_encoding integer 入力エンコーディング
	 * @param $output_encoding integer 出力エンコーディング
	 * @param $binary boolean trueの場合はバイナリ出力
	 * @return (なし)
	 * @access public
	 */
	function convert_emoji(&$str, $carrier = null, $input_encoding = null, $output_encoding = null, $binary = null){
		return $this->_lib3gk->convert_emoji($str, $carrier, $input_encoding, $output_encoding, $binary);
	}
	
	
	/**
	 * 機種情報の入手
	 * 詳しくはLib3gkMachine::get_machineinfo()を参照
	 *
	 * @param $carrier_name string キャリア名
	 * @param $machine_name string 端末名
	 * @return array 端末情報
	 * @access public
	 */
	function get_machineinfo($carrier = null, $name = null){
		return $this->_lib3gk->get_machineinfo($carrier, $name);
	}
	
	
	/**
	 * 端末UIDの入手
	 * 詳しくはLib3gkTools::get_uid()を参照
	 *
	 * @return string 端末UID
	 * @access public
	 */
	function get_uid(){
		return $this->_lib3gk->get_uid();
	}
	
	
}
