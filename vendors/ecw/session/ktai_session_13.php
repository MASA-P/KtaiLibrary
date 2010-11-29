<?php

//Session.save proccess for CakePHP1.3(implements from 1.3.5)
//
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
			if (Configure::read('Session.model') === null) {
				trigger_error(__("You must set the all Configure::write('Session.*') in core.php to use database storage"), E_USER_WARNING);
				$this->_stop();
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
			array('CakeSession', '__gc')
		);
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
				require LIBS . 'cache.php';
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
			array('Cache', 'gc')
		);
	break;
	default:
		$config = CONFIGS . Configure::read('Session.save') . '.php';

		if (is_file($config)) {
			require($config);
		}
	break;
}
