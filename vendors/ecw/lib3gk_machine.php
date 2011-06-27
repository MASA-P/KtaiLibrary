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
 * Lib3gkMachine sub class
 *
 * @package       KtaiLibrary
 * @subpackage    KtaiLibrary.vendors.ecw
 */
class Lib3gkMachine {
	
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
	 * 機種情報テーブル
	 *
	 * @var array
	 * @access public
	 */
	var $machine_table = array(
		
		//docomo
		//
		'DoCoMo' => array(
			'P04C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 325), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P03C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 325), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F10C' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F09C' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F03C' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F02C' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F01C' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH11C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH10C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH09C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH08C' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 248), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH06C' => array(
				'text_size'   => array(30, 18), 
				'screen_size' => array(240, 248), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH05C' => array(
				'text_size'   => array(30, 18), 
				'screen_size' => array(240, 248), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH04C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH02C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH01C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N05C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 325), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N03C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 325), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N02C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 325), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N01C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 325), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P01C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'L01B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P07B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P05B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P03B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'L03C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F11C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F05C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F04C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P02C' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N08B' => array(
				'text_size'   => array(30, 15), 
				'screen_size' => array(240, 240), 
				'image_size'  => array(854, 480), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N07B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N05B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N04B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N03B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N02B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N01B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P06B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 325), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P04B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P02B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P01B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F10B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F08B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F07B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F06B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 960), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F04B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 960), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F03B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F02B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F01B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 960), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH09B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 323), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH08B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 323), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH07B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 328), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH06B' => array(
				'text_size'   => array(20, 13), 
				'screen_size' => array(240, 323), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH05B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 323), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH04B' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 296), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH03B' => array(
				'text_size'   => array(24, 18), 
				'screen_size' => array(240, 296), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH02B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 323), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH01B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 323), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH08A' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 296), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH07A3' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 296), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH06A3' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 296), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'SH05A3' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 296), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F09A3' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 960), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'F08A3' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 324), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N09A3' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N08A3' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N07A3' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'N06A3' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P09A3' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P08A3' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'P07A3' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 331), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			
			'N04A' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N02A' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N01A' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH04A' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH03A' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH02A' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH01A' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P10A' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P06A' => array(
				'text_size'   => array(20, 13), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P05A' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P04A' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P03A' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P02A' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P01A' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F06A' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(480, 864), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F04A' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F03A' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(480, 960), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F02A' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F01A' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(480, 864), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH706iw' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P706ie' => array(
				'text_size'   => array(20, 13), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH706i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F706i' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH906iTV' => array(
				'text_size'   => array(20, 13), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N906i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F906i' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(480, 864), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N906imyu' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH906i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO906i' => array(
				'text_size'   => array(24, 18), 
				'screen_size' => array(240, 368), 
				'image_size'  => array(480, 864), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P906i' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F10A' => array(
				'text_size'   => array(20, 9), 
				'screen_size' => array(240, 330), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F07A' => array(
				'text_size'   => array(20, 8), 
				'screen_size' => array(240, 256), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N05A' => array(
				'text_size'   => array(20, 13), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N03A' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N706i2' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N706ie' => array(
				'text_size'   => array(20, 13), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P706imyu' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO706i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N706i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N906iL' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F884iES' => array(
				'text_size'   => array(20, 13), 
				'screen_size' => array(240, 282), 
				'image_size'  => array(240, 352), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F884i' => array(
				'text_size'   => array(20, 13), 
				'screen_size' => array(240, 364), 
				'image_size'  => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P705iCL' => array(
				'text_size'   => array(16, 10), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO705i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P705imyu' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N705imyu' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N705i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P705i' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P905iTV' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F905Biz' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(480, 864), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO905iCS' => array(
				'text_size'   => array(24, 18), 
				'screen_size' => array(240, 368), 
				'image_size'  => array(480, 864), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH905iTV' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N905iBiz' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N905imyu' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO905i' => array(
				'text_size'   => array(24, 18), 
				'screen_size' => array(240, 368), 
				'image_size'  => array(480, 864), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F905i' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(480, 864), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P905i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N905i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D905i' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(480, 864), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH905i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F05A' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH706ie' => array(
				'text_size'   => array(20, 13), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH705i2' => array(
				'text_size'   => array(20, 13), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH705i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D705imyu' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D705i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F705i' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F801i' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F883iESS' => array(
				'text_size'   => array(20, 8), 
				'screen_size' => array(240, 256), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F883iES' => array(
				'text_size'   => array(20, 8), 
				'screen_size' => array(240, 256), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P704i' => array(
				'text_size'   => array(24, 13), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D704i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH704i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N704imyu' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 345), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F704i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO704i' => array(
				'text_size'   => array(24, 18), 
				'screen_size' => array(240, 368), 
				'image_size'  => array(480, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P904i' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D904i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F904i' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N904i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 352), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH904i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO703i' => array(
				'text_size'   => array(24, 18), 
				'screen_size' => array(240, 368), 
				'image_size'  => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N703imyu' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 345), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH703i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D703i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P703i' => array(
				'text_size'   => array(24, 13), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F703i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N703iD' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 345), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO903iTV' => array(
				'text_size'   => array(24, 18), 
				'screen_size' => array(240, 368), 
				'image_size'  => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P903iX' => array(
				'text_size'   => array(24, 13), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F903iBSC' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH903iTV' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P903iTV' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F903iX' => array(
				'text_size'   => array(22, 16), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D903iTV' => array(
				'text_size'   => array(22, 16), 
				'screen_size' => array(230, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO903i' => array(
				'text_size'   => array(24, 18), 
				'screen_size' => array(240, 368), 
				'image_size'  => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F903i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D903i' => array(
				'text_size'   => array(22, 16), 
				'screen_size' => array(230, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N903i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(480, 690), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P903i' => array(
				'text_size'   => array(24, 13), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH903i' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L03B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 330), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L02B' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(240, 330), 
				'image_size'  => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L06A' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 313), 
				'image_size'  => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L04A' => array(
				'text_size'   => array(24, 15), 
				'screen_size' => array(240, 313), 
				'image_size'  => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L03A' => array(
				'text_size'   => array(16, 9), 
				'screen_size' => array(240, 280), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L01A' => array(
				'text_size'   => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L706ie' => array(
				'text_size'   => array(16, 9), 
				'screen_size' => array(240, 280), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L852i' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 298), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L705iX' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 280), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L705i' => array(
				'text_size'   => array(16, 9), 
				'screen_size' => array(240, 380), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L704i' => array(
				'text_size'   => array(24, 14), 
				'screen_size' => array(240, 280), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P704imyu' => array(
				'text_size'   => array(20, 11), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F883iS' => array(
				'text_size'   => array(20, 8), 
				'screen_size' => array(240, 256), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F883i' => array(
				'text_size'   => array(20, 8), 
				'screen_size' => array(240, 256), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P703imyu' => array(
				'text_size'   => array(24, 13), 
				'screen_size' => array(230, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D800iDS' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N601i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 345), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F882iES' => array(
				'text_size'   => array(20, 8), 
				'screen_size' => array(240, 256), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D851iWM' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D702iF' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P702iD' => array(
				'text_size'   => array(24, 13), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N702iS' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH702iS' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SA702i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 252), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D702iBCL' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO702i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 256), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D702i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH702iD' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F702iD' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N702iD' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P702i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N902iL' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N902iX' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH902iSL' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO902iWP+' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 256), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F902iS' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D902iS' => array(
				'text_size'   => array(22, 16), 
				'screen_size' => array(230, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N902iS' => array(
				'text_size'   => array(24, 13), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P902iS' => array(
				'text_size'   => array(24, 13), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH902iS' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SO902i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 256), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH902i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P902i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N902i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D902i' => array(
				'text_size'   => array(22, 16), 
				'screen_size' => array(230, 320), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F902i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L602i' => array(
				'text_size'   => array(22, 11), 
				'screen_size' => array(170, 189), 
				'image_size'  => array(176, 220), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'M702iG' => array(
				'text_size'   => array(24, 13), 
				'screen_size' => array(240, 267), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'M702iS' => array(
				'text_size'   => array(24, 13), 
				'screen_size' => array(240, 267), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L601i' => array(
				'text_size'   => array(22, 11), 
				'screen_size' => array(170, 189), 
				'image_size'  => array(176, 220), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N600i' => array(
				'text_size'   => array(20, 11), 
				'screen_size' => array(176, 180), 
				'image_size'  => array(176, 180), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'L600i' => array(
				'text_size'   => array(22, 11), 
				'screen_size' => array(170, 189), 
				'image_size'  => array(176, 220), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SA800i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 252), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N701iECO' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D701iWM' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P701iD' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N701i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D701i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F881iES' => array(
				'text_size'   => array(20, 8), 
				'screen_size' => array(240, 256), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P851i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH851i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 252), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SA700iS' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 252), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH700iS' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 252), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F700iS' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P700i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N700i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH700i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 252), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F700i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P901iTV' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N901iS' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P901iS' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D901iS' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F901iS' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH901iS' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 252), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P901i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D901i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N901iC' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F901iC' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH901iC' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 252), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F880iES' => array(
				'text_size'   => array(20, 8), 
				'screen_size' => array(240, 256), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N900iG' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 269), 
				'image_size'  => array(240, 269), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N900iL' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 269), 
				'image_size'  => array(240, 269), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F900iC' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'D900i' => array(
				'text_size'   => array(20, 10), 
				'screen_size' => array(240, 270), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N900iS' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 269), 
				'image_size'  => array(240, 269), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P900iV' => array(
				'text_size'   => array(24, 11), 
				'screen_size' => array(240, 266), 
				'image_size'  => array(240, 266), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F900iT' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'SH900i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(240, 252), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'P900i' => array(
				'text_size'   => array(24, 11), 
				'screen_size' => array(240, 266), 
				'image_size'  => array(240, 266), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'N900i' => array(
				'text_size'   => array(24, 12), 
				'screen_size' => array(240, 269), 
				'image_size'  => array(240, 269), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			'F900i' => array(
				'text_size'   => array(22, 12), 
				'screen_size' => array(230, 240), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
			
			'default' => array(
				'text_size'   => array(20, 11), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => false, ), 
			), 
		), 
		
		//Softbank(/Vodaphone/Disney Mobile)
		//
		'SoftBank' => array(
			'004SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 738), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'002Pe' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(236, 369), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'002P' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(236, 369), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'001P' => array(
				'text_size' => array(29, 21), 
				'screen_size' => array(471, 700), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'004SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 738), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'001SC' => array(
				'text_size' => array(26, 19), 
				'screen_size' => array(240, 334), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'002SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 738), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'001N' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(480, 650), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'001SH' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'840Z' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(234, 322), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'840Pp' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(236, 369), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'945SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 738), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'843SH' => array(
				'text_size' => array(20, 14), 
				'screen_size' => array(240, 338), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'841N' => array(
				'text_size' => array(24, 16), 
				'screen_size' => array(480, 650), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'941SC' => array(
				'text_size' => array(30, 16), 
				'screen_size' => array(480, 512), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'942P' => array(
				'text_size' => array(29, 21), 
				'screen_size' => array(471, 700), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'842SH' => array(
				'text_size' => array(20, 14), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'840N' => array(
				'text_size' => array(24, 16), 
				'screen_size' => array(240, 325), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'945SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 738), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'840SC' => array(
				'text_size' => array(25, 19), 
				'screen_size' => array(232, 336), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'944SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'842P' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(231, 350), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'841SH' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'841SHs' => array(
				'text_size' => array(20, 14), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'942SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'943SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'841P' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(236, 369), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'840Pe' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(236, 369), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'942SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'941P' => array(
				'text_size' => array(29, 21), 
				'screen_size' => array(471, 700), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'840SH' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'940P' => array(
				'text_size' => array(29, 21), 
				'screen_size' => array(471, 700), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'940N' => array(
				'text_size' => array(24, 16), 
				'screen_size' => array(480, 650), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'840P' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(236, 369), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'941SH' => array(
				'text_size' => array(30, 25), 
				'screen_size' => array(480, 824), 
				'image_size' => array(480, 1024), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'940SC' => array(
				'text_size' => array(30, 16), 
				'screen_size' => array(480, 512), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'931N' => array(
				'text_size' => array(24, 16), 
				'screen_size' => array(480, 640), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'940SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 738), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'832SHs' => array(
				'text_size' => array(20, 14), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'740SC' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(232, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'831N' => array(
				'text_size' => array(24, 16), 
				'screen_size' => array(240, 325), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'830SC' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(232, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'936SH' => array(
				'text_size' => array(24, 18), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'832SH' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'935SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'931P' => array(
				'text_size' => array(29, 21), 
				'screen_size' => array(471, 700), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'832T' => array(
				'text_size' => array(15, 6), 
				'screen_size' => array(234, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'931SC' => array(
				'text_size' => array(29, 16), 
				'screen_size' => array(471, 512), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'930N' => array(
				'text_size' => array(24, 16), 
				'screen_size' => array(480, 650), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'934SH' => array(
				'text_size' => array(24, 13), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'933SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 738), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'832P' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(230, 350), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'831SHs' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'831SH' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'830SHp' => array(
				'text_size' => array(24, 13), 
				'screen_size' => array(240, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'731SC' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(230, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'831P' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(236, 365), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'930CA' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(480, 700), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'830SHe' => array(
				'text_size' => array(24, 13), 
				'screen_size' => array(240, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'830N' => array(
				'text_size' => array(24, 16), 
				'screen_size' => array(480, 650), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'932SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'831SH' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'930P' => array(
				'text_size' => array(29, 21), 
				'screen_size' => array(471, 700), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'831T' => array(
				'text_size' => array(18, 11), 
				'screen_size' => array(234, 339), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'830T' => array(
				'text_size' => array(18, 11), 
				'screen_size' => array(234, 339), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'931SH' => array(
				'text_size' => array(30, 25), 
				'screen_size' => array(480, 824), 
				'image_size' => array(480, 1024), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'930SC' => array(
				'text_size' => array(29, 16), 
				'screen_size' => array(475, 512), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'930SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'830CA' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'830P' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(236, 365), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'830SHs' => array(
				'text_size' => array(24, 13), 
				'screen_size' => array(240, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'830SH' => array(
				'text_size' => array(24, 13), 
				'screen_size' => array(240, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'824T' => array(
				'text_size' => array(18, 11), 
				'screen_size' => array(234, 339), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'823T' => array(
				'text_size' => array(18, 11), 
				'screen_size' => array(234, 339), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'921P' => array(
				'text_size' => array(29, 22), 
				'screen_size' => array(471, 700), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'824P' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(231, 350), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'923SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'824SH' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'821N' => array(
				'text_size' => array(24, 16), 
				'screen_size' => array(240, 325), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'820N' => array(
				'text_size' => array(24, 16), 
				'screen_size' => array(240, 325), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'825SH' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'823P' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(231, 350), 
				'image_size' => array(240, 427), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'815T' => array(
				'text_size' => array(18, 9), 
				'screen_size' => array(234, 259), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'922SH' => array(
				'text_size' => array(53, 12), 
				'screen_size' => array(854, 384), 
				'image_size' => array(854, 480), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'921T' => array(
				'text_size' => array(18, 11), 
				'screen_size' => array(234, 339), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'921SH' => array(
				'text_size' => array(29, 23), 
				'screen_size' => array(468, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'920T' => array(
				'text_size' => array(18, 11), 
				'screen_size' => array(234, 339), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'920SH' => array(
				'text_size' => array(29, 23), 
				'screen_size' => array(468, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'920SH' => array(
				'text_size' => array(29, 23), 
				'screen_size' => array(468, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'920SC' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(230, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'920P' => array(
				'text_size' => array(29, 20), 
				'screen_size' => array(471, 700), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'913SH' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(234, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'913SH' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(234, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'912T' => array(
				'text_size' => array(18, 11), 
				'screen_size' => array(234, 339), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'912SH' => array(
				'text_size' => array(29, 21), 
				'screen_size' => array(468, 700), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'911T' => array(
				'text_size' => array(18, 11), 
				'screen_size' => array(234, 339), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'911SH' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(234, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'910T' => array(
				'text_size' => array(18, 9), 
				'screen_size' => array(234, 259), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'910SH' => array(
				'text_size' => array(29, 16), 
				'screen_size' => array(468, 540), 
				'image_size' => array(480, 640), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'823SH' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(234, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'822T' => array(
				'text_size' => array(18, 9), 
				'screen_size' => array(234, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'822SH' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(234, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'822P' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(236, 258), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'821T' => array(
				'text_size' => array(15, 6), 
				'screen_size' => array(234, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'821SH' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(234, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'821SC' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(230, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'821P' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(236, 338), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'820T' => array(
				'text_size' => array(18, 9), 
				'screen_size' => array(234, 259), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'820SH' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(234, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'820SC' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(230, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'820P' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(236, 338), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'816SH' => array(
				'text_size' => array(23, 13), 
				'screen_size' => array(234, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'815T' => array(
				'text_size' => array(18, 9), 
				'screen_size' => array(234, 259), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'815SH' => array(
				'text_size' => array(29, 26), 
				'screen_size' => array(468, 540), 
				'image_size' => array(480, 640), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'814T' => array(
				'text_size' => array(18, 9), 
				'screen_size' => array(234, 259), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'814SH' => array(
				'text_size' => array(29, 26), 
				'screen_size' => array(468, 540), 
				'image_size' => array(480, 640), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'813T' => array(
				'text_size' => array(18, 9), 
				'screen_size' => array(234, 259), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'813SH' => array(
				'text_size' => array(23, 13), 
				'screen_size' => array(234, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'813SHe' => array(
				'text_size' => array(23, 13), 
				'screen_size' => array(234, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'812T' => array(
				'text_size' => array(18, 9), 
				'screen_size' => array(234, 259), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'812SH' => array(
				'text_size' => array(23, 13), 
				'screen_size' => array(234, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'812SHs' => array(
				'text_size' => array(23, 13), 
				'screen_size' => array(234, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'812SHs' => array(
				'text_size' => array(23, 13), 
				'screen_size' => array(234, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'812SH' => array(
				'text_size' => array(23, 13), 
				'screen_size' => array(234, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'811T' => array(
				'text_size' => array(18, 9), 
				'screen_size' => array(234, 259), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'811SH' => array(
				'text_size' => array(29, 16), 
				'screen_size' => array(468, 540), 
				'image_size' => array(480, 640), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'810T' => array(
				'text_size' => array(18, 9), 
				'screen_size' => array(234, 259), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'810SH' => array(
				'text_size' => array(29, 16), 
				'screen_size' => array(468, 540), 
				'image_size' => array(480, 640), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'810P' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(236, 258), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'805SC' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(230, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'709SC' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(230, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'708SC' => array(
				'text_size' => array(34, 10), 
				'screen_size' => array(310, 186), 
				'image_size' => array(320, 240), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'707SC2' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(230, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'707SC' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(230, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'706SC' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(230, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'706P' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(236, 258), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'706N' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(233, 269), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'705SC' => array(
				'text_size' => array(25, 14), 
				'screen_size' => array(230, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'705P' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(236, 258), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'705NK' => array(
				'text_size' => array(31, 12), 
				'screen_size' => array(240, 267), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'705N' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(233, 269), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'DM008SH' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'DM007SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'DM006SH' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'DM005SH' => array(
				'text_size' => array(30, 23), 
				'screen_size' => array(480, 754), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
				'font_size' => array('reso' => 'high'), 
			), 
			'DM004SH' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'DM003SH' => array(
				'text_size' => array(24, 17), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'DM002SH' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(234, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'DM001SH' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(234, 350), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'default' => array(
				'text_size'   => array(20, 11), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
		), 
		'Vodafone' => array(
			'V703SHf' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(240, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V703SH' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(240, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V703N' => array(
				'text_size' => array(24, 10), 
				'screen_size' => array(240, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V702NK2' => array(
				'text_size' => array(26, 10), 
				'screen_size' => array(176, 173), 
				'image_size' => array(176, 208), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V702NK' => array(
				'text_size' => array(26, 10), 
				'screen_size' => array(176, 173), 
				'image_size' => array(176, 208), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V905SH' => array(
				'text_size' => array(22, 16), 
				'screen_size' => array(240, 350), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V904T' => array(
				'text_size' => array(24, 10), 
				'screen_size' => array(240, 261), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V904SH' => array(
				'text_size' => array(23, 13), 
				'screen_size' => array(480, 540), 
				'image_size' => array(480, 640), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V903T' => array(
				'text_size' => array(22, 10), 
				'screen_size' => array(240, 261), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V903SH' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(240, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V902T' => array(
				'text_size' => array(22, 10), 
				'screen_size' => array(240, 261), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V902SH' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(240, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V804SS' => array(
				'text_size' => array(28, 16), 
				'screen_size' => array(240, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V804SH' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(240, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V804NK' => array(
				'text_size' => array(24, 11), 
				'screen_size' => array(240, 267), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V804N' => array(
				'text_size' => array(22, 8), 
				'screen_size' => array(240, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V803T' => array(
				'text_size' => array(22, 10), 
				'screen_size' => array(240, 261), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V802SH' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(240, 264), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V802SE' => array(
				'text_size' => array(22, 10), 
				'screen_size' => array(176, 182), 
				'image_size' => array(176, 220), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V802N' => array(
				'text_size' => array(24, 10), 
				'screen_size' => array(240, 269), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V705T' => array(
				'text_size' => array(22, 10), 
				'screen_size' => array(240, 261), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'V705SH' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(240, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'default' => array(
				'text_size'   => array(20, 11), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
		), 
		
		'MOT-C980' => array(
			'default' => array(
				'text_size' => array(30, 10), 
				'screen_size' => array(176, 182), 
				'image_size' => array(176, 220), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
		), 
		
		'MOT-V980' => array(
			'default' => array(
				'text_size' => array(30, 10), 
				'screen_size' => array(176, 182), 
				'image_size' => array(176, 220), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
		), 
		
		//AU(KDDI)
		//
		'KDDI' => array(
			'KC46' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SN3U' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'TS3Y' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'CA3K' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'KC45' => array(
				'text_size' => array(14, 10), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'KC44' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 268), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SN3T' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'PT36' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(230, 324), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'TS3XI' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'KC42' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SH3L' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(234, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SN3S' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'KC43' => array(
				'text_size' => array(14, 10), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'CA3J' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 336), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'CA3I' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 336), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SH3K' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(234, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'TS3W' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SN3Q' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'TS3V' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SN3R' => array(
				'text_size' => array(19, 13), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'KC41' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 358), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SH3J' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(234, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			
			
			'KC3Z' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'TS3U' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'KC3Y' => array(
				'text_size' => array(14, 10), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SH3I' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(234, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SN3O' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'KC3X' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'TS3S' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SN3P' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'HI3H' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 336), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'CA3H' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 336), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
			'SH3H' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(234, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
			), 
//			'KC3W' => array(
//				'text_size' => array(0, 0), 
//				'screen_size' => array(0, 0), 
//				'image_size' => array(0, 0), 
//				'pic_format'  => array('gif' => false, 'jpg' => false, 'png' => false, ), 
//			), 
			'SH3G' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(234, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3V' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3U' => array(
				'text_size' => array(14, 10), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3N' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH3F' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(234, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3L' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH3E' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3S' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3R' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH3D' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(234, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA3G' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 336), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3M' => array(
				'text_size' => array(22, 16), 
				'screen_size' => array(228, 345), 
				'image_size' => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3R' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA3F' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 336), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3Q' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 

			'KC3P' => array(
				'text_size' => array(14, 10), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI3G' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 336), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3Q' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3O' => array(
				'text_size' => array(23, 17), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3P' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH3B' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(234, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3O' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH3C' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(234, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA3E' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 333), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3K' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(232, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			
			'SN3J' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'PT35' => array(
				'text_size' => array(19, 13), 
				'screen_size' => array(230, 324), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'MA35' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3N' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI3F' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 336), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH38' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA3D' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 336), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3I' => array(
				'text_size' => array(23, 16), 
				'screen_size' => array(233, 358), 
				'image_size' => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3N' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3M' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3H' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(233, 251), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI3E' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 333), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3M' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA3C' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 333), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH37' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(228, 331), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3I' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3G' => array(
				'text_size' => array(22, 16), 
				'screen_size' => array(228, 345), 
				'image_size' => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'MA34' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3L' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3K' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH36' => array(
				'text_size' => array(22, 15), 
				'screen_size' => array(229, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'PT34' => array(
				'text_size' => array(19, 10), 
				'screen_size' => array(230, 246), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA3E' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(230, 331), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA3B' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 333), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI3D' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 333), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH35' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(228, 331), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3F' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3H' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3K' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(229, 236), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3J' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA3D' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(230, 331), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3G' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(232, 245), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3D' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA3C' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(230, 331), 
				'image_size' => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3E' => array(
				'text_size' => array(22, 16), 
				'screen_size' => array(228, 345), 
				'image_size' => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3I' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI3C' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST34' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(228, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'PT33' => array(
				'text_size' => array(19, 10), 
				'screen_size' => array(230, 240), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'MA33' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA3A' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3D' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(240, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA3B' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(230, 331), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH34' => array(
				'text_size' => array(22, 15), 
				'screen_size' => array(229, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3C' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3H' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(233, 331), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3G' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 245), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI3B' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3B' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST33' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(228, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3E' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(232, 245), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3B' => array(
				'text_size' => array(22, 16), 
				'screen_size' => array(228, 345), 
				'image_size' => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA39' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST32' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(228, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3E' => array(
				'text_size' => array(22, 15), 
				'screen_size' => array(229, 325), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH33' => array(
				'text_size' => array(22, 15), 
				'screen_size' => array(229, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA38' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'MA32' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN3A' => array(
				'text_size' => array(22, 16), 
				'screen_size' => array(228, 345), 
				'image_size' => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3D' => array(
				'text_size' => array(22, 15), 
				'screen_size' => array(229, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA3A' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(228, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI3A' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC3A' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(232, 245), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH32' => array(
				'text_size' => array(22, 15), 
				'screen_size' => array(229, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN39' => array(
				'text_size' => array(22, 16), 
				'screen_size' => array(228, 345), 
				'image_size' => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3C' => array(
				'text_size' => array(22, 15), 
				'screen_size' => array(229, 325), 
				'image_size' => array(480, 800), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3B' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 245), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA39' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(228, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI39' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA37' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'MA31' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC39' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(240, 325), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS39' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 225), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS3A' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 225), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN38' => array(
				'text_size' => array(22, 16), 
				'screen_size' => array(228, 345), 
				'image_size' => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC38' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(232, 237), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA38' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(228, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS38' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 268), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA35' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 315), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI38' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(232, 315), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN37' => array(
				'text_size' => array(22, 16), 
				'screen_size' => array(228, 368), 
				'image_size' => array(240, 432), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC37' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(232, 237), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST31' => array(
				'text_size' => array(19, 10), 
				'screen_size' => array(235, 234), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SH31' => array(
				'text_size' => array(22, 15), 
				'screen_size' => array(229, 315), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA34' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(232, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI37' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(232, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS37' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 268), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS35' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 244), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS36' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 244), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN36' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(228, 250), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC36' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(232, 245), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC35' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(232, 245), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA36' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(228, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS34' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 244), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI36' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(230, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA33' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(230, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN34' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(228, 250), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI34' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(230, 266), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA35' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(228, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS33' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 244), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA34' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(228, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC34' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(234, 266), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI35' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(230, 235), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN33' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(228, 242), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN35' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(228, 242), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA32' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(230, 323), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS32' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 244), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN32' => array(
				'text_size' => array(22, 13), 
				'screen_size' => array(228, 238), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC33' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(234, 268), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA33' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(230, 268), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA32' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(230, 266), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI33' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(230, 266), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA31' => array(
				'text_size' => array(23, 15), 
				'screen_size' => array(230, 346), 
				'image_size' => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS31' => array(
				'text_size' => array(20, 9), 
				'screen_size' => array(229, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA31' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(225, 266), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN31' => array(
				'text_size' => array(22, 13), 
				'screen_size' => array(228, 266), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC32' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(234, 266), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI32' => array(
				'text_size' => array(20, 10), 
				'screen_size' => array(123, 147), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC31' => array(
				'text_size' => array(23, 10), 
				'screen_size' => array(233, 268), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI31' => array(
				'text_size' => array(23, 10), 
				'screen_size' => array(233, 268), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST2C' => array(
				'text_size' => array(19, 10), 
				'screen_size' => array(235, 242), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST29' => array(
				'text_size' => array(19, 9), 
				'screen_size' => array(235, 242), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA28' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(230, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST26' => array(
				'text_size' => array(19, 9), 
				'screen_size' => array(235, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST25' => array(
				'text_size' => array(19, 9), 
				'screen_size' => array(235, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST22' => array(
				'text_size' => array(20, 8), 
				'screen_size' => array(125, 145), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS2E' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 245), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC2A' => array(
				'text_size' => array(19, 10), 
				'screen_size' => array(232, 245), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA2A' => array(
				'text_size' => array(19, 9), 
				'screen_size' => array(235, 242), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC29' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(232, 245), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST2D' => array(
				'text_size' => array(19, 10), 
				'screen_size' => array(235, 242), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS2D' => array(
				'text_size' => array(22, 12), 
				'screen_size' => array(229, 245), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA29' => array(
				'text_size' => array(19, 9), 
				'screen_size' => array(235, 234), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC28' => array(
				'text_size' => array(19, 9), 
				'screen_size' => array(234, 248), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST2A' => array(
				'text_size' => array(19, 9), 
				'screen_size' => array(235, 242), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST28' => array(
				'text_size' => array(19, 9), 
				'screen_size' => array(235, 242), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS2C' => array(
				'text_size' => array(25, 13), 
				'screen_size' => array(229, 246), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS2B' => array(
				'text_size' => array(25, 13), 
				'screen_size' => array(229, 246), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC27' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(234, 248), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST27' => array(
				'text_size' => array(19, 9), 
				'screen_size' => array(235, 242), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA27' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(230, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS2A' => array(
				'text_size' => array(25, 13), 
				'screen_size' => array(229, 246), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS29' => array(
				'text_size' => array(20, 9), 
				'screen_size' => array(229, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST24' => array(
				'text_size' => array(19, 9), 
				'screen_size' => array(235, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS28' => array(
				'text_size' => array(38, 17), 
				'screen_size' => array(229, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA27' => array(
				'text_size' => array(37, 18), 
				'screen_size' => array(225, 263), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS27' => array(
				'text_size' => array(38, 17), 
				'screen_size' => array(229, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA26' => array(
				'text_size' => array(26, 14), 
				'screen_size' => array(225, 263), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC24' => array(
				'text_size' => array(20, 14), 
				'screen_size' => array(234, 262), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC25' => array(
				'text_size' => array(20, 14), 
				'screen_size' => array(234, 262), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS26' => array(
				'text_size' => array(20, 9), 
				'screen_size' => array(240, 270), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA26' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(230, 266), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA25' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(230, 266), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST23' => array(
				'text_size' => array(20, 10), 
				'screen_size' => array(127, 145), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN25' => array(
				'text_size' => array(30, 14), 
				'screen_size' => array(240, 256), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA24' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(230, 266), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN24' => array(
				'text_size' => array(20, 8), 
				'screen_size' => array(120, 160), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA23' => array(
				'text_size' => array(20, 10), 
				'screen_size' => array(123, 147), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'ST21' => array(
				'text_size' => array(20, 8), 
				'screen_size' => array(125, 145), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC22' => array(
				'text_size' => array(20, 11), 
				'screen_size' => array(125, 144), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS24' => array(
				'text_size' => array(20, 8), 		//8.5
				'screen_size' => array(144, 140), 
				'image_size' => array(144, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI24' => array(
				'text_size' => array(20, 9), 
				'screen_size' => array(125, 144), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI23' => array(
				'text_size' => array(20, 9), 
				'screen_size' => array(125, 144), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA22' => array(
				'text_size' => array(20, 10), 
				'screen_size' => array(125, 147), 
				'image_size' => array(132, 163), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS23' => array(
				'text_size' => array(20, 8), 		//8.5
				'screen_size' => array(144, 140), 
				'image_size' => array(144, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS21' => array(
				'text_size' => array(20, 8), 
				'screen_size' => array(144, 135), 
				'image_size' => array(144, 135), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA22' => array(
				'text_size' => array(21, 10), 
				'screen_size' => array(126, 144), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN21' => array(
				'text_size' => array(20, 8), 
				'screen_size' => array(120, 120), 
				'image_size' => array(120, 120), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS22' => array(
				'text_size' => array(20, 8), 
				'screen_size' => array(144, 135), 
				'image_size' => array(144, 156), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA21' => array(
				'text_size' => array(20, 9), 
				'screen_size' => array(125, 147), 
				'image_size' => array(132, 147), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA21' => array(
				'text_size' => array(21, 10), 
				'screen_size' => array(126, 144), 
				'image_size' => array(132, 128), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'MA21' => array(
				'text_size' => array(22, 8), 
				'screen_size' => array(132, 144), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC21' => array(
				'text_size' => array(20, 7), 
				'screen_size' => array(128, 132), 
				'image_size' => array(128, 120), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'HI21' => array(
				'text_size' => array(20, 8), 
				'screen_size' => array(120, 130), 
				'image_size' => array(120, 116), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'PT23' => array(
				'text_size' => array(24, 10), 
				'screen_size' => array(240, 240), 
				'image_size' => array(240, 292), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'PT22' => array(
				'text_size' => array(24, 10), 
				'screen_size' => array(240, 236), 
				'image_size' => array(240, 292), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'PT21' => array(
				'text_size' => array(24, 10), 
				'screen_size' => array(240, 236), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN29' => array(
				'text_size' => array(28, 14), 
				'screen_size' => array(228, 230), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC26' => array(
				'text_size' => array(23, 11), 
				'screen_size' => array(234, 266), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN27' => array(
				'text_size' => array(28, 14), 
				'screen_size' => array(228, 244), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN28' => array(
				'text_size' => array(28, 14), 
				'screen_size' => array(228, 244), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN26' => array(
				'text_size' => array(28, 14), 
				'screen_size' => array(228, 244), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'KC23' => array(
				'text_size' => array(21, 7), 
				'screen_size' => array(126, 136), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA28' => array(
				'text_size' => array(20, 10), 
				'screen_size' => array(124, 144), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'TS25' => array(
				'text_size' => array(20, 8), 		//8.5
				'screen_size' => array(144, 140), 
				'image_size' => array(144, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA25' => array(
				'text_size' => array(20, 10), 
				'screen_size' => array(124, 144), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA24' => array(
				'text_size' => array(20, 10), 
				'screen_size' => array(124, 144), 
				'image_size' => array(132, 176), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN23' => array(
				'text_size' => array(20, 8), 
				'screen_size' => array(120, 123), 
				'image_size' => array(120, 145), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SN22' => array(
				'text_size' => array(20, 8), 
				'screen_size' => array(120, 120), 
				'image_size' => array(120, 120), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'CA36' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(232, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'SA37' => array(
				'text_size' => array(23, 12), 
				'screen_size' => array(228, 243), 
				'image_size' => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'default' => array(
				'text_size'   => array(12, 16), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
		), 
		
		'emobile' => array(
			'H11T' => array(
				'text_size' => array(18, 11), 		//(similer to SoftBank 912T)
				'screen_size' => array(234, 339), 	//(similer to SoftBank 912T)
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'default' => array(
				'text_size' => array(18, 11), 		//nospec
				'screen_size' => array(234, 339), 	//nospec
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
		), 
		
		'iPhone' => array(
			'default' => array(
				'text_size'   => array(30, 18), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
		), 
		
		'Android' => array(
			'default' => array(
				'text_size'   => array(30, 18), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(480, 854), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
		), 
		
		//WILLCOM(/DDIPOCKET)
		//
		'WILLCOM' => array(
			'WX350K' => array(
				'text_size'   => array(30, 17), 
				'screen_size' => array(240, 276), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX334K' => array(
				'text_size'   => array(24, 12), //pf
				'screen_size' => array(237, 243), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX333K' => array(
				'text_size'   => array(24, 12), //pf
				'screen_size' => array(237, 243), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX341K' => array(
				'text_size'   => array(24, 17),
				'screen_size' => array(240, 356), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX340K' => array(
				'text_size'   => array(24, 17),
				'screen_size' => array(240, 356), 
				'image_size'  => array(240, 400), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX331KC' => array(
				'text_size'   => array(24, 12), //pf
				'screen_size' => array(237, 243), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX331K' => array(
				'text_size'   => array(24, 12), //pf
				'screen_size' => array(237, 243), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX330K' => array(
				'text_size'   => array(24, 12), //pf
				'screen_size' => array(237, 243), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			
			'WX320KR' => array(
				'text_size'   => array(28, 15), //pf
				'screen_size' => array(237, 241), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX320T' => array(
				'text_size'   => array(28, 15), 
				'screen_size' => array(240, 276), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX320K' => array(
				'text_size'   => array(28, 15), //pf
				'screen_size' => array(237, 241), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX321J' => array(
				'text_size'   => array(28, 15), 
				'screen_size' => array(240, 276), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX220J' => array(
				'text_size'   => array(24, 16), 
				'screen_size' => array(128, 130), 
				'image_size'  => array(128, 160), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WS009KE' => array(
				'text_size'   => array(30, 17), //pf
				'screen_size' => array(240, 276), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX310J' => array(
				'text_size'   => array(28, 15), 
				'screen_size' => array(240, 276), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX310SA' => array(
				'text_size'   => array(28, 15), 
				'screen_size' => array(240, 276), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX310K' => array(
				'text_size'   => array(28, 15), //pf
				'screen_size' => array(237, 241), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'WX300K' => array(
				'text_size'   => array(28, 15), //pf
				'screen_size' => array(237, 241), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'default' => array(
				'text_size'   => array(28, 15), 
				'screen_size' => array(237, 241), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
		), 
		'DDIPOCKET' => array(
			'AH-K3002V' => array(
				'text_size'   => array(30, 17), //pf
				'screen_size' => array(240, 276), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'AH-J3003S' => array(
				'text_size'   => array(30, 17), //pf
				'screen_size' => array(240, 276), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'AH-K3001V' => array(
				'text_size'   => array(30, 17), //pf
				'screen_size' => array(240, 276), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'AH-J3002V' => array(
				'text_size'   => array(16, 8), //pf
				'screen_size' => array(128, 130), 
				'image_size'  => array(128, 160), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'AH-J3001V' => array(
				'text_size'   => array(16, 8), //pf
				'screen_size' => array(128, 130), 
				'image_size'  => array(128, 160), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
			'default' => array(
				'text_size'   => array(16, 8), 
				'screen_size' => array(128, 130), 
				'image_size'  => array(128, 160), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
		), 
		
		'others' => array(
			'default' => array(
				'text_size'   => array(20, 11), 
				'screen_size' => array(240, 320), 
				'image_size'  => array(240, 320), 
				'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
			), 
		), 
	);
	
	
	/**
	 * キャリア名→キャリアコード変換テーブル
	 *
	 * @var string
	 * @access protected
	 */
	var $carrier_name_table = array(
		'others'    => 0, 
		'DoCoMo'    => 1, 
		'KDDI'      => 2, 
		'SoftBank'  => 3, 
		'Vodafone'  => 3, 
		'MOT-C980'  => 3, 
		'MOT-V980'  => 3, 
		'emobile'   => 4, 
		'iPhone'    => 5, 
		'WILLCOM'   => 6, 
		'DDIPOCKET' => 6, 
		'Android'   => 8, 
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
			$instance[0] =& new Lib3gkMachine();
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
	}
	
	
	//------------------------------------------------
	//Lib3gkMachine methods
	//------------------------------------------------
	/**
	 * 機種情報の入手
	 *
	 * @param $carrier_name string キャリア名
	 * @param $machine_name string 端末名
	 * @return array 端末情報
	 * @access public
	 */
	function get_machineinfo($carrier_name = null, $machine_name = null){
		
		$this->__load_carrier();
		
		if($carrier_name === null || $machine_name === null){
			$carrier_name = $this->__carrier->_carrier_name;
			$machine_name = $this->__carrier->_machine_name;
		}
		
		$default = false;
		if(!isset($this->machine_table[$carrier_name])){
			$carrier_name = 'others';
			$default = true;
		}
		if(!isset($this->machine_table[$carrier_name][$machine_name])){
			$machine_name = 'default';
			$default = true;
		}
		$carrier = $this->carrier_name_table[$carrier_name];
		
		$arr = $this->machine_table[$carrier_name][$machine_name];
		$arr = array_merge($arr, compact('carrier', 'carrier_name', 'machine_name', 'default'));
		
		return $arr;
	}
	
}
