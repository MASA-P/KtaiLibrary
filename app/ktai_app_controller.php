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

//******************************
//  NOTICE
//******************************
//If you use session in your mobile phone site, copy this file 
//to app/controllers directory or paste nessesary parts in this file to your 
//AppController class.

/* SVN FILE: $Id: app_controller.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class KtaiAppController extends AppController {
	
	var $components = array('Ktai');
	
	//----------------------------------------------------------
	//Redirect override.
	//If iMODE access or use_redirect_session_id is true, 
	// adding session id to url param.
	//----------------------------------------------------------
	function __redirect_url($url){
		
		if(isset($this->Ktai)){
			if($this->Ktai->_options['enable_ktai_session'] && 
				($this->Ktai->_options['use_redirect_session_id'] || $this->Ktai->is_imode())){
				if(!is_array($url)){
					if(preg_match('|^http[s]?://|', $url)){
						return $url;
					}
					$url = Router::parse($url);
				}
				if(!isset($url['?'])){
					$url['?'] = array();
				}
				$url['?'][session_name()] = session_id();
			}
		}
		return $url;
	}
	function redirect($url, $status = null, $exit = true){
		return parent::redirect($this->__redirect_url($url), $status, $exit);
	}
}
