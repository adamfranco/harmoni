<?php
/**
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HTTPAuthNamePassTokenCollector.class.php,v 1.2.4.2 2006/08/07 15:16:49 adamfranco Exp $
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
 * @version $Id: HTTPAuthNamePassTokenCollector.class.php,v 1.2.4.2 2006/08/07 15:16:49 adamfranco Exp $
 */
class HTTPAuthNamePassTokenCollector
	extends NamePassTokenCollector
{
	/**
	 * Run the token collection sequence involving prompting for and collecting
	 * tokens.
	 * 
	 * @return mixed
	 * @access public
	 * @since 3/18/05
	 */
	function collectTokens () {
		
		if ((isset($_SESSION['__LastLoginTokens']) 
				&& 	md5($_SERVER['PHP_AUTH_USER'].$_SERVER['PHP_AUTH_PW'])
			 		!= $_SESSION['__LastLoginTokens']) 
			 || !$_SERVER['PHP_AUTH_USER']) 
		{
			$this->prompt();
		}
		
		$_SESSION['__LastLoginTokens'] 
			= md5($_SERVER['PHP_AUTH_USER'].$_SERVER['PHP_AUTH_PW']);
		
		return $this->collect();
	}
	
	/**
	 * Prompt the user to supply their tokens
	 * 
	 * @return void
	 * @access public
	 * @since 3/16/05
	 */
	function prompt () {
		header("WWW-Authenticate: Basic realm=\"Harmoni-protected Realm\"");
		header('HTTP/1.0 401 Unauthorized');
		print "The Username/Password pair that you entered were not valid.";
		print "<br />Please go back";
		print " and try again.";
		exit;
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