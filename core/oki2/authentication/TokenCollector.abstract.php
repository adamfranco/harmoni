<?php
/**
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TokenCollector.abstract.php,v 1.1 2005/03/16 22:48:41 adamfranco Exp $
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
 * @version $Id: TokenCollector.abstract.php,v 1.1 2005/03/16 22:48:41 adamfranco Exp $
 */
class TokenCollector {
		
	/**
	 * Prompt the user to supply their tokens
	 * 
	 * @return void
	 * @access public
	 * @since 3/16/05
	 */
	function prompt () {
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}

?>