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
class TokenCollector {
	
	/**
	 * Run the token collection sequence involving prompting for and collecting
	 * tokens.
	 * 
	 * @return mixed
	 * @access public
	 * @since 3/18/05
	 */
	function collectTokens () {
		if (!$tokens = $this->collect()) {
			$this->prompt();
			$tokens = $this->collect();
		}
		
		return $tokens;
	}
		
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