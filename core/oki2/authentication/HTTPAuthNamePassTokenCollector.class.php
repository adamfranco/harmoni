<?php
/**
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HTTPAuthNamePassTokenCollector.class.php,v 1.1 2005/03/16 22:48:40 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/NamePassTokenCollector.abstract.php");

/**
 * The HTTPAuthNamePassTokenCollector prompts a user for their name and password
 * by sending HTTP Authenticatio headers to the user. 
 * 
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HTTPAuthNamePassTokenCollector.class.php,v 1.1 2005/03/16 22:48:40 adamfranco Exp $
 */
class HTTPAuthNamePassTokenCollector
	extends NamePassTokenCollector
{
	
	/**
	 * Prompt the user to supply their tokens
	 * 
	 * @return void
	 * @access public
	 * @since 3/16/05
	 */
	function prompt () {
		if (!$_SERVER['PHP_AUTH_USER']) {
			header("WWW-Authenticate: Basic realm=\"Harmoni-protected Realm\"");
			header('HTTP/1.0 401 Unauthorized');
		}
	}
	
	/**
	 * Collect the name that the user may have supplied, Reply NULL if none
	 * are found.
	 * 
	 * @return mixed
	 * @access public
	 * @since 3/16/05
	 */
	function collectName () {
		 return $_SERVER['PHP_AUTH_USER'];
	}
	
	/**
	 * Collect the password that the user may have supplied, Reply NULL if none
	 * are found.
	 * 
	 * @return mixed
	 * @access public
	 * @since 3/16/05
	 */
	function collectPassword () {
		 return $_SERVER['PHP_AUTH_PW'];
	}
}

?>