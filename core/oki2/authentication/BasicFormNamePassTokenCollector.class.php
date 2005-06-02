<?php
/**
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BasicFormNamePassTokenCollector.class.php,v 1.2 2005/06/02 20:18:49 adamfranco Exp $
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
 * @version $Id: BasicFormNamePassTokenCollector.class.php,v 1.2 2005/06/02 20:18:49 adamfranco Exp $
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
		$harmoni =& Harmoni::instance();
		$harmoni->request->startNamespace("harmoni-authentication");
		
		$action = $_SERVER['PHP_SELF'];
		$usernameField = $harmoni->request->getName("username");
		$passwordField = $harmoni->request->getName("password");
		$usernameText = _("Username");
		$passwordText = _("Password");
		
		print<<<END

<form name='login' action='$action' method='post'>
	$usernameText: <input type='text' name='$usernameField' />
	<br />$passwordText: <input type='password' name='$passwordField' />
	<br /><input type='submit' />
</form>

END;
		$harmoni->request->endNamespace();
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
		$harmoni =& Harmoni::instance();
		$harmoni->request->startNamespace("harmoni-authentication");
		$username = $harmoni->request->get("username");
		$harmoni->request->endNamespace();
		return $username;
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
		$harmoni =& Harmoni::instance();
		$harmoni->request->startNamespace("harmoni-authentication");
		$password = $harmoni->request->get("password");
		$harmoni->request->endNamespace();
		return $password;
	}
}

?>