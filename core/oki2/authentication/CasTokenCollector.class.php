<?php
/**
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TokenCollector.abstract.php,v 1.2 2005/03/23 21:26:40 adamfranco Exp $
 */ 

/**
 * The TokenCollector is reponsible for prompting a user authentication tokens
 * and recieving the response from the user.
 * 
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TokenCollector.abstract.php,v 1.2 2005/03/23 21:26:40 adamfranco Exp $
 */
class CasTokenCollector 
	extends TokenCollector
{
		
	/**
	 * Prompt the user to supply their tokens
	 * 
	 * @return void
	 * @access public
	 * @since 3/16/05
	 */
	function prompt () {
		 phpCAS::forceAuthentication();
	}
	
	/**
	 * Collect any tokens that the user may have supplied. Reply NULL if none
	 * are found.
	 * 
	 * @return mixed
	 * @access public
	 * @since 3/16/05
	 */
	function collect () {
		if (phpCAS::isAuthenticated())
			return phpCAS::getUser();
		else
			return null;
	}
}

?>