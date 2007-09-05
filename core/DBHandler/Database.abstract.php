<?php
/**
 * @since 9/5/07
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Database.abstract.php,v 1.1 2007/09/05 21:38:59 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/Database.interface.php");

/**
 * abstract definition of common database methods
 * 
 * @since 9/5/07
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Database.abstract.php,v 1.1 2007/09/05 21:38:59 adamfranco Exp $
 */
abstract class DatabaseAbstract 
	implements Database
{
		
	/**
	 * Answer the info to display to users on a connection error.
	 * 
	 * @return string
	 * @access public
	 * @since 6/1/06
	 */
	function getConnectionErrorInfo () {
		$dbManager = Services::getService("DatabaseManager");
		$configuration =$dbManager->_configuration;
		if ($configuration->getProperty('connectionInfo')) {
			return '<div style="border: 1px dotted; background-color: #FAA; margin: 10px; padding: 10px;">'.$configuration->getProperty('connectionInfo').'</div>';
		} else {
			return '';
		}
	}
	
}

?>