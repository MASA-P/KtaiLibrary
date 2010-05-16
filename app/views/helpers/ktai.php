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
 * @version			0.3.1
 * @lastmodified	$Date: 2010-05-17 02:00:00 +0900 (Mon, 17 May 2010) $
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
 *
 * @package       KtaiLibrary
 * @subpackage    KtaiLibrary.app.views.helpers
 */
class KtaiHelper extends Helper {
	
	//================================================================
	//Properties
	//================================================================
	/**
	 * 他のヘルパー
	 *
	 * @var array
	 * @access public
	 */
	var $helpers = array('Html');
	
	/**
	 * Lib3gkのインスタンス
	 *
	 * @var array
	 * @access public
	 */
	var $_lib3gk = null;
	
	/**
	 * Ktai Libraryパラメータ
	 *
	 * @var array
	 * @access protected
	 */
	var $options = array(
		'img_emoji_url' => "/img/emoticons/", 
		
		'output_auto_encoding' => false, 
		'output_auto_convert_emoji' => false, 
		'output_convert_kana' => false, 
	);
	
	//================================================================
	//Methods
	//================================================================
	//------------------------------------------------
	//Basics
	//------------------------------------------------
	/**
	 * beforeRenderコールバック
	 *
	 * @return (なし)
	 * @access public
	 */
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
	
	/**
	 * afterRenderコールバック
	 *
	 * @return (なし)
	 * @access public
	 */
	function afterRender(){
		
		parent::afterRender();
		
		var_dump($this->options);
		
		$out = ob_get_clean();
		$input_encoding  = $this->options['input_encoding'];
		$output_encoding = $this->options['output_encoding'];
		
		if($this->options['output_convert_kana'] != false){
			$out = mb_convert_kana(
				$out, 
				$this->options['output_convert_kana'], 
				$input_encoding
			);
		}
		
		if($this->options['output_auto_convert_emoji']){
			$this->convert_emoji($out);
		}else{
			if($this->options['output_auto_encoding'] && 
				($input_encoding != $output_encoding)){
				$out = mb_convert_encoding(
					$out, 
					$output_encoding, 
					$input_encoding
				);
			}
		}
		
		ob_start();
		echo $out;
		
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
	 * imageタグ付きの文字列を入手
	 * 詳しくはLib3gkHtml::image()を参照
	 *
	 * @param $url mixed URL
	 * @param $htmlAttribute array HTMLアトリビュート
	 * @param $stretch boolean trueで画像サイズをストレッチ
	 * @return string 生成されたHTMLタグ
	 * @access public
	 */
	function image($path, $htmlAttributes = array()){
		
		if(isset($htmlAttributes['width']) && isset($htmlAttributes['height'])){
			$arr = $this->_lib3gk->stretch_image_size($htmlAttributes['width'], $htmlAttributes['height']);
			$htmlAttributes['width']  = $arr[0];
			$htmlAttributes['height'] = $arr[1];
		}
		
		return $this->Html->image($path, $htmlAttributes);
	}
	
	/**
	 * CakePHP形式のリンク生成
	 *
	 * @param $title string リンクのタイトルテキスト
	 * @param $url mixed URL
	 * @param $htmlAttribute array HTMLアトリビュート
	 * @param $confirmMessage string 確認ダイアログ用のメッセージ(falseで表示しない)
	 * @param $escapeTitle boolean タイトルをエスケープしたくない場合はfalse
	 * @return string 生成されたHTMLタグ
	 * @access public
	 *
	 * ※htmlAttributeの値は基本的にCakePHP準拠ですが、次の値を拡張しています
	 *   'accesskey' 0～9を指定することで先頭に絵文字を挿入します
	 *
	 */
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
		return $this->_lib3gk->mailto($title, $email, $subject, $body, $input_encoding, $output_encoding, $display);
	}
	
	/**
	 * バージョンの入手
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
	function emoji($code, $disp = true, $carrier = null, $output_encoding = null, $binary = null){
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
		return $this->_lib3gk->get_qrcode($str, $options, $input_encoding, $output_encoding);
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
		return $this->_lib3gk->get_static_maps($lat, $lon, $options, $api_key);
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
		return $this->_lib3gk->style($name, $display);
	}
	
}
