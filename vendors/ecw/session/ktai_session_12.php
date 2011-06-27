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
 * Session.save proccess for CakePHP1.2(implements from 1.2.8)
 */
switch (Configure::read('Session.save')) {
	case 'cake':
		if (empty($_SESSION)) {
			if ($iniSet) {
				ini_set('session.use_trans_sid', 0);
				ini_set('url_rewriter.tags', '');
				ini_set('session.serialize_handler', 'php');
				ini_set('session.use_cookies', 1);
				ini_set('session.name', Configure::read('Session.cookie'));
				ini_set('session.cookie_lifetime', $this->cookieLifeTime);
				ini_set('session.cookie_path', $this->path);
				ini_set('session.auto_start', 0);
				ini_set('session.save_path', TMP . 'sessions');
			}
		}
	break;
	case 'database':
		if (empty($_SESSION)) {
			if (Configure::read('Session.table') === null) {
				trigger_error(__("You must set the all Configure::write('Session.*') in core.php to use database storage"), E_USER_WARNING);
				exit();
			} elseif (Configure::read('Session.database') === null) {
				Configure::write('Session.database', 'default');
			}
			if ($iniSet) {
				ini_set('session.use_trans_sid', 0);
				ini_set('url_rewriter.tags', '');
				ini_set('session.save_handler', 'user');
				ini_set('session.serialize_handler', 'php');
				ini_set('session.use_cookies', 1);
				ini_set('session.name', Configure::read('Session.cookie'));
				ini_set('session.cookie_lifetime', $this->cookieLifeTime);
				ini_set('session.cookie_path', $this->path);
				ini_set('session.auto_start', 0);
			}
		}
		session_set_save_handler(
			array('CakeSession','__open'),
			array('CakeSession', '__close'),
			array('CakeSession', '__read'),
			array('CakeSession', '__write'),
			array('CakeSession', '__destroy'),
			array('CakeSession', '__gc'));
	break;
	case 'php':
		if (empty($_SESSION)) {
			if ($iniSet) {
				ini_set('session.use_trans_sid', 0);
				ini_set('session.name', Configure::read('Session.cookie'));
				ini_set('session.cookie_lifetime', $this->cookieLifeTime);
				ini_set('session.cookie_path', $this->path);
			}
		}
	break;
	case 'cache':
		if (empty($_SESSION)) {
			if (!class_exists('Cache')) {
				uses('Cache');
			}
			if ($iniSet) {
				ini_set('session.use_trans_sid', 0);
				ini_set('url_rewriter.tags', '');
				ini_set('session.save_handler', 'user');
				ini_set('session.use_cookies', 1);
				ini_set('session.name', Configure::read('Session.cookie'));
				ini_set('session.cookie_lifetime', $this->cookieLifeTime);
				ini_set('session.cookie_path', $this->path);
			}
		}
		session_set_save_handler(
			array('CakeSession','__open'),
			array('CakeSession', '__close'),
			array('Cache', 'read'),
			array('Cache', 'write'),
			array('Cache', 'delete'),
			array('Cache', 'gc'));
	break;
	default:
		if (empty($_SESSION)) {
			$config = CONFIGS . Configure::read('Session.save') . '.php';

			if (is_file($config)) {
				require($config);
			}
		}
	break;
}
