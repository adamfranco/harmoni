<?php
/**
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BasicFormNamePassTokenCollector.class.php,v 1.1 2005/03/23 21:26:37 adamfranco Exp $
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
 * @version $Id: BasicFormNamePassTokenCollector.class.php,v 1.1 2005/03/23 21:26:37 adamfranco Exp $
 */
class BasicFormNamePassTokenCollector
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
		$action = $_SERVER['PHP_SELF'];
		$usernameText = _("Username");
		$passwordText = _("Password");
		print<<<END

<form name='login' action='$action' method='post'>
	$usernameText: <input type='text' name='username' />
	<br />$passwordText: <input type='password' name='password' />
	<br /><input type='submit' />
</form>

END;
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
		return $_REQUEST['username'];
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
		return $_REQUEST['password'];
	}
}

?>