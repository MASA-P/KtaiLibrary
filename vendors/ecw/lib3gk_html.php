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
 * Lib3gkHtml sub class
 *
 * @package       KtaiLibrary
 * @subpackage    KtaiLibrary.vendors.ecw
 */
class Lib3gkHtml {
	
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
	
	/**
	 * Lib3gkMachineのインスタンス
	 *
	 * @var object
	 * @access private
	 */
	var $__machine = null;
	
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
		
		//デフォルトのフォントサイズ
		//
		'default_font_size' => 'medium', 
	);
	
	/**
	 * Lib3gkHtml::url()のコールバック
	 *
	 * @var object
	 * @access protected
	 */
	var $_url_callback = null;
	
	
	/**
	 * 指定したフォントタグのスタック
	 *
	 * @var array
	 * @access private
	 */
	var $__fontTags = array();
	
	/**
	 * 各キャリアの対応フォントサイズテーブル
	 *
	 * @var array
	 * @access private
	 */
	var $__fontSizeTable = array(
		'low' => array(
			KTAI_CARRIER_KDDI => array('small' => '15px', 'medium' => '22px', 'large' => '32px'), 
		), 
		'high' => array(
			KTAI_CARRIER_DOCOMO => array('small' => 'medium', 'medium' => 'large', 'large' => 'x-large'), 
			KTAI_CARRIER_SOFTBANK => array('small' => 'medium', 'medium' => 'large', 'large' => 'x-large'), 
		), 
	);
	
	/**
	 * タグのテンプレート
	 *
	 * @var array
	 * @access private
	 */
	var $__fontTagBase = array('<%tag% style="font-size: %size%;%style%">', '</%tag%>');
	
	/**
	 * 各キャリアで使用するタグ
	 *
	 * @var array
	 * @access private
	 */
	var $__fontTagTable = array(
		KTAI_CARRIER_UNKNOWN => 'div', 
		KTAI_CARRIER_DOCOMO => 'div', 
		KTAI_CARRIER_KDDI => 'font', 
		KTAI_CARRIER_SOFTBANK => 'font', 
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
			$instance[0] =& new Lib3gkHtml();
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
		$this->_url_callback = array($this, '__url_callback_func');
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
	
	
	//------------------------------------------------
	//Lib3gkHtml methods
	//------------------------------------------------
	/**
	 * URLの生成
	 *
	 * @param $url mixed URL
	 * @return array 加工されたURL
	 * @access public
	 */
	function url($url){
		return call_user_func($this->_url_callback, $url);
	}
	
	
	/**
	 * URLの生成(デフォルトの処理)
	 *
	 * @param $url string URL
	 * @return array 加工されたURL
	 * @access public
	 */
	function __url_callback_func($url){
		return htmlspecialchars($url, ENT_QUOTES);
	}
	
	
	/**
	 * imageタグ付きの文字列を入手
	 *
	 * @param $url mixed URL
	 * @param $htmlAttribute array HTMLアトリビュート
	 * @param $stretch boolean trueで画像サイズをストレッチ
	 * @return string 生成されたHTMLタグ
	 * @access public
	 *
	 * $htmlAttributeのキーと値
	 *   'width' 幅
	 *   'height' 高さ
	 *
	 * ※その他キーについてもimgタグに付加します
	 */
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
	
	
	/**
	 * 指定のサイズの描画エリアにあった画像になるようストレッチの計算をする
	 *
	 * @param $width integer 画像の幅
	 * @param $height integer 画像の高さ
	 * @param $default_width integer 基本となる幅
	 * @param $default_height integer 基本となる高さ
	 * @return array 計算された画像の幅と高さ
	 * @access public
	 */
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
	
	
	/**
	 * 登録スタイルの呼び出し
	 * $this->_params['style']内に登録したスタイルを呼び出します
	 *
	 * @param $name string 登録スタイル名
	 * @param $display boolean trueでechoもする(デフォルト)
	 * @return string 入手したインラインスタイルシート文字列
	 * @access public
	 */
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
	
	
	/**
	 * QRコードの生成(Google chart APIの利用)
	 *
	 * @param $str string QRコード内に含める文字列(URLなど)
	 * @param $options array APIに与えるオプション
	 * @param $input_encoding integer 入力文字エンコーディングコード
	 * @param $output_encoding integer 出力文字エンコーディングコード
	 * @return string imageタグ付き文字列
	 * @access public
	 *
	 * ※パラメータについては下記URLを参照してください
	 * http://code.google.com/intl/ja/apis/chart/docs/gallery/qr_codes.html
	 
	 */
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
			$url .= '&chld='.$ec;
		}
		return $this->image($url, $options);
	}
	
	
	/**
	 * Google static Maps APIを用いて地図表示
	 *
	 * @param $lat string 緯度
	 * @param $lon string 経度
	 * @param $options array APIに与えるオプション
	 * @param $apikey string 取得したGoogle API キー
	 * @return string imageタグ付き文字列
	 * @access public
	 *
	 * ※パラメータについては下記URLを参照してください
	 * http://code.google.com/intl/ja/apis/maps/documentation/staticmaps/
	 
	 */
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
	
	/**
	 * 同サイズフォント指定
	 * 機種判別してフォントサイズの差異をなくします
	 * 
	 * ※XHTMLの場合のみ有効です
	 * 　フォントサイズは「small」「medium」「large」が指定可能。それ以外の値はそのまま出力します
	 * 　デフォルトは$__params['default_font_size']の値です。無指定の場合は「medium」です。
	 *
	 * @param $size string フォントのサイズ(small/medium/large)
	 * @param $tag string カスタムで使用するタグ(div, span, fontなど)
	 * @param $style string 付加するスタイル名。$ktai->style()で指定する値
	 * @param $display boolean trueでechoを自動で行う
	 * @return string フォント指定タグ
	 * @access public
	 *
	 */
	function font($size = null, $tag = null, $style = null, $display = true){
		
		if(!$this->_params['use_xml']){
			return null;
		}
		
		if($size === null){
			if(isset($this->_params['default_font_size'])){
				$size = $this->_params['default_font_size'];
			}else{
				$size = 'medium';
			}
		}
		
		if($style !== null){
			$style = $this->style($style, false);
		}
		
		$this->__load_machine();
		$machine = $this->__machine->get_machineinfo();
		$carrier = $machine['carrier'];
		
		if($tag === null){
			if($carrier == KTAI_CARRIER_DOCOMO || $carrier == KTAI_CARRIER_KDDI || $carrier == KTAI_CARRIER_SOFTBANK){
				$tag = $this->__fontTagTable[$carrier];
			}else{
				$tag = $this->__fontTagTable[KTAI_CARRIER_UNKNOWN];
			}
		}
		
		if($carrier != KTAI_CARRIER_DOCOMO && $carrier != KTAI_CARRIER_KDDI && $carrier != KTAI_CARRIER_SOFTBANK){
			$carrier = KTAI_CARRIER_DOCOMO;
		}
		
		$reso = 'low';
		if(isset($machine['font_size'])){
			if(isset($machine['font_size']['reso'])){
				$reso = $machine['font_size']['reso'];
				if(isset($this->__fontSizeTable[$reso][$carrier][$size])){
					$size = $this->__fontSizeTable[$reso][$carrier][$size];
				}
			}else
			if(isset($machine['font_size'][$size])){
				$size = $machine['font_size'][$size];
			}
		}else
		if(isset($this->__fontSizeTable[$reso][$carrier][$size])){
			$size = $this->__fontSizeTable[$reso][$carrier][$size];
		}
		
		$search = array('%tag%', '%size%', '%style%');
		$replace = array($tag, $size, $style);
		
		$result = str_replace($search, $replace, $this->__fontTagBase[0]);
		$this->__fontTags[] = str_replace('%tag%', $tag, $this->__fontTagBase[1]);
		
		if($display){
			echo $result;
		}
		return $result;
	}
	
	/**
	 * フォントタグの終端
	 * 直近に処理されたfont()に対応する閉じタグを出力します
	 *
	 * @param $display boolean trueでechoを自動で行う
	 * @return string フォント指定タグの閉じタグ
	 * @access public
	 *
	 */
	function fontend($display = true){
		
		$result = null;
		
		if(!empty($this->__fontTags)){
			$result = array_pop($this->__fontTags);
		}
		
		if($display){
			echo $result;
		}
		return $result;
	}
}
