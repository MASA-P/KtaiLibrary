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
 * defines
 */
require_once(dirname(__FILE__).'/lib3gk_def.php');


/**
 * Ktai Library class
 *
 * @package       KtaiLibrary
 * @subpackage    KtaiLibrary.vendors.ecw
 */
class Lib3gk {
	
	//================================================================
	//Properties
	//================================================================
	//------------------------------------------------
	//General informations
	//------------------------------------------------
	/**
	 * Ktai Libraryのバージョン
	 *
	 * @var string
	 * @access protected
	 */
	var $_version = '0.4.1';
	
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
	
	/**
	 * Lib3gkEmojiのインスタンス
	 *
	 * @var object
	 * @access private
	 */
	var $__emoji   = null;
	
	/**
	 * Lib3gkHtmlのインスタンス
	 *
	 * @var object
	 * @access private
	 */
	var $__html    = null;
	
	/**
	 * Lib3gkMachineのインスタンス
	 *
	 * @var object
	 * @access private
	 */
	var $__machine = null;
	
	/**
	 * Lib3gkIpのインスタンス
	 *
	 * @var object
	 * @access private
	 */
	var $__ip      = null;
	
	/**
	 * Lib3gkToolsのインスタンス
	 *
	 * @var object
	 * @access private
	 */
	var $__tools   = null;
	
	
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
			$instance[0] =& new Lib3gk();
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
		$this->_params = array_merge($this->__carrier->_params, $this->_params);
		$this->__carrier->_params = &$this->_params;
	}
	
	
	/**
	 * 絵文字関連サブクラスの読み込み
	 *
	 * @return (なし)
	 * @access private
	 */
	function __load_emoji(){
		if(!class_exists('lib3gkemoji')){
			require_once(dirname(__FILE__).'/lib3gk_emoji.php');
		}
		$this->__emoji = Lib3gkEmoji::get_instance();
		$this->_params = array_merge($this->__emoji->_params, $this->_params);
		$this->__emoji->_params = &$this->_params;
	}
	
	
	/**
	 * 機種情報関連サブクラスの読み込み
	 *
	 * @return (なし)
	 * @access private
	 */
	function __load_machine(){
		if(!class_exists('lib3gkmachine')){
			require_once(dirname(__FILE__).'/lib3gk_machine.php');
		}
		$this->__machine = Lib3gkMachine::get_instance();
	}
	
	
	/**
	 * HTML関連サブクラスの読み込み
	 *
	 * @return (なし)
	 * @access private
	 */
	function __load_html(){
		if(!class_exists('lib3gkhtml')){
			require_once(dirname(__FILE__).'/lib3gk_html.php');
		}
		$this->__html = Lib3gkHtml::get_instance();
		$this->_params = array_merge($this->__html->_params, $this->_params);
		$this->__html->_params = &$this->_params;
	}
	
	
	/**
	 * IP関連サブクラスの読み込み
	 *
	 * @return (なし)
	 * @access private
	 */
	function __load_ip(){
		if(!class_exists('lib3gkip')){
			require_once(dirname(__FILE__).'/lib3gk_ip.php');
		}
		$this->__ip = Lib3gkIp::get_instance();
	}
	
	
	/**
	 * その他サブクラスの読み込み
	 *
	 * @return (なし)
	 * @access private
	 */
	function __load_tools(){
		if(!class_exists('lib3gktools')){
			require_once(dirname(__FILE__).'/lib3gk_tools.php');
		}
		$this->__tools = Lib3gkTools::get_instance();
		$this->_params = array_merge($this->__tools->_params, $this->_params);
		$this->__tools->_params = &$this->_params;
	}
	
	
	//------------------------------------------------
	//Lib3gk methods
	//------------------------------------------------
	/**
	 * バージョンの入手
	 *
	 * @return string バージョン番号
	 * @access public
	 */
	function get_version(){
		return $this->_version;
	}
	
	
	/**
	 * リダイレクト処理
	 * URLを解析して、適切なURLに変更します。
	 * docomoの場合は、セッションキーを付加します。
	 *
	 * @param $url string URL
	 * @param $exit bool リダイレクト処理後exit()を実行する場合はtrue
	 * @return (なし)
	 * @access public
	 */
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
	
	//------------------------------------------------
	//Lib3gkCarrier wrapping methods.
	//------------------------------------------------
	/**
	 * ユーザエージェントの解析
	 * 詳しくはLib3gkCarrier::analyze_user_agent()を参照
	 *
	 * @param $user_agent string ユーザエージェント文字列
	 * @return array 端末情報
	 * @access public
	 */
	function analyze_user_agent($user_agent = null){
		$this->__load_carrier();
		return $this->__carrier->analyze_user_agent($user_agent);
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
		$this->__load_carrier();
		return $this->__carrier->get_carrier($user_agent, $refresh);
	}
	
	
	/**
	 * docomo端末かのチェック
	 * 詳しくはLib3gkCarrier::is_imode()を参照
	 *
	 * @return boolean trueの場合はdocomo端末
	 * @access public
	 */
	function is_imode(){
		$this->__load_carrier();
		return $this->__carrier->is_imode();
	}
	
	
	/**
	 * SoftBank端末かのチェック
	 * 詳しくはLib3gkCarrier::is_softbank()を参照
	 *
	 * @return boolean trueの場合はSoftBank端末
	 * @access public
	 */
	function is_softbank(){
		$this->__load_carrier();
		return $this->__carrier->is_softbank();
	}
	
	
	/**
	 * vodafone端末かのチェック
	 * 詳しくはLib3gkCarrier::is_vodafone()を参照
	 *
	 * @return boolean trueの場合はvodafone端末
	 * @access public
	 */
	function is_vodafone(){
		$this->__load_carrier();
		return $this->__carrier->is_vodafone();
	}
	
	
	/**
	 * J-PHONE端末かのチェック
	 * 詳しくはLib3gkCarrier::is_jphone()を参照
	 *
	 * @return boolean trueの場合はJ-PHONE端末
	 * @access public
	 */
	function is_jphone(){
		$this->__load_carrier();
		return $this->__carrier->is_jphone();
	}
	
	
	/**
	 * AU端末かのチェック
	 * 詳しくはLib3gkCarrier::is_ezweb()を参照
	 *
	 * @return boolean trueの場合はAU端末
	 * @access public
	 */
	function is_ezweb(){
		$this->__load_carrier();
		return $this->__carrier->is_ezweb();
	}
	
	
	/**
	 * EMOBILE端末かのチェック
	 * 詳しくはLib3gkCarrier::is_emobile()を参照
	 *
	 * @return boolean trueの場合はEMOBILE端末
	 * @access public
	 */
	function is_emobile(){
		$this->__load_carrier();
		return $this->__carrier->is_emobile();
	}
	
	
	/**
	 * iPhone端末かのチェック
	 * 詳しくはLib3gkCarrier::is_iphone()を参照
	 *
	 * @return boolean trueの場合はiPhone端末
	 * @access public
	 */
	function is_iphone(){
		$this->__load_carrier();
		return $this->__carrier->is_iphone();
	}
	
	
	/**
	 * Android端末かのチェック
	 * 詳しくはLib3gkCarrier::is_android()を参照
	 *
	 * @return boolean trueの場合はAndroid端末
	 * @access public
	 */
	function is_android(){
		$this->__load_carrier();
		return $this->__carrier->is_android();
	}
	
	
	/**
	 * 携帯かチェック
	 * 詳しくはLib3gkCarrier::is_ktai()を参照
	 *
	 * @return boolean trueの場合は携帯
	 * @access public
	 */
	function is_ktai(){
		$this->__load_carrier();
		return $this->__carrier->is_ktai();
	}
	
	
	/**
	 * PHSかチェック
	 * 詳しくはLib3gkCarrier::is_phs()を参照
	 *
	 * @return boolean trueの場合はPHS
	 * @access public
	 */
	function is_phs(){
		$this->__load_carrier();
		return $this->__carrier->is_phs();
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
		$this->__load_carrier();
		return $this->__carrier->is_imode_email($email);
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
		$this->__load_carrier();
		return $this->__carrier->is_softbank_email($email);
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
		$this->__load_carrier();
		return $this->__carrier->is_vodafone_email($email);
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
		$this->__load_carrier();
		return $this->__carrier->is_jphone_email($email);
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
		$this->__load_carrier();
		return $this->__carrier->is_ezweb_email($email);
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
		$this->__load_carrier();
		return $this->__carrier->is_emobile_email($email);
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
		$this->__load_carrier();
		return $this->__carrier->is_iphone_email($email);
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
		$this->__load_carrier();
		return $this->__carrier->is_ktai_email($email);
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
		$this->__load_carrier();
		return $this->__carrier->is_phs_email($email);
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
		$this->__load_carrier();
		return $this->__carrier->get_email_carrier($email);
	}
	
	
	//------------------------------------------------
	//Lib3gkEmoji wrapping methods.
	//------------------------------------------------
	/**
	 * 画像絵文字の作成
	 * 詳しくはLib3gkEmoji::create_image_emoji()を参照
	 *
	 * @param $name string 絵文字名(画像絵文字のファイル名(拡張子なし))
	 * @return string imgタグ付きの画像絵文字
	 * @access public
	 */
	function create_image_emoji($name){
		$this->__load_emoji();
		return $this->__emoji->create_image_emoji($name);
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
	function emoji($code, $disp = true, $carrier = null, $output_encoding = null, $binary = null){
		$this->__load_emoji();
		return $this->__emoji->emoji($code, $disp, $carrier, $output_encoding, $binary);
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
		$this->__load_emoji();
		return $this->__emoji->convert_emoji($str, $carrier, $input_encoding, $output_encoding, $binary);
	}
	
	
	//------------------------------------------------
	//Lib3gkMachine wrapping methods.
	//------------------------------------------------
	/**
	 * 機種情報の入手
	 * 詳しくはLib3gkMachine::get_machineinfo()を参照
	 *
	 * @param $carrier_name string キャリア名
	 * @param $machine_name string 端末名
	 * @return array 端末情報
	 * @access public
	 */
	function get_machineinfo($carrier_name = null, $machine_name = null){
		$this->__load_machine();
		return $this->__machine->get_machineinfo($carrier_name, $machine_name);
	}
	
	
	//------------------------------------------------
	//Lib3gkHtml wrapping methods.
	//------------------------------------------------
	/**
	 * URLの生成
	 * 詳しくはLib3gkHtml::url()を参照
	 *
	 * @param $url mixed URL
	 * @return array 加工されたURL
	 * @access public
	 */
	function url($url){
		$this->__load_html();
		return $this->__html->url($url);
	}
	
	
	/**
	 * imageタグ付きの文字列を入手
	 * 詳しくはLib3gkHtml::image()を参照
	 *
	 * @param $url mixed URL
	 * @param $htmlAttribute array HTMLアトリビュート
	 * @return string 生成されたHTMLタグ
	 * @access public
	 */
	function image($url, $htmlAttribute = array()){
		$this->__load_html();
		return $this->__html->image($url, $htmlAttribute);
	}
	
	
	/**
	 * 指定のサイズの描画エリアにあった画像になるようストレッチの計算をする
	 * 詳しくはLib3gkHtml::stretch_image_size()を参照
	 *
	 * @param $width integer 画像の幅
	 * @param $height integer 画像の高さ
	 * @param $default_width integer 基本となる幅
	 * @param $default_height integer 基本となる高さ
	 * @return array 計算された画像の幅と高さ
	 * @access public
	 */
	function stretch_image_size($width, $height, $default_width = null, $default_height = null){
		$this->__load_html();
		return $this->__html->stretch_image_size($width, $height, $default_width, $default_height);
	}
	
	
	/**
	 * 登録スタイルの呼び出し
	 * 詳しくはLib3gkHtml::style()を参照
	 *
	 * @param $name string 登録スタイル名
	 * @param $display boolean trueでechoもする(デフォルト)
	 * @return string 入手したインラインスタイルシート文字列
	 * @access public
	 */
	function style($name, $display = true){
		$this->__load_html();
		return $this->__html->style($name, $display);
	}
	
	
	/**
	 * 機種に最適のフォント指定を行う
	 * 詳しくはLib3gkHtml::font()を参照
	 *
	 * @param $size string フォントのサイズ(small/medium/large)
	 * @param $tag string カスタムで使用するタグ(div, span, fontなど)
	 * @param $style string 付加するスタイル名。$ktai->style()で指定する値
	 * @param $display boolean trueでechoを自動で行う
	 * @return string フォント指定タグ
	 * @access public
	 */
	function font($size = null, $tag = null, $style = null, $display = true){
		$this->__load_html();
		return $this->__html->font($size, $tag, $style, $display);
	}
	
	/**
	 * font()で生成したタグの閉じタグを生成
	 * 詳しくはLib3gkHtml::fontend()を参照
	 *
	 * @param $display boolean trueでechoを自動で行う
	 * @return string フォント指定タグの閉じタグ
	 * @access public
	 */
	function fontend($display = true){
		$this->__load_html();
		return $this->__html->fontend($display);
	}
	
	/**
	 * QRコードの生成(Google chart APIの利用)
	 * 詳しくはLib3gkHtml::get_qrcode()を参照
	 *
	 * @param $str string QRコード内に含める文字列(URLなど)
	 * @param $options array APIに与えるオプション
	 * @param $input_encoding integer 入力文字エンコーディングコード
	 * @param $output_encoding integer 出力文字エンコーディングコード
	 * @return string imageタグ付き文字列
	 * @access public
	 */
	function get_qrcode($str, $options = array(), $input_encoding = null, $output_encoding = null){
		$this->__load_html();
		return $this->__html->get_qrcode($str, $options, $input_encoding, $output_encoding);
	}
	
	
	/**
	 * Google static Maps APIを用いて地図表示
	 * 詳しくはLib3gkHtml::get_static_maps()を参照
	 *
	 * @param $lat string 緯度
	 * @param $lon string 経度
	 * @param $options array APIに与えるオプション
	 * @param $apikey string 取得したGoogle API キー
	 * @return string imageタグ付き文字列
	 * @access public
	 */
	function get_static_maps($lat, $lon, $options = array(), $api_key = null){
		$this->__load_html();
		return $this->__html->get_static_maps($lat, $lon, $options, $api_key);
	}
	
	
	//------------------------------------------------
	//Lib3gkIp wrapping methods.
	//------------------------------------------------
	/**
	 * IPアドレスを数値に変換
	 * 詳しくはLib3gkIp::ip2long()を参照
	 *
	 * @param $ip string IPアドレス(xxx.xxx.xxx.xxx[/xx])
	 * @return integer IPアドレスを32ビット数値にしたもの
	 * @access public
	 */
	function ip2long($ip){
		$this->__load_ip();
		return $this->__ip->ip2long($ip);
	}
	
	
	/**
	 * IPアドレスが範囲内にあるかのチェック
	 * 詳しくはLib3gkIp::is_inclusive()を参照
	 *
	 * @param $ip string IPアドレス(xxx.xxx.xxx.xxx)
	 * @param $ip string 対象IP領域(xxx.xxx.xxx.xxx[/xx])
	 * @return boolean 範囲内の場合はtrue
	 * @access public
	 */
	function is_inclusive($ip, $check_addr){
		$this->__load_ip();
		return $this->__ip->is_inclusive($ip, $check_addr);
	}
	
	
	/**
	 * IPアドレスからキャリアコードを入手
	 * 詳しくはLib3gkIp::ip2carrier()を参照
	 *
	 * @param $ip string IPアドレス(xxx.xxx.xxx.xxx)
	 * @return integer キャリアコード
	 * @access public
	 */
	function get_ip_carrier($ip = null){
		$this->__load_ip();
		return $this->__ip->ip2carrier($ip);
	}
	
	
	//------------------------------------------------
	//Lib3gkTools wrapping methods.
	//------------------------------------------------
	/**
	 * 数値からバイナリコードを入手
	 * 詳しくはLib3gkTools::int2str()を参照
	 *
	 * @param $value integer アスキーコード(2バイト対応)
	 * @return str バイナリコード
	 * @access public
	 */
	function int2str($value){
		$this->__load_tools();
		return $this->__tools->int2str($value);
	}
	
	
	/**
	 * UNICODE数値からUTF-8バイナリコードを入手
	 * 詳しくはLib3gkTools::int2utf8()を参照
	 *
	 * @param $value integer UNICODEのアスキーコード
	 * @return str UTF-8バイナリコード
	 * @access public
	 */
	function int2utf8($value){
		$this->__load_tools();
		return $this->__tools->int2utf8($value);
	}
	
	
	/**
	 * バイナリコードから数値を入手
	 * 詳しくはLib3gkTools::str2int()を参照
	 *
	 * @param $str integer バイナリコード
	 * @return integer アスキーコード
	 * @access public
	 */
	function str2int($str){
		$this->__load_tools();
		return $this->__tools->str2int($str);
	}
	
	
	/**
	 * UTF-8からUNICODE数値バイナリコードを入手
	 * 詳しくはLib3gkTools::utf82int()を参照
	 *
	 * @param $str string UTF-8バイナリコード
	 * @return integer UNICODEのアスキーコード
	 * @access public
	 */
	function utf82int($str){
		$this->__load_tools();
		return $this->__tools->utf82int($str);
	}
	
	
	/**
	 * 文字エンコーディング名を正規化する
	 * 詳しくはLib3gkTools::normal_encoding_str()を参照
	 *
	 * @param $str string 正規化した文字エンコーディング名
	 * @return string 正規化された文字エンコーディング名
	 * @access public
	 */
	function normal_encoding_str($str){
		$this->__load_tools();
		return $this->__tools->normal_encoding_str($str);
	}
	
	
	/**
	 * mailtoリンクの作成
	 * 詳しくはLib3gkTools::mailto()を参照
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
		$this->__load_tools();
		return $this->__tools->mailto($title, $email, $subject, $body, $input_encoding, $output_encoding, $display);
	}
	
	
	/**
	 * 端末UIDの入手
	 * 詳しくはLib3gkTools::get_uid()を参照
	 *
	 * @return string 端末UID
	 * @access public
	 */
	function get_uid(){
		$this->__load_tools();
		return $this->__tools->get_uid();
	}
	
	
}
