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

define('KTAI_CARRIER_UNKNOWN',  0);
define('KTAI_CARRIER_DOCOMO',   1);
define('KTAI_CARRIER_KDDI',     2);
define('KTAI_CARRIER_SOFTBANK', 3);
define('KTAI_CARRIER_EMOBILE',  4);
define('KTAI_CARRIER_IPHONE',   5);
define('KTAI_CARRIER_PHS',      6);
define('KTAI_CARRIER_CLAWLER',  7);
define('KTAI_CARRIER_ANDROID',  8);

define('KTAI_ENCODING_SJIS', 'SJIS');
define('KTAI_ENCODING_SJISWIN', 'SJIS-win');
define('KTAI_ENCODING_UTF8', 'UTF-8');

