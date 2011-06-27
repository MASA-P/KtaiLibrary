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

/**
 * Lib3gkTools sub class
 *
 * @package       KtaiLibrary
 * @subpackage    KtaiLibrary.vendors.ecw
 */
class Lib3gkTools {
	
	//================================================================
	//Properties
	//================================================================
	//------------------------------------------------
	//Library sub classes
	//------------------------------------------------
	/**
	 * Lib3gkCarrierのインスタンス
	 *
	 * @var object
	 * @access private
	 */
	var $__carrier = null;
	
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
		'input_encoding' => 'UTF-8', 
		'output_encoding' => 'UTF-8', 
	);
	
	
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
			$instance[0] =& new Lib3gkTools();
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
	//Load subclasses
	//------------------------------------------------
	/**
	 * キャリア関連サブクラスの読み込み
	 *
	 * @return (なし)
	 * @access private
	 */
	function __load_carrier(){
		if(!class_exists('lib3gkecarrier')){
			require_once(dirname(__FILE__).'/lib3gk_carrier.php');
		}
		$this->__carrier = Lib3gkCarrier::get_instance();
		$this->_params = array_merge($this->_params, $this->__carrier->_params);
		$this->__carrier->_params = &$this->_params;
	}
	
	
	//------------------------------------------------
	//Lib3gkTools methods
	//------------------------------------------------
	/**
	 * 数値からバイナリコードを入手
	 *
	 * @param $value integer アスキーコード(2バイト対応)
	 * @return str バイナリコード
	 * @access public
	 */
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
	
	
	/**
	 * UNICODE数値からUTF-8バイナリコードを入手
	 *
	 * @param $value integer UNICODEのアスキーコード
	 * @return str UTF-8バイナリコード
	 * @access public
	 */
	function int2utf8($value){
		$str = call_user_func(array(__CLASS__, 'int2str'), $value);
		if($str === false){
			return false;
		}
		return mb_convert_encoding($str, 'UTF-8', 'Unicode');
	}
	
	
	/**
	 * バイナリコードから数値を入手
	 *
	 * @param $str integer バイナリコード
	 * @return integer アスキーコード
	 * @access public
	 */
	function str2int($str){
		if(strlen($str) != 2){
			return false;
		}
		$arr = unpack('n', $str);
		$value = array_shift($arr);
		return $value >= 256 ? $value : false;
	}
	
	
	/**
	 * UTF-8からUNICODE数値バイナリコードを入手
	 *
	 * @param $str string UTF-8バイナリコード
	 * @return integer UNICODEのアスキーコード
	 * @access public
	 */
	function utf82int($str){
		$str = mb_convert_encoding($str, 'Unicode', 'UTF-8');
		return call_user_func(array(__CLASS__, 'str2int'), $str);
	}
	
	
	/**
	 * 文字エンコーディング名を正規化する
	 *
	 * @param $str string 正規化した文字エンコーディング名
	 * @return string 正規化された文字エンコーディング名
	 * @access public
	 */
	function normal_encoding_str($str){
		$enc = mb_internal_encoding();
		
		mb_internal_encoding($str);
		$str = mb_internal_encoding();
		
		mb_internal_encoding($enc);
		
		return $str;
	}
	
	
	/**
	 * mailtoリンクの作成
	 *
	 * @param $title string リンクのタイトル文字列
	 * @param $email string 宛先メールアドレス
	 * @param $subject string メールの題名
	 * @param $body string 本文
	 * @param $input_encoding integer 入力文字エンコーディングコード
	 * @param $output_encoding integer 出力文字エンコーディングコード
	 * @param $display boolean trueでecho出力(デフォルト)
	 * @return string aタグ付きのmailto文字列
	 * @access public
	 */
	function mailto($title, $email, $subject = null, $body = null, $input_encoding = null, $output_encoding = null, $display = true){
		
		$this->__load_carrier();
		
		if($input_encoding === null){
			$input_encoding = $this->_params['input_encoding'];
		}
		$input_encoding = $this->normal_encoding_str($input_encoding);
		
		if($output_encoding === null){
			$output_encoding = $this->_params['output_encoding'];
		}
		$output_encoding = $this->normal_encoding_str($output_encoding);
		
		if($this->__carrier->is_iphone()){
			$subject = mb_ereg_replace("\r", "", $subject);
			$subject = mb_ereg_replace("\n", "%0D%0A", $subject);
			$body = mb_ereg_replace("\r", "", $body);
			$body = mb_ereg_replace("\n", "%0D%0A", $body);
		}else
		if($this->__carrier->is_softbank()){
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
	
	
	/**
	 * 端末UIDの入手
	 *
	 * @return string 端末UID
	 * @access public
	 */
	function get_uid(){
		
		$this->__load_carrier();
		
		$uid = false;
		
		if($this->__carrier->is_imode()){
			if(isset($_SERVER['HTTP_X_DCMGUID'])){
				$uid = $_SERVER['HTTP_X_DCMGUID'];
			}
		}else
		if($this->__carrier->is_ezweb()){
			if(isset($_SERVER['HTTP_X_UP_SUBNO'])){
				$uid = $_SERVER['HTTP_X_UP_SUBNO'];
			}
		}else
		if($this->__carrier->is_softbank() && !$this->__carrier->is_iphone()){
			if(isset($_SERVER['HTTP_X_JPHONE_UID'])){
				$uid = $_SERVER['HTTP_X_JPHONE_UID'];
			}
		}else
		if($this->__carrier->is_emobile()){
			if(isset($_SERVER['HTTP_X_EM_UID'])){
				$uid = $_SERVER['HTTP_X_EM_UID'];
			}
		}
		
		return $uid;
	}
	
}
