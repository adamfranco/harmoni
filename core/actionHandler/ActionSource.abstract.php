<?php

/**
 * An abstract class for all ActionSource classes. ActionSource classes give the {@link ActionHandler} places to look for
 * modules and actions for execution.
 *
 * @package harmoni.actions
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ActionSource.abstract.php,v 1.6 2007/10/17 19:03:24 adamfranco Exp $
 *
 * @abstract
 */
abstract class ActionSource {
	
	/**
	 * Checks to see if a given modules/action pair exists for execution within this source.
	 * @param string $module
	 * @param string $action
	 * @access public
	 * @return boolean
	 */
	function actionExists($module, $action)
	{
		return false;
	}
	
	/**
	 * Executes the specified action in the specified module, using the Harmoni object as a base.
	 * @param string $module The module in which to execute.
	 * @param string $action The specific action to execute.
	 * @access public
	 * @return ref mixed A {@link Layout} or TRUE/FALSE
	 */
	abstract function executeAction($module, $action);
	
}