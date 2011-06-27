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
 * Lib3gkEmoji sub class
 *
 * @package       KtaiLibrary
 * @subpackage    KtaiLibrary.vendors.ecw
 */
class Lib3gkEmoji {
	
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
	 * Lib3gkHtmlのインスタンス
	 *
	 * @var object
	 * @access private
	 */
	var $__html    = null;
	
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
		
		//Emoji caching params
		//
		'use_emoji_cache' => true,
		
		//for CakePHP
		//
		'output_auto_convert_emoji' => false, 
		
	);
	
	/**
	 * エンコード名→エンコードコードの変換テーブル
	 *
	 * @var array
	 * @access public
	 */
	var $encodings = array(
		KTAI_ENCODING_SJIS    => 0, 
		KTAI_ENCODING_SJISWIN => 0, 
		KTAI_ENCODING_UTF8    => 1, 
	);
	
	/**
	 * エンコードコード→エンコード名の変換テーブル
	 *
	 * @var array
	 * @access public
	 */
	var $encoding_codes = array(
		0 => KTAI_ENCODING_SJISWIN, 
		1 => KTAI_ENCODING_UTF8, 
	);
	
	/**
	 * キャリアコード→絵文字キャリアコードの変換テーブル
	 *
	 * @var array
	 * @access public
	 */
	var $carriers = array(
		KTAI_CARRIER_UNKNOWN  => 0, 
		KTAI_CARRIER_DOCOMO   => 1, 
		KTAI_CARRIER_KDDI     => 2, 
		KTAI_CARRIER_SOFTBANK => 3, 
		KTAI_CARRIER_EMOBILE  => 1, 
		KTAI_CARRIER_IPHONE   => 0, 
		KTAI_CARRIER_PHS      => 1, 
		KTAI_CARRIER_CLAWLER  => 0, 
	);
	
	/**
	 * キャリア絵文字コード→キャリアコードの変換テーブル
	 *
	 * @var array
	 * @access public
	 */
	var $carrier_codes = array(
		0 => KTAI_CARRIER_UNKNOWN, 
		1 => KTAI_CARRIER_DOCOMO, 
		2 => KTAI_CARRIER_KDDI, 
		3 => KTAI_CARRIER_SOFTBANK, 
	);
	
	/**
	 * キャリアコード→キャリアインデックスの変換テーブル
	 *
	 * @var array
	 * @access public
	 */
	var $carrier_indexes = array(
		0 => 3, 
		1 => 0, 
		2 => 1, 
		3 => 2, 
	);
	
	/**
	 * 絵文字のパターンマッチ正規表現
	 *
	 * @var array
	 * @access public
	 */
	var $patterns = array(
		0 => array(
			'/^(\xf8[\x9f-\xfc])|(\xf9[\x40-\xfc])$/', 
			'/^\xee[\x98-\x9c][\x80-\xbf]$/', 
		), 
		1 => array(
			'/^(\xf8[\x9f-\xfc])|(\xf9[\x40-\xfc])$/', 
			'/^\xee[\x98-\x9c][\x80-\xbf]$/', 
		), 
		2 => array(
			'/^[\xf3\xf4\xf6\xf7][\x40-\xfc]$/', 
//				'/^(\xee[\x91-\x97\a0\aa-\ae][\x80-\xbf])|(\xee[\xb1-\xb3\xb5-\xb7\bd-\xbf][\x80-\xbf])|(\xef[\x81-\x83][\x80-\xbf])$/', 
			'/^(\xee[\xb1-\xb3\xb5-\xb7\bd-\xbf][\x80-\xbf])|(\xef[\x81-\x83][\x80-\xbf])$/', 
		), 
		3 => array(
			'/^(\xf7[\x41-\x9b])|(\xf7[\xa1-\xfa])|(\xf9[\x41-\x9b])|(\xf9[\xa1-\xed])|(\xfb[\x41-\x8d])|(\xfb[\xa1-\xde])$/', 
			'/^\xee[\x80-\x81\x84-\x85\x88-\x89\x8c-\x8d\x90-\x91\x94][\x80-\xbf]$/', 
		), 
	);
	
	/**
	 * 絵文字キャッシュバッファ
	 *
	 * @var array
	 * @access private
	 */
	var $__cached = null;
	
	/**
	 * 絵文字テーブル
	 *
	 * @var array
	 * @access private
	 */
	var $__emoji_table = array(
		array(						//1
			array(0xf89f, 0xe63e), 
			array(0xf660, 0xe488, 0xef60, 0x7541, 0xeb60), 
			array(0xf98b, 0xe04a), 
			'[晴]', 
			'sun', 
		), 
		array(						//2
			array(0xf8a0, 0xe63f), 
			array(0xf665, 0xe48d, 0xef65, 0x7546, 0xeb65), 
			array(0xf98a, 0xe049), 
			'[曇]', 
			'cloud', 
		), 
		array(						//3
			array(0xf8a1, 0xe640), 
			array(0xf664, 0xe48c, 0xef64, 0x7545, 0xeb64), 
			array(0xf98c, 0xe04b), 
			'[雨]', 
			'rain', 
		), 
		array(						//4
			array(0xf8a2, 0xe641), 
			array(0xf65d, 0xe485, 0xef5d, 0x753e, 0xeb5d), 
			array(0xf989, 0xe048), 
			'[雪]', 
			'snow', 
		), 
		array(						//5
			array(0xf8a3, 0xe642), 
			array(0xf65f, 0xe487, 0xef5f, 0x7540, 0xeb5f), 
			array(0xf77d, 0xe13d), 
			'[雷]', 
			'thunder', 
		), 
		array(						//6
			array(0xf8a4, 0xe643), 
			array(0xf641, 0xe469, 0xef41, 0x7522, 0xeb41), 
			array(0xfb84, 0xe443), 
			'[台風]', 
			'typhoon', 
		), 
		array(						//7
			array(0xf8a5, 0xe644), 
			array(0xf7b5, 0xe598, 0xf0b5, 0x7837, 0xecb5), 
			array(0, 0), 
			'[霧]', 
			'mist', 
		), 
		array(						//8
			array(0xf8a6, 0xe645), 
			array(0xf3bc, 0xeae8, 0xecbc, 0x7a3e, 0xedbc), 
			array(0xfb7c, 0xe43c), 
			'　', 
			'sprinkle', 
		), 
		array(						//9
			array(0xf8a7, 0xe646), 
			array(0xf667, 0xe48f, 0xef67, 0x7548, 0xeb67), 
			array(0xf7df, 0xe23f), 
			'[牡羊座]', 
			'aries', 
		), 
		array(						//10
			array(0xf8a8, 0xe647), 
			array(0xf668, 0xe490, 0xef68, 0x7549, 0xeb68), 
			array(0xf7e0, 0xe240), 
			'[牡牛座]', 
			'taurus', 
		), 
		array(						//11
			array(0xf8a9, 0xe648), 
			array(0xf669, 0xe491, 0xef69, 0x754a, 0xeb69), 
			array(0xf7e1, 0xe241), 
			'[双子座]', 
			'gemini', 
		), 
		array(						//12
			array(0xf8aa, 0xe649), 
			array(0xf66a, 0xe492, 0xef6a, 0x754b, 0xeb6a), 
			array(0xf7e2, 0xe242), 
			'[蟹座]', 
			'cancer', 
		), 
		array(						//13
			array(0xf8ab, 0xe64a), 
			array(0xf66b, 0xe493, 0xef6b, 0x754c, 0xeb6b), 
			array(0xf7e3, 0xe243), 
			'[獅子座]', 
			'leo', 
		), 
		array(						//14
			array(0xf8ac, 0xe64b), 
			array(0xf66c, 0xe494, 0xef6c, 0x754d, 0xeb6c), 
			array(0xf7e4, 0xe244), 
			'[乙女座]', 
			'virgo', 
		), 
		array(						//15
			array(0xf8ad, 0xe64c), 
			array(0xf66d, 0xe495, 0xef6d, 0x754e, 0xeb6d), 
			array(0xf7e5, 0xe245), 
			'[天秤座]', 
			'libra', 
		), 
		array(		 				//16
			array(0xf8ae, 0xe64d), 
			array(0xf66e, 0xe496, 0xef6e, 0x754f, 0xeb6e), 
			array(0xf7e6, 0xe246), 
			'[蠍座]', 
			'scorpius', 
		)	,
		array(						//17
			array(0xf8af, 0xe64e), 
			array(0xf66f, 0xe497, 0xef6f, 0x7550, 0xeb6f), 
			array(0xf7e7, 0xe247), 
			'[射手座]', 
			'sagittarius', 
		), 
		array(						//18
			array(0xf8b0, 0xe64f), 
			array(0xf670, 0xe498, 0xef70, 0x7551, 0xeb70), 
			array(0xf7e8, 0xe248), 
			'[山羊座]', 
			'capricornus', 
		), 
		array(						//19
			array(0xf8b1, 0xe650), 
			array(0xf671, 0xe499, 0xef71, 0x7552, 0xeb71), 
			array(0xf7e9, 0xe249), 
			'[水瓶座]', 
			'aquarius', 
		), 
		array(						//20
			array(0xf8b2, 0xe651), 
			array(0xf672, 0xe49a, 0xef72, 0x7553, 0xeb72), 
			array(0xf7ea, 0xe24a), 
			'[魚座]', 
			'pisces', 
		), 
		array(						//21
			array(0xf8b3, 0xe652), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'sports', 
		), 
		array(		 				//22
			array(0xf8b4, 0xe653), 
			array(0xf693, 0xe4ba, 0xef93, 0x7573, 0xeb93), 
			array(0xf956, 0xe016), 
			'　', 
			'baseball', 
		),	
		array(						//23
			array(0xf8b5, 0xe654), 
			array(0xf7b6, 0xe599, 0xf0b6, 0x7838, 0xecb6), 
			array(0xf954, 0xe014), 
			'　', 
			'golf', 
		), 
		array(						//24
			array(0xf8b6, 0xe655), 
			array(0xf690, 0xe4b7, 0xef90, 0x7570, 0xeb90), 
			array(0xf955, 0xe015), 
			'　', 
			'tennis', 
		), 
		array(						//25
			array(0xf8b7, 0xe656), 
			array(0xf68f, 0xe4b6, 0xef8f, 0x756f, 0xeb8f), 
			array(0xf958, 0xe018), 
			'　', 
			'soccer', 
		), 
		array(						//26
			array(0xf8b8, 0xe657), 
			array(0xf380, 0xeaac, 0xec80, 0x7960, 0xed80), 
			array(0xf953, 0xe013), 
			'　', 
			'ski', 
		), 
		array(						//27
			array(0xf8b9, 0xe658), 
			array(0xf7b7, 0xe59a, 0xf0b7, 0x7839, 0xecb7), 
			array(0xfb6a, 0xe42a), 
			'　', 
			'basketball', 
		), 
		array(						//28
			array(0xf8ba, 0xe659), 
			array(0xf692, 0xe4b9, 0xef92, 0x7572, 0xeb92), 
			array(0xf772, 0xe132), 
			'　', 
			'motorsports', 
		), 
		array(						//29
			array(0xf8bb, 0xe65a), 
			array(0xf7b8, 0xe59b, 0xf0b8, 0x783a, 0xecb8), 
			array(0, 0), 
			'　', 
			'pocketbell', 
		), 
		array(						//30
			array(0xf8bc, 0xe65b), 
			array(0xf68e, 0xe4b5, 0xef8e, 0x756e, 0xeb8e), 
			array(0xf95e, 0xe01e), 
			'[電車]', 
			'train', 
		), 
		array(						//31
			array(0xf8bd, 0xe65c), 
			array(0xf7ec, 0xe5bc, 0xf0ec, 0x786e, 0xecec), 
			array(0xfb74, 0xe434), 
			'[地下鉄]', 
			'subway', 
		), 
		array(						//32
			array(0xf8be, 0xe65d), 
			array(0xf689, 0xe4b0, 0xef89, 0x7569, 0xeb89), 
			array(0xfb75, 0xe435), 
			'[新幹線]', 
			'bullettrain', 
		), 
		array(						//33
			array(0xf8bf, 0xe65e), 
			array(0xf68a, 0xe4b1, 0xef8a, 0x756a, 0xeb8a), 
			array(0xf95b, 0xe01b), 
			'[車]', 
			'car', 
		), 
		array(						//34
			array(0xf8c0, 0xe65f), 
			array(0xf68a, 0xe4b1, 0xef8a, 0x756a, 0xeb8a), 
			array(0xfb6e, 0xe42e), 
			'[車]', 
			'car', 
		), 
		array(						//35
			array(0xf8c1, 0xe660), 
			array(0xf688, 0xe4af, 0xef88, 0x7568, 0xeb88), 
			array(0xf79a, 0xe159), 
			'[ﾊﾞｽ]', 
			'bus', 
		), 
		array(						//36
			array(0xf8c2, 0xe661), 
			array(0xf355, 0xea82, 0xec55, 0x7936, 0xed55), 
			array(0xf7a2, 0xe202), 
			'[船]', 
			'ship', 
		), 
		array(						//37
			array(0xf8c3, 0xe662), 
			array(0xf68c, 0xe4b3, 0xef8c, 0x756c, 0xeb8c), 
			array(0xf95d, 0xe01d), 
			'[飛行機]', 
			'airplane', 
		), 
		array(						//38
			array(0xf8c4, 0xe663), 
			array(0xf684, 0xe4ab, 0xef84, 0x7564, 0xeb84), 
			array(0xf976, 0xe036), 
			'[家]', 
			'house', 
		), 
		array(						//39
			array(0xf8c5, 0xe664), 
			array(0xf686, 0xe4ad, 0xef86, 0x7566, 0xeb86), 
			array(0xf978, 0xe038), 
			'[ﾋﾞﾙ]', 
			'building', 
		), 
		array(						//40
			array(0xf8c6, 0xe665), 
			array(0xf351, 0xe5de, 0xec51, 0x7932, 0xed51), 
			array(0xf794, 0xe153), 
			'[〒]', 
			'postoffice', 
		), 
		array(						//41
			array(0xf8c7, 0xe666), 
			array(0xf352, 0xe5df, 0xec52, 0x7933, 0xed52), 
			array(0xf796, 0xe155), 
			'[+]', 
			'hospital', 
		), 
		array(						//42
			array(0xf8c8, 0xe667), 
			array(0xf683, 0xe4aa, 0xef83, 0x7563, 0xeb83), 
			array(0xf78e, 0xe14d), 
			'[BK]', 
			'bank', 
		), 
		array(						//43
			array(0xf8c9, 0xe668), 
			array(0xf67b, 0xe4a3, 0xef7b, 0x755c, 0xeb7b), 
			array(0xf795, 0xe154), 
			'[ATM]', 
			'atm', 
		), 
		array(						//44
			array(0xf8ca, 0xe669), 
			array(0xf354, 0xea81, 0xec54, 0x7935, 0xed54), 
			array(0xf799, 0xe158), 
			'[H]', 
			'hotel', 
		), 
		array(						//45
			array(0xf8cb, 0xe66a), 
			array(0xf67c, 0xe4a4, 0xef7c, 0x755d, 0xeb7c), 
			array(0xf797, 0xe156), 
			'[CVS]', 
			'24hours', 
		), 
		array(						//46
			array(0xf8cc, 0xe66b), 
			array(0xf78e, 0xe571, 0xf08e, 0x776e, 0xec8e), 
			array(0xf97a, 0xe03a), 
			'[GS]', 
			'gasstation', 
		), 
		array(						//47
			array(0xf8cd, 0xe66c), 
			array(0xf67e, 0xe4a6, 0xef7e, 0x755f, 0xeb7e), 
			array(0xf790, 0xe14f), 
			'[P]', 
			'parking', 
		), 
		array(						//48
			array(0xf8ce, 0xe66d), 
			array(0xf642, 0xe46a, 0xef42, 0x7523, 0xeb42), 
			array(0xf78f, 0xe14e), 
			'[信号]', 
			'signaler', 
		), 
		array(						//49
			array(0xf8cf, 0xe66e), 
			array(0xf67d, 0xe4a5, 0xef7d, 0x755e, 0xeb7d), 
			array(0xf792, 0xe151), 
			'[WC]', 
			'toilet', 
		), 
		array(						//50
			array(0xf8d0, 0xe66f), 
			array(0xf685, 0xe4ac, 0xef85, 0x7565, 0xeb85), 
			array(0xf984, 0xe043), 
			'　', 
			'restaurant', 
		), 
		array(						//51
			array(0xf8d1, 0xe670), 
			array(0xf7b4, 0xe597, 0xf0b4, 0x7836, 0xecb4), 
			array(0xf986, 0xe045), 
			'　', 
			'cafe', 
		), 
		array(						//52
			array(0xf8d2, 0xe671), 
			array(0xf69b, 0xe4c2, 0xef9b, 0x757b, 0xeb9b), 
			array(0xf985, 0xe044), 
			'　', 
			'bar', 
		), 
		array(						//53
			array(0xf8d3, 0xe672), 
			array(0xf69c, 0xe4c3, 0xef9c, 0x757c, 0xeb9c), 
			array(0xf988, 0xe047), 
			'　', 
			'beer', 
		), 
		array(						//54
			array(0xf8d4, 0xe673), 
			array(0xf6af, 0xe4d6, 0xefaf, 0x7631, 0xebaf), 
			array(0xf760, 0xe120), 
			'　', 
			'fastfood', 
		), 
		array(						//55
			array(0xf8d5, 0xe674), 
			array(0xf6f3, 0xe51a, 0xeff3, 0x7675, 0xebf3), 
			array(0xf77e, 0xe13e), 
			'　', 
			'boutique', 
		), 
		array(						//56
			array(0xf8d6, 0xe675), 
			array(0xf6ef, 0xe516, 0xefef, 0x7671, 0xebef), 
			array(0xf9b3, 0xe313), 
			'　', 
			'hairsalon', 
		), 
		array(						//57
			array(0xf8d7, 0xe676), 
			array(0xf6dc, 0xe503, 0xefdc, 0x765e, 0xebdc), 
			array(0xf97c, 0xe03c), 
			'　', 
			'karaoke', 
		), 
		array(						//58
			array(0xf8d8, 0xe677), 
			array(0xf6f0, 0xe517, 0xeff0, 0x7672, 0xebf0), 
			array(0xf97d, 0xe03d), 
			'　', 
			'movie', 
		), 
		array(						//59
			array(0xf8d9, 0xe678), 
			array(0xf771, 0xe555, 0xf071, 0x7752, 0xec71), 
			array(0xf7d6, 0xe236), 
			'　', 
			'upwardright', 
		), 
		array(						//60
			array(0xf8da, 0xe679), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'carouselpony', 
		), 
		array(						//61
			array(0xf8db, 0xe67a), 
			array(0xf6e1, 0xe508, 0xefe1, 0x7663, 0xebe1), 
			array(0xf9aa, 0xe30a), 
			'　', 
			'music', 
		), 
		array(						//62
			array(0xf8dc, 0xe67b), 
			array(0xf7b9, 0xe59c, 0xf0b9, 0x783b, 0xecb9), 
			array(0xfba2, 0xe502), 
			'　', 
			'art', 
		), 
		array(						//63
			array(0xf8dd, 0xe67c), 
			array(0xf3c9, 0xeaf5, 0xecc9, 0x7a4b, 0xedc9), 
			array(0xfba3, 0xe503), 
			'　', 
			'drama', 
		), 
		array(						//64
			array(0xf8de, 0xe67d), 
			array(0xf7bb, 0xe59e, 0xf0bb, 0x783d, 0xecbb), 
			array(0, 0), 
			'　', 
			'event', 
		), 
		array(						//65
			array(0xf8df, 0xe67e), 
			array(0xf676, 0xe49e, 0xef76, 0x7557, 0xeb76), 
			array(0xf765, 0xe125), 
			'　', 
			'ticket', 
		), 
		array(						//66
			array(0xf8e0, 0xe67f), 
			array(0xf655, 0xe47d, 0xef55, 0x7536, 0xeb55), 
			array(0xf9ae, 0xe30e), 
			'　', 
			'smoking', 
		), 
		array(						//67
			array(0xf8e1, 0xe680), 
			array(0xf656, 0xe47e, 0xef56, 0x7537, 0xeb56), 
			array(0xf7a8, 0xe208), 
			'[禁煙]', 
			'nosmoking', 
		), 
		array(						//68
			array(0xf8e2, 0xe681), 
			array(0xf6ee, 0xe515, 0xefee, 0x7670, 0xebee), 
			array(0xf948, 0xe008), 
			'　', 
			'camera', 
		), 
		array(						//69
			array(0xf8e3, 0xe682), 
			array(0xf674, 0xe49c, 0xef74, 0x7555, 0xeb74), 
			array(0xf9c3, 0xe323), 
			'　', 
			'bag', 
		), 
		array(						//70
			array(0xf8e4, 0xe683), 
			array(0xf677, 0xe49f, 0xef77, 0x7558, 0xeb77), 
			array(0xf789, 0xe148), 
			'[本]', 
			'book', 
		), 
		array(						//71
			array(0xf8e5, 0xe684), 
			array(0xf7bc, 0xe59f, 0xf0bc, 0x783e, 0xecbc), 
			array(0xf9b4, 0xe314), 
			'　', 
			'ribbon', 
		), 
		array(						//72
			array(0xf8e6, 0xe685), 
			array(0xf6a8, 0xe4cf, 0xefa8, 0x762a, 0xeba8), 
			array(0xf752, 0xe112), 
			'　', 
			'present', 
		), 
		array(						//73
			array(0xf8e7, 0xe686), 
			array(0xf7bd, 0xe5a0, 0xf0bd, 0x783f, 0xecbd), 
			array(0xf9eb, 0xe34b), 
			'　', 
			'birthday', 
		), 
		array(						//74
			array(0xf8e8, 0xe687), 
			array(0xf7b3, 0xe596, 0xf0b3, 0x7835, 0xecb3), 
			array(0xf949, 0xe009), 
			'[TEL]', 
			'telephone', 
		), 
		array(						//75
			array(0xf8e9, 0xe688), 
			array(0xf7a5, 0xe588, 0xf0a5, 0x7827, 0xeca5), 
			array(0xf94a, 0xe00a), 
			'[携帯]', 
			'mobilephone', 
		), 
		array(						//76
			array(0xf8ea, 0xe689), 
			array(0xf365, 0xea92, 0xec65, 0x7946, 0xed65), 
			array(0xf9a1, 0xe301), 
			'　', 
			'memo', 
		), 
		array(						//77
			array(0xf8eb, 0xe68a), 
			array(0xf6db, 0xe502, 0xefdb, 0x765d, 0xebdb), 
			array(0xf76a, 0xe12a), 
			'　', 
			'tv', 
		), 
		array(						//78
			array(0xf8ec, 0xe68b), 
			array(0xf69f, 0xe4c6, 0xef9f, 0x7621, 0xeb9f), 
			array(0, 0), 
			'　', 
			'game', 
		), 
		array(						//79
			array(0xf8ed, 0xe68c), 
			array(0xf6e5, 0xe50c, 0xefe5, 0x7667, 0xebe5), 
			array(0xf766, 0xe126), 
			'　', 
			'cd', 
		), 
		array(						//80
			array(0xf8ee, 0xe68d), 
			array(0xf378, 0xeaa5, 0xec78, 0x7959, 0xed78), 
			array(0xf7ac, 0xe20c), 
			'　', 
			'heart', 
		), 
		array(						//81
			array(0xf8ef, 0xe68e), 
			array(0xf7be, 0xe5a1, 0xf0be, 0x7840, 0xecbe), 
			array(0xf7ae, 0xe20e), 
			'　', 
			'spade', 
		), 
		array(						//82
			array(0xf8f0, 0xe68f), 
			array(0xf7bf, 0xe5a2, 0xf0bf, 0x7841, 0xecbf), 
			array(0xf7ad, 0xe20d), 
			'　', 
			'diamond', 
		), 
		array(						//83
			array(0xf8f1, 0xe690), 
			array(0xf7c0, 0xe5a3, 0xf0c0, 0x7842, 0xecc0), 
			array(0xf7af, 0xe20f), 
			'　', 
			'club', 
		), 
		array(						//84
			array(0xf8f2, 0xe691), 
			array(0xf7c1, 0xe5a4, 0xf0c1, 0x7843, 0xecc1), 
			array(0xfb59, 0xe419), 
			'　', 
			'eye', 
		), 
		array(						//85
			array(0xf8f3, 0xe692), 
			array(0xf7c2, 0xe5a5, 0xf0c2, 0x7844, 0xecc2), 
			array(0xfb5b, 0xe41b), 
			'　', 
			'ear', 
		), 
		array(						//86
			array(0xf8f4, 0xe693), 
			array(0xf488, 0xeb83, 0xed88, 0x7b68, 0xee88), 
			array(0xf950, 0xe010), 
			'　', 
			'rock', 
		), 
		array(						//87
			array(0xf8f5, 0xe694), 
			array(0xf7c3, 0xe5a6, 0xf0c3, 0x7845, 0xecc3), 
			array(0xf951, 0xe011), 
			'　', 
			'scissors', 
		), 
		array(						//88
			array(0xf8f6, 0xe695), 
			array(0xf7c4, 0xe5a7, 0xf0c4, 0x7846, 0xecc4), 
			array(0xf952, 0xe012), 
			'　', 
			'paper', 
		), 
		array(						//89
			array(0xf8f7, 0xe696), 
			array(0xf769, 0xe54d, 0xf069, 0x774a, 0xec69), 
			array(0xf7d8, 0xe238), 
			'　', 
			'downwardright', 
		), 
		array(						//90
			array(0xf8f8, 0xe697), 
			array(0xf768, 0xe54c, 0xf068, 0x7749, 0xec68), 
			array(0xf7d7, 0xe237), 
			'　', 
			'upwardleft', 
		), 
		array(						//91
			array(0xf8f9, 0xe698), 
			array(0xf3eb, 0xeb2a, 0xeceb, 0x7a6d, 0xedeb), 
			array(0xfbd6, 0xe536), 
			'　', 
			'foot', 
		), 
		array(						//92
			array(0xf8fa, 0xe699), 
			array(0xf3ec, 0xeb2b, 0xecec, 0x7a6e, 0xedec), 
			array(0xf947, 0xe007), 
			'　', 
			'shoe', 
		), 
		array(						//93
			array(0xf8fb, 0xe69a), 
			array(0xf6d7, 0xe4fe, 0xefd7, 0x7659, 0xebd7), 
			array(0, 0), 
			'　', 
			'eyeglass', 
		), 
		array(						//94
			array(0xf8fc, 0xe69b), 
			array(0xf657, 0xe47f, 0xef57, 0x7538, 0xeb57), 
			array(0xf7aa, 0xe20a), 
			'　', 
			'wheelchair', 
		), 
		array(						//95
			array(0xf940, 0xe69c), 
			array(0xf7c5, 0xe5a8, 0xf0c5, 0x7847, 0xecc5), 
			array(0, 0), 
			'●', 
			'newmoon', 
		), 
		array(						//96
			array(0xf941, 0xe69d), 
			array(0xf7c6, 0xe5a9, 0xf0c6, 0x7848, 0xecc6), 
			array(0xf98d, 0xe04c), 
			'●', 
			'moon1', 
		), 
		array(						//97
			array(0xf942, 0xe69e), 
			array(0xf7c7, 0xe5aa, 0xf0c7, 0x7849, 0xecc7), 
			array(0xf98d, 0xe04c), 
			'○', 
			'moon2', 
		), 
		array(						//98
			array(0xf943, 0xe69f), 
			array(0xf65e, 0xe486, 0xef5e, 0x753f, 0xeb5e), 
			array(0xf98d, 0xe04c), 
			'○', 
			'moon3', 
		), 
		array(						//99
			array(0xf944, 0xe6a0), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'○', 
			'fullmoon', 
		), 
		array(						//100
			array(0xf945, 0xe6a1), 
			array(0xf6ba, 0xe4e1, 0xefba, 0x763c, 0xebba), 
			array(0xf993, 0xe052), 
			'　', 
			'dog', 
		), 
		array(						//101
			array(0xf946, 0xe6a2), 
			array(0xf6b4, 0xe4db, 0xefb4, 0x7636, 0xebb4), 
			array(0xf990, 0xe04f), 
			'　', 
			'cat', 
		), 
		array(						//102
			array(0xf947, 0xe6a3), 
			array(0xf68d, 0xe4b4, 0xef8d, 0x756d, 0xeb8d), 
			array(0xf95c, 0xe01c), 
			'　', 
			'yacht', 
		), 
		array(						//103
			array(0xf948, 0xe6a4), 
			array(0xf6a2, 0xe4c9, 0xefa2, 0x7624, 0xeba2), 
			array(0xf973, 0xe033), 
			'　', 
			'xmas', 
		), 
		array(						//104
			array(0xf949, 0xe6a5), 
			array(0xf772, 0xe556, 0xf072, 0x7753, 0xec72), 
			array(0xf7d9, 0xe239), 
			'　', 
			'downwardleft', 
		), 
		array(						//105
			array(0xf972, 0xe6ce), 
			array(0xf7df, 0xeb08, 0xf0df, 0x7861, 0xecdf), 
			array(0xf744, 0xe104), 
			'[TEL]', 
			'phoneto', 
		), 
		array(						//106
			array(0xf973, 0xe6cf), 
			array(0xf466, 0xeb62, 0xed66, 0x7b47, 0xee66), 
			array(0xf743, 0xe103), 
			'[MAIL]', 
			'mailto', 
		), 
		array(						//107
			array(0xf974, 0xe6d0), 
			array(0xf6f9, 0xe520, 0xeff9, 0x767b, 0xebf9), 
			array(0xf94b, 0xe00b), 
			'[FAX]', 
			'faxto', 
		), 
		array(						//108
			array(0xf975, 0xe6d1), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'[i]', 
			'info01', 
		), 
		array(						//109
			array(0xf976, 0xe6d2), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'[i]', 
			'info02', 
		), 
		array(						//110
			array(0xf977, 0xe6d3), 
			array(0xf6fa, 0xe521, 0xeffa, 0x767c, 0xebfa), 
			array(0xf743, 0xe103), 
			'[MAIL]', 
			'mail', 
		), 
		array(						//111
			array(0xf978, 0xe6d4), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'by-d', 
		), 
		array(						//112
			array(0xf979, 0xe6d5), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'd-point', 
		), 
		array(						//113
			array(0xf97a, 0xe6d6), 
			array(0xf79a, 0xe57d, 0xf09a, 0x777a, 0xec9a), 
			array(0, 0), 
			'[\\]', 
			'yen', 
		), 
		array(						//114
			array(0xf97b, 0xe6d7), 
			array(0xf795, 0xe578, 0xf095, 0x7775, 0xec95), 
			array(0, 0), 
			'[FREE]', 
			'free', 
		), 
		array(						//115
			array(0xf97c, 0xe6d8), 
			array(0xf35b, 0xea88, 0xec5b, 0x793c, 0xed5b), 
			array(0xf7c9, 0xe229), 
			'[ID]', 
			'id', 
		), 
		array(						//116
			array(0xf97d, 0xe6d9), 
			array(0xf6f2, 0xe519, 0xeff2, 0x7674, 0xebf2), 
			array(0xf980, 0xe03f), 
			'[PW]', 
			'key', 
		), 
		array(						//117
			array(0xf97e, 0xe6da), 
			array(0xf779, 0xe55d, 0xf079, 0x775a, 0xec79), 
			array(0, 0), 
			'　', 
			'enter', 
		), 
		array(						//118
			array(0xf980, 0xe6db), 
			array(0xf7c8, 0xe5ab, 0xf0c8, 0x784a, 0xecc8), 
			array(0, 0), 
			'[CL]', 
			'clear', 
		), 
		array(						//119
			array(0xf981, 0xe6dc), 
			array(0xf6f1, 0xe518, 0xeff1, 0x7673, 0xebf1), 
			array(0xf754, 0xe114), 
			'　', 
			'search', 
		), 
		array(						//120
			array(0xf982, 0xe6dd), 
			array(0xf7e5, 0xe5b5, 0xf0e5, 0x7867, 0xece5), 
			array(0xf7b2, 0xe212), 
			'[NEW]', 
			'new', 
		), 
		array(						//121
			array(0xf983, 0xe6de), 
			array(0xf3ed, 0xeb2c, 0xeced, 0x7a6f, 0xeded), 
			array(0, 0), 
			'　', 
			'flag', 
		), 
		array(						//122
			array(0xf984, 0xe6df), 
			array(0, 0, 0, 0, 0), 
			array(0xf7b1, 0xe211), 
			'　', 
			'freedial', 
		), 
		array(						//123
			array(0xf985, 0xe6e0), 
			array(0xf489, 0xeb84, 0xed89, 0x7b69, 0xee89), 
			array(0xf7b0, 0xe210), 
			'　', 
			'sharp', 
		), 
		array(						//124
			array(0xf986, 0xe6e1), 
			array(0xf748, 0xe52c, 0xf048, 0x7729, 0xec48), 
			array(0, 0), 
			'[Q]', 
			'mobaq', 
		), 
		array(						//125
			array(0xf987, 0xe6e2), 
			array(0xf6fb, 0xe522, 0xeffb, 0x767d, 0xebfb), 
			array(0xf7bc, 0xe21c), 
			'[1]', 
			'one', 
		), 
		array(						//126
			array(0xf988, 0xe6e3), 
			array(0xf6fc, 0xe523, 0xeffc, 0x767e, 0xebfc), 
			array(0xf7bd, 0xe21d), 
			'[2]', 
			'two', 
		), 
		array(						//127
			array(0xf989, 0xe6e4), 
			array(0xf740, 0xe524, 0xf040, 0x7721, 0xec40), 
			array(0xf7be, 0xe21e), 
			'[3]', 
			'three', 
		), 
		array(						//128
			array(0xf98a, 0xe6e5), 
			array(0xf741, 0xe525, 0xf041, 0x7722, 0xec41), 
			array(0xf7bf, 0xe21f), 
			'[4]', 
			'four', 
		), 
		array(						//129
			array(0xf98b, 0xe6e6), 
			array(0xf742, 0xe526, 0xf042, 0x7723, 0xec42), 
			array(0xf7c0, 0xe220), 
			'[5]', 
			'five', 
		), 
		array(						//130
			array(0xf98c, 0xe6e7), 
			array(0xf743, 0xe527, 0xf043, 0x7724, 0xec43), 
			array(0xf7c1, 0xe221), 
			'[6]', 
			'six', 
		), 
		array(						//131
			array(0xf98d, 0xe6e8), 
			array(0xf744, 0xe528, 0xf044, 0x7725, 0xec44), 
			array(0xf7c2, 0xe222), 
			'[7]', 
			'seven', 
		), 
		array(						//132
			array(0xf98e, 0xe6e9), 
			array(0xf745, 0xe529, 0xf045, 0x7726, 0xec45), 
			array(0xf7c3, 0xe223), 
			'[8]', 
			'eight', 
		), 
		array(						//133
			array(0xf98f, 0xe6ea), 
			array(0xf746, 0xe52a, 0xf046, 0x7727, 0xec46), 
			array(0xf7c4, 0xe224), 
			'[9]', 
			'nine', 
		), 
		array(						//134
			array(0xf990, 0xe6eb), 
			array(0xf7c9, 0xe5ac, 0xf0c9, 0x784b, 0xecc9), 
			array(0xf7c5, 0xe225), 
			'[0]', 
			'zero', 
		), 
		array(						//135
			array(0xf9b0, 0xe70b), 
			array(0xf7ca, 0xe5ad, 0xf0ca, 0x784c, 0xecca), 
			array(0xf7ed, 0xe24d), 
			'[OK]', 
			'ok', 
		), 
		array(						//136
			array(0xf991, 0xe6ec), 
			array(0xf7b2, 0xe595, 0xf0b2, 0x7834, 0xecb2), 
			array(0xf962, 0xe022), 
			'　', 
			'heart01', 
		), 
		array(						//137
			array(0xf992, 0xe6ed), 
			array(0xf479, 0xeb75, 0xed79, 0x7b5a, 0xee79), 
			array(0xf9c7, 0xe327), 
			'　', 
			'heart02', 
		), 
		array(						//138
			array(0xf993, 0xe6ee), 
			array(0xf64f, 0xe477, 0xef4f, 0x7530, 0xeb4f), 
			array(0xf963, 0xe023), 
			'　', 
			'heart03', 
		), 
		array(						//139
			array(0xf994, 0xe6ef), 
			array(0xf650, 0xe478, 0xef50, 0x7531, 0xeb50), 
			array(0xf9c7, 0xe327), 
			'　', 
			'heart04', 
		), 
		array(						//140
			array(0xf995, 0xe6f0), 
			array(0xf649, 0xe471, 0xef49, 0x752a, 0xeb49), 
			array(0xf998, 0xe057), 
			'　', 
			'happy01', 
		), 
		array(						//141
			array(0xf996, 0xe6f1), 
			array(0xf64a, 0xe472, 0xef4a, 0x752b, 0xeb4a), 
			array(0xf99a, 0xe059), 
			'　', 
			'angry', 
		), 
		array(						//142
			array(0xf997, 0xe6f2), 
			array(0xf394, 0xeac0, 0xec94, 0x7974, 0xed94), 
			array(0xf999, 0xe058), 
			'　', 
			'despair', 
		), 
		array(						//143
			array(0xf998, 0xe6f3), 
			array(0xf397, 0xeac3, 0xec97, 0x7977, 0xed97), 
			array(0xfb47, 0xe407), 
			'　', 
			'sad', 
		), 
		array(						//144
			array(0xf999, 0xe6f4), 
			array(0xf7cb, 0xe5ae, 0xf0cb, 0x784d, 0xeccb), 
			array(0xfb46, 0xe406), 
			'　', 
			'wobbly', 
		), 
		array(						//145
			array(0xf99a, 0xe6f5), 
			array(0xf3ee, 0xeb2d, 0xecee, 0x7a70, 0xedee), 
			array(0xf7d6, 0xe236), 
			'　', 
			'up', 
		), 
		array(						//146
			array(0xf99b, 0xe6f6), 
			array(0xf7ee, 0xe5be, 0xf0ee, 0x7870, 0xecee), 
			array(0xf97e, 0xe03e), 
			'♪', 
			'note', 
		), 
		array(						//147
			array(0xf99c, 0xe6f7), 
			array(0xf695, 0xe4bc, 0xef95, 0x7575, 0xeb95), 
			array(0xf763, 0xe123), 
			'　', 
			'spa', 
		), 
		array(						//148
			array(0xf99d, 0xe6f8), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'cute', 
		), 
		array(						//149
			array(0xf99e, 0xe6f9), 
			array(0xf6c4, 0xe4eb, 0xefc4, 0x7646, 0xebc4), 
			array(0xf943, 0xe003), 
			'　', 
			'kissmark', 
		), 
		array(						//150
			array(0xf99f, 0xe6fa), 
			array(0xf37e, 0xeaab, 0xec7e, 0x795f, 0xed7e), 
			array(0xf9ce, 0xe32e), 
			'　', 
			'shine', 
		), 
		array(						//151
			array(0xf9a0, 0xe6fb), 
			array(0xf64e, 0xe476, 0xef4e, 0x752f, 0xeb4e), 
			array(0xf74f, 0xe10f), 
			'　', 
			'flair', 
		), 
		array(						//152
			array(0xf9a1, 0xe6fc), 
			array(0xf6be, 0xe4e5, 0xefbe, 0x7640, 0xebbe), 
			array(0xf9d4, 0xe334), 
			'　', 
			'annoy', 
		), 
		array(						//153
			array(0xf9a2, 0xe6fd), 
			array(0xf6cc, 0xe4f3, 0xefcc, 0x764e, 0xebcc), 
			array(0xf94d, 0xe00d), 
			'　', 
			'punch', 
		), 
		array(						//154
			array(0xf9a3, 0xe6fe), 
			array(0xf652, 0xe47a, 0xef52, 0x7533, 0xeb52), 
			array(0xf9b1, 0xe311), 
			'　', 
			'bomb', 
		), 
		array(						//155
			array(0xf9a4, 0xe6ff), 
			array(0xf6de, 0xe505, 0xefde, 0x7660, 0xebde), 
			array(0xf9c6, 0xe326), 
			'　', 
			'notes', 
		), 
		array(						//156
			array(0xf9a5, 0xe700), 
			array(0xf3ef, 0xeb2e, 0xecef, 0x7a71, 0xedef), 
			array(0xf7d8, 0xe238), 
			'　', 
			'down', 
		), 
		array(						//157
			array(0xf9a6, 0xe701), 
			array(0xf64d, 0xe475, 0xef4d, 0x752e, 0xeb4d), 
			array(0xf77c, 0xe13c), 
			'zzz', 
			'sleepy', 
		), 
		array(						//158
			array(0xf9a7, 0xe702), 
			array(0xf65a, 0xe482, 0xef5a, 0x753b, 0xeb5a), 
			array(0xf961, 0xe021), 
			'!', 
			'sign01', 
		), 
		array(						//159
			array(0xf9a8, 0xe703), 
			array(0xf3f0, 0xeb2f, 0xecf0, 0x7a72, 0xedf0), 
			array(0, 0), 
			'!?', 
			'sign02', 
		), 
		array(						//160
			array(0xf9a9, 0xe704), 
			array(0xf3f1, 0xeb30, 0xecf1, 0x7a73, 0xedf1), 
			array(0, 0), 
			'!!', 
			'sign03', 
		), 
		array(						//161
			array(0xf9aa, 0xe705), 
			array(0xf7cd, 0xe5b0, 0xf0cd, 0x784f, 0xeccd), 
			array(0, 0), 
			'　', 
			'impact', 
		), 
		array(						//162
			array(0xf9ab, 0xe706), 
			array(0xf7ce, 0xe5b1, 0xf0ce, 0x7850, 0xecce), 
			array(0xf9d1, 0xe331), 
			'　', 
			'sweat01', 
		), 
		array(						//163
			array(0xf9ac, 0xe707), 
			array(0xf6bf, 0xe4e6, 0xefbf, 0x7641, 0xebbf), 
			array(0xf9d1, 0xe331), 
			'　', 
			'sweat02', 
		), 
		array(						//164
			array(0xf9ad, 0xe708), 
			array(0xf6cd, 0xe4f4, 0xefcd, 0x764f, 0xebcd), 
			array(0xf9d0, 0xe330), 
			'　', 
			'dash', 
		), 
		array(						//165
			array(0xf9ae, 0xe709), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'sign04', 
		), 
		array(						//166
			array(0xf9af, 0xe70a), 
			array(0xf3f2, 0xeb31, 0xecf2, 0x7a74, 0xedf2), 
			array(0, 0), 
			'　', 
			'sign05', 
		), 
		array(						//167
			array(0xf950, 0xe6ac), 
			array(0xf697, 0xe4be, 0xef97, 0x7577, 0xeb97), 
			array(0xf9c4, 0xe324), 
			'　', 
			'slate', 
		), 
		array(						//168
			array(0xf951, 0xe6ad), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'pouch', 
		), 
		array(						//169
			array(0xf952, 0xe6ae), 
			array(0xf7da, 0xeb03, 0xf0da, 0x785c, 0xecda), 
			array(0, 0), 
			'　', 
			'pen', 
		), 
		array(						//170
			array(0xf955, 0xe6b1), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'shadow', 
		), 
		array(						//171
			array(0xf956, 0xe6b2), 
			array(0, 0, 0, 0, 0), 
			array(0xf75f, 0xe11f), 
			'　', 
			'chair', 
		), 
		array(						//172
			array(0xf957, 0xe6b3), 
			array(0xf3c5, 0xeaf1, 0xecc5, 0x7a47, 0xedc5), 
			array(0xfb8c, 0xe44b), 
			'　', 
			'night', 
		), 
		array(						//173
			array(0xf95b, 0xe6b7), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'soon', 
		), 
		array(						//174
			array(0xf95c, 0xe6b8), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'on', 
		), 
		array(						//175
			array(0xf95d, 0xe6b9), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'end', 
		), 
		array(						//176
			array(0xf95e, 0xe6ba), 
			array(0xf7b1, 0xe594, 0xf0b1, 0x7833, 0xecb1), 
			array(0xf96d, 0xe02d), 
			'　', 
			'clock', 
		), 
		array(						//E1
			array(0xf9b1, 0xe70c), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'[α]', 
			'appli01', 
		), 
		array(						//E2
			array(0xf9b2, 0xe70d), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'[α]', 
			'appli02', 
		), 
		array(						//E3
			array(0xf9b3, 0xe70e), 
			array(0xf7e6, 0xe5b6, 0xf0e6, 0x7868, 0xece6), 
			array(0xf946, 0xe006), 
			'　', 
			't-shirt', 
		), 
		array(						//E4
			array(0xf9b4, 0xe70f), 
			array(0xf6dd, 0xe504, 0xefdd, 0x765f, 0xebdd), 
			array(0, 0), 
			'　', 
			'moneybag', 
		), 
		array(						//E5
			array(0xf9b5, 0xe710), 
			array(0xf6e2, 0xe509, 0xefe2, 0x7664, 0xebe2), 
			array(0xf9bc, 0xe31c), 
			'　', 
			'rouge', 
		), 
		array(						//E6
			array(0xf9b6, 0xe711), 
			array(0xf47b, 0xeb77, 0xed7b, 0x7b5c, 0xee7b), 
			array(0, 0), 
			'　', 
			'denim', 
		), 
		array(						//E7
			array(0xf9b7, 0xe712), 
			array(0xf691, 0xe4b8, 0xef91, 0x7571, 0xeb91), 
			array(0, 0), 
			'　', 
			'snowboard', 
		), 
		array(						//E8
			array(0xf9b8, 0xe713), 
			array(0xf6eb, 0xe512, 0xefeb, 0x766d, 0xebeb), 
			array(0xf9c5, 0xe325), 
			'　', 
			'bell', 
		), 
		array(						//E9
			array(0xf9b9, 0xe714), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'　', 
			'door', 
		), 
		array(						//E10
			array(0xf9ba, 0xe715), 
			array(0xf6a0, 0xe4c7, 0xefa0, 0x7622, 0xeba0), 
			array(0xf76f, 0xe12f), 
			'[$]', 
			'dollar', 
		), 
		array(						//E11
			array(0xf9bb, 0xe716), 
			array(0xf7e8, 0xe5b8, 0xf0e8, 0x786a, 0xece8), 
			array(0xf94c, 0xe00c), 
			'　', 
			'pc', 
		), 
		array(						//E12
			array(0xf9bc, 0xe717), 
			array(0xf47c, 0xeb78, 0xed7c, 0x7b5d, 0xee7c), 
			array(0xf743, 0xe103), 
			'　', 
			'loveletter', 
		), 
		array(						//E13
			array(0xf9bd, 0xe718), 
			array(0xf7a4, 0xe587, 0xf0a4, 0x7826, 0xeca4), 
			array(0, 0), 
			'　', 
			'wrench', 
		), 
		array(						//E14
			array(0xf9be, 0xe719), 
			array(0xf679, 0xe4a1, 0xef79, 0x755a, 0xeb79), 
			array(0xf9a1, 0xe301), 
			'　', 
			'pencil', 
		), 
		array(						//E15
			array(0xf9bf, 0xe71a), 
			array(0xf7f9, 0xe5c9, 0xf0f9, 0x787b, 0xecf9), 
			array(0xf74e, 0xe10e), 
			'　', 
			'crown', 
		), 
		array(						//E16
			array(0xf9c0, 0xe71b), 
			array(0xf6ed, 0xe514, 0xefed, 0x766f, 0xebed), 
			array(0xf974, 0xe034), 
			'　', 
			'ring', 
		), 
		array(						//E17
			array(0xf9c1, 0xe71c), 
			array(0xf654, 0xe47c, 0xef54, 0x7535, 0xeb54), 
			array(0, 0), 
			'　', 
			'sandclock', 
		), 
		array(						//E18
			array(0xf9c2, 0xe71d), 
			array(0xf687, 0xe4ae, 0xef87, 0x7567, 0xeb87), 
			array(0xf776, 0xe136), 
			'　', 
			'bicycle', 
		), 
		array(						//E19
			array(0xf9c3, 0xe71e), 
			array(0xf382, 0xeaae, 0xec82, 0x7962, 0xed82), 
			array(0xf9d8, 0xe338), 
			'　', 
			'japanesetea', 
		), 
		array(						//E20
			array(0xf9c4, 0xe71f), 
			array(0xf797, 0xe57a, 0xf097, 0x7777, 0xec97), 
			array(0, 0), 
			'　', 
			'watch', 
		), 
		array(						//E21
			array(0xf9c5, 0xe720), 
			array(0xf394, 0xeac0, 0xec94, 0x7974, 0xed94), 
			array(0xfb43, 0xe403), 
			'　', 
			'think', 
		), 
		array(						//E22
			array(0xf9c6, 0xe721), 
			array(0xf399, 0xeac5, 0xec99, 0x7979, 0xed99), 
			array(0xfb4a, 0xe40a), 
			'　', 
			'confident', 
		), 
		array(						//E23
			array(0xf9c7, 0xe722), 
			array(0xf7f6, 0xe5c6, 0xf0f6, 0x7878, 0xecf6), 
			array(0xfb55, 0xe415), 
			'　', 
			'coldsweats01', 
		), 
		array(						//E24
			array(0xf9c8, 0xe723), 
			array(0xf7f6, 0xe5c6, 0xf0f6, 0x7878, 0xecf6), 
			array(0xf748, 0xe108), 
			'　', 
			'coldsweats02', 
		), 
		array(						//E25
			array(0xf9c9, 0xe724), 
			array(0xf461, 0xeb5d, 0xed61, 0x7b42, 0xee61), 
			array(0xfb56, 0xe416), 
			'　', 
			'pout', 
		), 
		array(						//E26
			array(0xf9ca, 0xe725), 
			array(0xf39d, 0xeac9, 0xec9d, 0x797d, 0xed9d), 
			array(0xfb4e, 0xe40e), 
			'　', 
			'gawk', 
		), 
		array(						//E27
			array(0xf9cb, 0xe726), 
			array(0xf7f4, 0xe5c4, 0xf0f4, 0x7876, 0xecf4), 
			array(0xf746, 0xe106), 
			'　', 
			'lovely', 
		), 
		array(						//E28
			array(0xf9cc, 0xe727), 
			array(0xf6d2, 0xe4f9, 0xefd2, 0x7654, 0xebd2), 
			array(0xf94e, 0xe00e), 
			'　', 
			'good', 
		), 
		array(						//E29
			array(0xf9cd, 0xe728), 
			array(0xf6c0, 0xe4e7, 0xefc0, 0x7642, 0xebc0), 
			array(0xf745, 0xe105), 
			'　', 
			'bleah', 
		), 
		array(						//E30
			array(0xf9ce, 0xe729), 
			array(0xf7f3, 0xe5c3, 0xf0f3, 0x7875, 0xecf3), 
			array(0xfb45, 0xe405), 
			'　', 
			'wink', 
		), 
		array(						//E31
			array(0xf9cf, 0xe72a), 
			array(0xf399, 0xeac5, 0xec99, 0x7979, 0xed99), 
			array(0xfb4a, 0xe40a), 
			'　', 
			'happy02', 
		), 
		array(						//E32
			array(0xf9d0, 0xe72b), 
			array(0xf396, 0xeac2, 0xec96, 0x7976, 0xed96), 
			array(0xfb46, 0xe406), 
			'　', 
			'bearing', 
		), 
		array(						//E33
			array(0xf9d1, 0xe72c), 
			array(0xf393, 0xeabf, 0xec93, 0x7973, 0xed93), 
			array(0xfb42, 0xe402), 
			'　', 
			'catface', 
		), 
		array(						//E34
			array(0xf9d2, 0xe72d), 
			array(0xf64b, 0xe473, 0xef4b, 0x752c, 0xeb4b), 
			array(0xfb51, 0xe411), 
			'　', 
			'crying', 
		), 
		array(						//E35
			array(0xf9d3, 0xe72e), 
			array(0xf46d, 0xeb69, 0xed6d, 0x7b4e, 0xee6d), 
			array(0xfb53, 0xe413), 
			'　', 
			'weep', 
		), 
		array(						//E36
			array(0xf9d4, 0xe72f), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'[NG]', 
			'ng', 
		), 
		array(						//E37
			array(0xf9d5, 0xe730), 
			array(0xf678, 0xe4a0, 0xef78, 0x7559, 0xeb78), 
			array(0, 0), 
			'　', 
			'clip', 
		), 
		array(						//E38
			array(0xf9d6, 0xe731), 
			array(0xf774, 0xe558, 0xf074, 0x7755, 0xec74), 
			array(0xf7ee, 0xe24e), 
			'(C)', 
			'copyright', 
		), 
		array(						//E39
			array(0xf9d7, 0xe732), 
			array(0xf76a, 0xe54e, 0xf06a, 0x774b, 0xec6a), 
			array(0xfbd7, 0xe537), 
			'TM', 
			'tm', 
		), 
		array(						//E40
			array(0xf9d8, 0xe733), 
			array(0xf643, 0xe46b, 0xef43, 0x7524, 0xeb43), 
			array(0xf755, 0xe115), 
			'　', 
			'run', 
		), 
		array(						//E41
			array(0xf9d9, 0xe734), 
			array(0xf6ca, 0xe4f1, 0xefca, 0x764c, 0xebca), 
			array(0xf9b5, 0xe315), 
			'[秘]', 
			'secret', 
		), 
		array(						//E42
			array(0xf9da, 0xe735), 
			array(0xf47d, 0xeb79, 0xed7d, 0x7b5e, 0xee7d), 
			array(0, 0), 
			'　', 
			'recycle', 
		), 
		array(						//E43
			array(0xf9db, 0xe736), 
			array(0xf775, 0xe559, 0xf075, 0x7756, 0xec75), 
			array(0xf7ef, 0xe24f), 
			'(R)', 
			'r-mark', 
		), 
		array(						//E44
			array(0xf9dc, 0xe737), 
			array(0xf659, 0xe481, 0xef59, 0x753a, 0xeb59), 
			array(0xf7f2, 0xe252), 
			'　', 
			'danger', 
		), 
		array(						//E45
			array(0xf9dd, 0xe738), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'[禁]', 
			'ban', 
		), 
		array(						//E46
			array(0xf9de, 0xe739), 
			array(0xf35d, 0xea8a, 0xec5d, 0x793e, 0xed5d), 
			array(0xf7cb, 0xe22b), 
			'[空]', 
			'empty', 
		), 
		array(						//E47
			array(0xf9df, 0xe73a), 
			array(0, 0, 0, 0, 0), 
			array(0, 0), 
			'[合]', 
			'pass', 
		), 
		array(						//E48
			array(0xf9e0, 0xe73b), 
			array(0xf35c, 0xea89, 0xec5c, 0x793d, 0xed5c), 
			array(0xf7ca, 0xe22a), 
			'[満]', 
			'full', 
		), 
		array(						//E49
			array(0xf9e1, 0xe73c), 
			array(0xf47e, 0xeb7a, 0xed7e, 0x7b5f, 0xee7e), 
			array(0, 0), 
			'⇔', 
			'leftright', 
		), 
		array(						//E50
			array(0xf9e2, 0xe73d), 
			array(0xf480, 0xeb7b, 0xed80, 0x7b60, 0xee80), 
			array(0, 0), 
			'　', 
			'updown', 
		), 
		array(						//E51
			array(0xf9e3, 0xe73e), 
			array(0xf353, 0xea80, 0xec53, 0x7934, 0xed53), 
			array(0xf798, 0xe157), 
			'　', 
			'school', 
		), 
		array(						//E52
			array(0xf9e4, 0xe73f), 
			array(0xf481, 0xeb7c, 0xed81, 0x7b61, 0xee81), 
			array(0xfb7e, 0xe43e), 
			'　', 
			'wave', 
		), 
		array(						//E53
			array(0xf9e5, 0xe740), 
			array(0xf7ed, 0xe5bd, 0xf0ed, 0x786f, 0xeced), 
			array(0xf97b, 0xe03b), 
			'　', 
			'fuji', 
		), 
		array(						//E54
			array(0xf9e6, 0xe741), 
			array(0xf6ec, 0xe513, 0xefec, 0x766e, 0xebec), 
			array(0xf750, 0xe110), 
			'　', 
			'clover', 
		), 
		array(						//E55
			array(0xf9e7, 0xe742), 
			array(0xf6ab, 0xe4d2, 0xefab, 0x762d, 0xebab), 
			array(0, 0), 
			'　', 
			'cherry', 
		), 
		array(						//E56
			array(0xf9e8, 0xe743), 
			array(0xf6bd, 0xe4ea, 0xefbd, 0x763f, 0xebbd), 
			array(0xf9a4, 0xe304), 
			'　', 
			'tulip', 
		), 
		array(						//E57
			array(0xf9e9, 0xe744), 
			array(0xf3f6, 0xeb35, 0xecf6, 0x7a78, 0xedf6), 
			array(0, 0), 
			'　', 
			'banana', 
		), 
		array(						//E58
			array(0xf9ea, 0xe745), 
			array(0xf38d, 0xeab9, 0xec8d, 0x796d, 0xed8d), 
			array(0xf9e5, 0xe345), 
			'　', 
			'apple', 
		), 
		array(						//E59
			array(0xf9eb, 0xe746), 
			array(0xf482, 0xeb7d, 0xed82, 0x7b62, 0xee82), 
			array(0xf750, 0xe110), 
			'　', 
			'bud', 
		), 
		array(						//E60
			array(0xf9ec, 0xe747), 
			array(0xf6a7, 0xe4ce, 0xefa7, 0x7629, 0xeba7), 
			array(0xf758, 0xe118), 
			'　', 
			'maple', 
		), 
		array(						//E61
			array(0xf9ed, 0xe748), 
			array(0xf6a3, 0xe4ca, 0xefa3, 0x7625, 0xeba3), 
			array(0xf970, 0xe030), 
			'　', 
			'cherryblossom', 
		), 
		array(						//E62
			array(0xf9ee, 0xe749), 
			array(0xf6ae, 0xe4d5, 0xefae, 0x7630, 0xebae), 
			array(0xf9e2, 0xe342), 
			'　', 
			'riceball', 
		), 
		array(						//E63
			array(0xf9ef, 0xe74a), 
			array(0xf6a9, 0xe4d0, 0xefa9, 0x762b, 0xeba9), 
			array(0xf987, 0xe046), 
			'　', 
			'cake', 
		), 
		array(						//E64
			array(0xf9f0, 0xe74b), 
			array(0xf36a, 0xea97, 0xec6a, 0x794b, 0xed6a), 
			array(0xf9ab, 0xe30b), 
			'　', 
			'bottle', 
		), 
		array(						//E65
			array(0xf9f1, 0xe74c), 
			array(0xf7d1, 0xe5b4, 0xf0d1, 0x7853, 0xecd1), 
			array(0xf9e0, 0xe340), 
			'　', 
			'noodle', 
		), 
		array(						//E66
			array(0xf9f2, 0xe74d), 
			array(0xf383, 0xeaaf, 0xec83, 0x7963, 0xed83), 
			array(0xf9d9, 0xe339), 
			'　', 
			'bread', 
		), 
		array(						//E67
			array(0xf9f3, 0xe74e), 
			array(0xf483, 0xeb7e, 0xed83, 0x7b63, 0xee83), 
			array(0, 0), 
			'　', 
			'snail', 
		), 
		array(						//E68
			array(0xf9f4, 0xe74f), 
			array(0xf6b9, 0xe4e0, 0xefb9, 0x763b, 0xebb9), 
			array(0xfbc3, 0xe523), 
			'　', 
			'chick', 
		), 
		array(						//E69
			array(0xf9f5, 0xe750), 
			array(0xf6b5, 0xe4dc, 0xefb5, 0x7637, 0xebb5), 
			array(0xf996, 0xe055), 
			'　', 
			'penguin', 
		), 
		array(						//E70
			array(0xf9f6, 0xe751), 
			array(0xf672, 0xe49a, 0xef72, 0x7553, 0xeb72), 
			array(0xf959, 0xe019), 
			'　', 
			'fish', 
		), 
		array(						//E71
			array(0xf9f7, 0xe752), 
			array(0xf3a1, 0xeacd, 0xeca1, 0x7a23, 0xeda1), 
			array(0xf997, 0xe056), 
			'　', 
			'delicious', 
		), 
		array(						//E72
			array(0xf9f8, 0xe753), 
			array(0xf485, 0xeb80, 0xed85, 0x7b65, 0xee85), 
			array(0xfb44, 0xe404), 
			'　', 
			'smile', 
		), 
		array(						//E73
			array(0xf9f9, 0xe754), 
			array(0xf6b1, 0xe4d8, 0xefb1, 0x7633, 0xebb1), 
			array(0xf95a, 0xe01a), 
			'　', 
			'horse', 
		), 
		array(						//E74
			array(0xf9fa, 0xe755), 
			array(0xf6b7, 0xe4de, 0xefb7, 0x7639, 0xebb7), 
			array(0xf74b, 0xe10b), 
			'　', 
			'pig', 
		), 
		array(						//E75
			array(0xf9fb, 0xe756), 
			array(0xf69a, 0xe4c1, 0xef9a, 0x757a, 0xeb9a), 
			array(0xf985, 0xe044), 
			'　', 
			'wine', 
		), 
		array(						//E76
			array(0xf9fc, 0xe757), 
			array(0xf7f5, 0xe5c5, 0xf0f5, 0x7877, 0xecf5), 
			array(0xf747, 0xe107), 
			'　, ', 
			'shock', 
		), 
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
			$instance[0] =& new Lib3gkEmoji();
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
		
		$this->__initCache();
	}
	
	
	/**
	 * 後始末
	 *
	 * @return (なし)
	 * @access public
	 */
	function shutdown(){
		$this->__carrier = null;
		$this->__html    = null;
		$this->__tools   = null;
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
		if(!class_exists('lib3gkcarrier')){
			require_once(dirname(__FILE__).'/lib3gk_carrier.php');
		}
		$this->__carrier = Lib3gkCarrier::get_instance();
		$this->_params = array_merge($this->__carrier->_params, $this->_params);
		$this->__carrier->_params = &$this->_params;
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
	//Lib3gkEmoji methods
	//------------------------------------------------
	/**
	 * 絵文字コードを表示キャラクターに変換
	 *
	 * @param $code integer 絵文字コード
	 * @param $oe integer 出力するエンコードキー。$this->encodings[$output_encoding]の値
	 * @param $binary boolean trueでバイナリ出力。falseで数値文字参照文字列。
	 * @return string 変換後の絵文字
	 * @access private
	 */
	function __convertEmojiChractor($code, $oe, $useHex, $binary){
		
		$replace = '';
		
		$this->__load_tools();
		
		if($code != 0){
			if(!$binary){
				if($useHex){
					$replace = '&#x'.dechex($code).';';
				}else{
					$replace = '&#'.$code.';';
				}
			}else{
				if($oe == 0){
					$replace = $this->__tools->int2str($code);
				}else{
					$replace = $this->__tools->int2utf8($code);
				}
			}
		}
		return $replace;
	}
	
	
	/**
	 * 画像絵文字の作成
	 *
	 * @param $name string 絵文字名(画像絵文字のファイル名(拡張子なし))
	 * @return string imgタグ付きの画像絵文字
	 * @access public
	 */
	function create_image_emoji($name){
		
		$this->__load_html();
		
		$url = $this->_params['img_emoji_url'].$name.'.'.$this->_params['img_emoji_ext'];
		$htmlAttribute = array(
			'border' => 0, 
			'width' => $this->_params['img_emoji_size'][0], 
			'height' => $this->_params['img_emoji_size'][1], 
		);
		return $this->__html->image($url, $htmlAttribute);
	}
	
	
	/**
	 * 絵文字の入手
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
		
		$this->__load_tools();
		
		if($carrier === null){
			$this->__load_carrier();
			$carrier = $this->__carrier->get_carrier();
		}
		
		if($binary === null){
			$binary = $this->_params['use_binary_emoji'];
		}
		
		if($this->_params['output_auto_convert_emoji'] === true){
			$carrier = KTAI_CARRIER_DOCOMO;
			$output_encoding = $this->_params['input_encoding'];
			$binary = false;
		}
		
		if($output_encoding === null){
			$output_encoding = $this->_params['output_encoding'];
		}
		$output_encoding = $this->__tools->normal_encoding_str($output_encoding);
		
		//絵文字テーブル向けのキャリア番号を決める
		//
		$oc = $this->carrier_indexes[$this->carriers[$carrier]];
		if($oc == 3){
			if($this->_params['use_img_emoji']){
				$oc = 4;
			}
		}
		
		//エンコーディングの調整
		$oe = $this->encodings[$output_encoding];
		$useHex = ($oe == 1);
		if($oc == 1 && $oe == 1 && $binary){
			$oe = 2;
		}
		if($oc == 2 && $oe == 0 && !$binary){
			$oe = 1;
			$useHex = false;
		}
		
		
		
		//入力値が文字コードだった場合はその数値によって入力エンコードを判定する
		//
		if(is_int($code)){
			if($code >= $this->__emoji_table[0][0][0]){
				$ie = 0;
			}else{
				$ie = 1;
			}
		}
		
		//文字コードなどからテーブルを探し出す
		//
		$table = null;
		foreach($this->__emoji_table as $emoji_table){
			if(is_int($code)){
				$check = $emoji_table[0][$ie];
				if($check == $code){
					$table = $emoji_table;
					break;
				}
			}else{
				$check = $this->__tools->int2str($emoji_table[0][0]);
				if($check == $code){
					$table = $emoji_table;
					break;
				}
				$check = $this->__tools->int2utf8($emoji_table[0][1]);
				if($check == $code){
					$table = $emoji_table;
					break;
				}
			}
		}
		
		//探し出したテーブルを使って絵文字コンバート
		//もし値がない場合は、PCの場合の文字列か画像絵文字を入手する
		//
		$str = '';
		if($table !== null){
			if($oc == 0 || $oc == 1 || $oc == 2){
				$str = $this->__convertEmojiChractor($table[$oc][$oe], $oe, $useHex, $binary);
				if($str == ''){
					$oc = $this->_params['use_img_emoji'] ? 4 : 3;
				}
			}
			if($oc == 3){
				$str = $table[$oc];
				if($oe == 0){
					$str = mb_convert_encoding($str, KTAI_ENCODING_SJISWIN, KTAI_ENCODING_UTF8);
				}
			}else
			if($oc == 4){
				$str = $this->create_image_emoji($table[$oc]);
			}
		}
		
		if($disp){
			echo $str;
		}
		return $str;
	}
	
	
	/**
	 * 絵文字キャッシュの初期化
	 *
	 * @return (なし)
	 * @access private
	 */
	function __initCache(){
		$this->__cached = array();
		foreach(array_keys($this->carrier_indexes) as $ci){
			foreach(array_keys($this->encoding_codes) as $ec){
				$this->__cached[$ci][$ec] = array();
			}
		}
	}
	
	
	/**
	 * 絵文字キャッシュから絵文字の入手
	 *
	 * @param $code mixed 絵文字コード(数値)もしくはバイナリ文字
	 * @param $carrier_index integer $this->carrier_indexes[$this->carriers[$carrier]]の値
	 * @param $encoding_code integer $this->encodings[$output_encoding]の値
	 * @return (なし)
	 * @access private
	 */
	function __getCache($code, $carrier_index = 0, $encoding_code = 1){
		return empty($this->__cached[$carrier_index][$encoding_code][$code]) ? false : $this->__cached[$carrier_index][$encoding_code][$code];
	}
	
	
	/**
	 * 絵文字キャッシュに絵文字のセット
	 *
	 * @param $value integer 絵文字のインデックス値
	 * @param $code mixed 絵文字コード(数値)もしくはバイナリ文字
	 * @param $carrier_index integer $this->carrier_indexes[$this->carriers[$carrier]]の値
	 * @param $encoding_code integer $this->encodings[$output_encoding]の値
	 * @return (なし)
	 * @access private
	 */
	function __setCache($value, $code, $carrier_index = 0, $encoding_code = 1){
		if(!isset($this->__emoji_table[0][$carrier_index])){
			return false;
		}
		if(!isset($this->encoding_codes[$encoding_code])){
			return false;
		}
		$this->__cached[$carrier_index][$encoding_code][$code] = $value;
		return true;
	}
	
	
	/**
	 * 絵文字解析
	 *
	 * @param $str string 解析する文字列
	 * @param $options array 解析オプション
	 * @return array 解析データ
	 * @access private
	 *
	 * $optionのとるキーと値(省略可)
	 *   'input_carrier'  入力データのキャリア
	 *   'input_encoding' 入力データのエンコーディング
	 */
	function &__analyzeEmoji($str, $options = array()){
		
		$this->__load_carrier();
		$this->__load_tools();
		
		$defalt_options = array(
			'input_carrier'   => $this->__carrier->_carrier, 
			'input_encoding'  => $this->_params['input_encoding'], 
		);
		$options = array_merge($defalt_options, $options);
		
		$ecode = $options['input_encoding'];
		$ccode = $this->carriers[$options['input_carrier']];
		if($ecode == KTAI_ENCODING_SJIS || $ecode == KTAI_ENCODING_SJISWIN || $ecode == KTAI_ENCODING_UTF8){
			$ecode = $this->encodings[$ecode];
			$pattern = $this->patterns[$ccode][$ecode];
			$binary_search = true;
		}else{
			$pattern = '';
			$binary_search = false;
		}
		
		$arr = array();
		
		//数値文字参照を入手
		//
		preg_match_all('/(&#[0-9]{5};)|(&#x[0-9a-zA-Z]{4};)/', $str, $match, PREG_OFFSET_CAPTURE);
		$pos = 0;
		$len = strlen($str);
		foreach($match[0] as $fvalue){
			$s = substr($str, $pos, $fvalue[1] - $pos);
			$e   = null;
			$enc = null;
			if(preg_match('/^&#([0-9]{5});$/', $fvalue[0], $a)){
				$e = intval($a[1]);
				$enc = 0;
			}else
			if(preg_match('/^&#x([0-9a-zA-Z]{4});$/', $fvalue[0], $a)){
				$e = hexdec($a[1]);
				$enc = 1;
			}
			$pos = $fvalue[1] + strlen($fvalue[0]);
			$arr[] = array($s, $e, $enc, $ccode);
		}
		$s = substr($str, $pos, $len - $pos);
		$arr[] = array($s, null, null, $ccode);
		
		//バイナリをチェック
		//
		if($binary_search){
			
			$tmpenc = mb_internal_encoding();
			mb_internal_encoding($options['input_encoding']);
			
			$carrier = $options['input_carrier'];
			$c = count($arr);
			for($i = 0;$i < $c;$i++){
				
				$str_bin = $arr[$i][0];
				$arr_bin = array();
				
				$pos = $spos = 0;
				$len = mb_strlen($str_bin);
				while($pos < $len){
					if(preg_match($pattern, mb_substr($str_bin, $pos, 1), $a)){
						$s = mb_substr($str_bin, $spos, $pos - $spos);
						$e = null;
						if($ecode == 0){
							$e = $this->__tools->str2int($a[0]);
						}else
						if($ecode == 1){
							$e = $this->__tools->utf82int($a[0]);
						}
						$arr_bin[] = array($s, $e, $ecode, $ccode);
						$spos = $pos + 1;
					}
					$pos++;
				}
				
				//現在の手前に配列を挿入し、あまりを代入
				//
				$arr[$i][0] = mb_substr($str_bin, $spos, $len - $spos);
				
				if(count($arr_bin) > 0){
					$arr_tmp = array();
					for($j = 0;$j < $i;$j++){
						$arr_tmp[] = array_shift($arr);
					}
					$arr = array_merge($arr_tmp, $arr_bin, $arr);
					$c  = count($arr);
					$i += count($arr_bin);
				}
			}
			mb_internal_encoding($tmpenc);
		}
		
		return $arr;
	}
	
	
	/**
	 * 絵文字の検索
	 *
	 * @param $code mixed 絵文字コード(数値)もしくはバイナリ文字
	 * @param $encoding string エンコーディング名
	 * @param $carrier integer キャリアコード
	 * @return array 絵文字テーブルから入手した絵文字データ
	 * @access private
	 */
	function __searchEmojiSet($code, $encoding = KTAI_ENCODING_UTF8, $carrier = KTAI_CARRIER_DOCOMO){
		
		//キャリアとエンコーディングの正規化
		//
		if(isset($this->carriers[$carrier])){
			$c = $this->carrier_indexes[$this->carriers[$carrier]];
		}else{
			$c = $this->carrier_indexes[$this->carriers[KTAI_CARRIER_DOCOMO]];
		}
		if(isset($this->encodings[$encoding])){
			$e = $this->encodings[$encoding];
		}else{
			$e = $this->encodings[KTAI_ENCODING_UTF8];
		}
		
		if($c == 3){
			$c = 0;		//PCはdocomo扱い
		}
		
		//キャッシュをチェック
		//
		if($this->_params['use_emoji_cache'] && ($key = $this->__getCache($code, $c, $e)) !== false){
			return $this->__emoji_table[$key];
		}
		
		//絵文字セットを探し出す(※将来的に見直し予定)
		//
		foreach($this->__emoji_table as $key => $table){
			if($code == $table[$c][$e]){
				if($this->_params['use_emoji_cache']){
					$this->__setCache($key, $code, $c, $e);
				}
				return $table;
			}
			//AUの場合は数値文字参照とバイナリの２つのコードを参照する必要あり
			//
			if($c == 1 && $e == 1){
				if($code == $table[$c][$e + 1]){
					if($this->_params['use_emoji_cache']){
						$this->__setCache($key, $code, $c, $e);
					}
					return $table;
				}
			}
		}
		return false;
	}
	
	
	/**
	 * 絵文字変換
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
		
		$this->__load_carrier();
		$this->__load_tools();
		
		$input_carrier = KTAI_CARRIER_DOCOMO;
		$output_carrier = ($carrier !== null ? $carrier : $this->__carrier->_carrier);
		if($input_encoding === null){
			$input_encoding = $this->_params['input_encoding'];
		}
		if($output_encoding === null){
			$output_encoding = $this->_params['output_encoding'];
		}
		if($binary === null){
			$binary = $this->_params['use_binary_emoji'];
		}
		
		$options = compact('input_carrier', 'output_carrier', 'input_encoding', 'output_encoding', 'binary');
		
		$arr = $this->__analyzeEmoji($str, $options);
		if(empty($arr)){
			return false;
		}
		
		$str = '';
		foreach($arr as $fvalue){
			if($fvalue[0] != ''){
				$str .= mb_convert_encoding($fvalue[0], $output_encoding, $input_encoding);
			}
			if($fvalue[1] !== null){
				$emoji = $this->__searchEmojiSet($fvalue[1], $this->encoding_codes[$fvalue[2]], $fvalue[3]);
				if(!empty($emoji)){
					if(isset($this->carriers[$output_carrier])){
						$oc = $this->carrier_indexes[$this->carriers[$output_carrier]];
					}else{
						$oc = $this->carrier_indexes[$this->carriers[KTAI_CARRIER_DOCOMO]];
					}
					if(isset($this->encodings[$output_encoding])){
						$oe = $this->encodings[$output_encoding];
					}else{
						$oe = $this->encodings[KTAI_ENCODING_UTF8];
					}
					
					//テーブルから文字コードを抜き出す
					//
					if($oc == 0 || $oc == 1 || $oc == 2){
						
						$useHex = ($oe != 0);
						
						//AUでUTF-8・binaryの場合は別テーブルを使う
						if($oc == 1 && $oe == 1 && $binary){
							$oe = 2;
						}
						
						//SBでSJIS・数値文字参照の場合はUTF-8テーブルを使う
						if($oc == 2 && $oe == 0 && !$binary){
							$oe = 1;
						}
						
						$code = $emoji[$oc][$oe];
						
						if($binary){
							if($oe == 0){
								$code = $this->__tools->int2str($code);
							}else{
								$code = $this->__tools->int2utf8($code);
							}
						}else{
							if($useHex){
								$code = sprintf('&#x%04x;', $code);
							}else{
								$code = sprintf('&#%d;', $code);
							}
						}
					}else
					if($oc == 3){
						if($this->_params['use_img_emoji']){
							$oc = 4;
							$code = $this->create_image_emoji($emoji[$oc]);
						}else{
							$code = mb_convert_encoding($emoji[$oc], $output_encoding, KTAI_ENCODING_UTF8);
						}
					}
					
					$str .= $code;
				}
			}
		}
	}
	
}
