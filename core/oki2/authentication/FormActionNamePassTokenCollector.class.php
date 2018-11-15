<?php
/**
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FormActionNamePassTokenCollector.class.php,v 1.3 2005/07/19 15:57:51 adamfranco Exp $
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
 * @version $Id: FormActionNamePassTokenCollector.class.php,v 1.3 2005/07/19 15:57:51 adamfranco Exp $
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
	function __construct ($url) {
		if (count($_GET) && !preg_match("/\?/", $url)) {
			$url .= "?";
			foreach ($_GET as $name => $value) {
				$url .= "&amp;".$name."=".$value;
			}
		}
		
		$this->_url = $url;
	}
	/**
	 * Prompt the user to supply their tokens
	 * 
	 * @return void
	 * @access public
	 * @since 3/16/05
	 */
	function prompt () {
		RequestContext::locationHeader($this->_url);
	}
}

?>