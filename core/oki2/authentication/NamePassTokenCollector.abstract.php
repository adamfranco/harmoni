<?php
/**
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: NamePassTokenCollector.abstract.php,v 1.1 2005/03/16 22:48:41 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/TokenCollector.abstract.php");

/**
 * The NamePassTokenCollector returns its tokens as an array with two elements:
 * 'username', 'password'. Descendents of this abstract class must implement
 * the collectName() and collectPassword() methods in addition to prompt inherited
 * from TokenCollector.
 * 
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: NamePassTokenCollector.abstract.php,v 1.1 2005/03/16 22:48:41 adamfranco Exp $
 */
class NamePassTokenCollector
	extends TokenCollector
{
	
	/**
	 * Collect any tokens that the user may have supplied. Reply NULL if none
	 * are found. (This method uses the "Template Method" design pattern.)
	 * 
	 * @return mixed
	 * @access protected
	 * @since 3/16/05
	 */
	function collect () {
		// Allow for null passwords, but not null names.
		if ($this->collectName()) {
			return array(
				'username' => $this->collectName(),
				'password' => $this->collectPassword()
			);
		} else {
			return NULL;
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
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
		 die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}

?>