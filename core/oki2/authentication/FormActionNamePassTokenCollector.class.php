<?php
/**
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FormActionNamePassTokenCollector.class.php,v 1.1 2005/03/23 21:26:38 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/BasicFormNamePassTokenCollector.class.php");

/**
 * The HTTPAuthNamePassTokenCollector prompts a user for their name and password
 * by sending HTTP Authenticatio headers to the user. 
 * 
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FormActionNamePassTokenCollector.class.php,v 1.1 2005/03/23 21:26:38 adamfranco Exp $
 */
class FormActionNamePassTokenCollector
	extends BasicFormNamePassTokenCollector
{
	/**
	 * Constructor
	 * 
	 * @param string $module
	 * @param string $action
	 * @return object
	 * @access public
	 * @since 3/22/05
	 */
	function FormActionNamePassTokenCollector ($url) {
		$this->_url = $url;
// 		$this->_action = $action;
// 		$this->_harmoni =& $GLOBALS['harmoni'];
	}
	/**
	 * Prompt the user to supply their tokens
	 * 
	 * @return void
	 * @access public
	 * @since 3/16/05
	 */
	function prompt () {
		header("Location: ".$this->_url);
// 		$this->_harmoni->ActionHandler->forward($this->_module, $this->_action);
// 		exit;
	}
}

?>