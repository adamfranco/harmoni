<?php

require_once HARMONI."actionHandler/ActionSource.abstract.php";

/**
 * The ClassMethodsActionSource looks for actions as methods located within a class. The action names correspond to a method
 * of the same name within a class. The class name is the same as module name.
 *
 * @package harmoni.actions.sources
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ClassMethodsActionSource.class.php,v 1.7 2007/10/17 19:03:30 adamfranco Exp $
 */
class ClassMethodsActionSource extends ActionSource{

	/**
	 * @var string $_basePath The base path on the filesystem to look for module folders.
	 * @access private
	 **/
	var $_basePath;
	
	/**
	 * @var string $_fileExtension The extension to add onto action names to locate their associated files.
	 * @access private
	 **/
	var $_fileExtension;
	
	/**
	 * Constructor
	 * @param string $basePath The base path on the filesystem which contains the module class declarations.
	 * @param string $fileExtension The extension to add onto module names to find the files, such that
	 * the module "main" might look for a file named "main.class.php" with a file extension of ".class.php".
	 * @return void
	 * @access public
	 */
	function ClassMethodsActionSource($basePath, $fileExtension) {
		$this->_basePath = preg__replace('#'.DIRECTORY_SEPARATOR."$#", "", $basePath);
		$this->_fileExtension = $fileExtension;
	}
	
	/**
	 * Checks to see if a given modules/action pair exists for execution within this source.
	 * @param string $module
	 * @param string $action
	 * @access public
	 * @return boolean
	 */
	function actionExists($module, $action)
	{
		$fullPath = $this->_mkFullPath($module, $action);
		if (file_exists($fullPath)) {
			include_once($fullPath);
			
			if (class_exists($module)) {
				$class = @new $module;
				
				if (method_exists($class, $action)) {
					unset($class);
					return true;
				}
				unset($class);
			}
		}
		return false;
	}
	
	/**
	 * Makes a full pathname to an action file.
	 * @access private
	 * @return string
	 */
	function _mkFullPath($module, $action)
	{
		
		return $this->_basePath . DIRECTORY_SEPARATOR . $module . $this->_fileExtension;
	}
	
	/**
	 * Executes the specified action in the specified module, using the Harmoni object as a base.
	 * @param string $module The module in which to execute.
	 * @param string $action The specific action to execute.
	 * @access public
	 * @return ref mixed A {@link Layout} or TRUE/FALSE
	 */
	function executeAction($module, $action)
	{
		$fullPath = $this->_mkFullPath($module, $action);
		if (!$this->actionExists($module, $action)) {
			throwError( new HarmoniError("ClassesActionSource::executeAction($module, $action) - could not proceed because the file to include does not exist!", "ActionHandler", true));
		}
		
		include_once($fullPath);
		
		if (!class_exists($module)) {
			throwError( new HarmoniError("ClassesActionSource::executeAction($module, $action) - could not proceed because the class name '$action' is not defined!","ActionHandler", true));
		}
		
		$class = @new $module;
		
		$method = $action;
		
		if (!method_exists($class, $method)) {
			throwError( new HarmoniError("ClassesActionSource::executeAction($module, $action) - could not proceed because the method '$method()' is not defined in the class '$action'!","ActionHandler", true));
		}
		
		$result =$class->$method();
		
		return $result;
	}
}