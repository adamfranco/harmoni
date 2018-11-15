<?php

require_once (HARMONI."actionHandler/ActionSource.abstract.php");

/**
 * The ClassesActionSource looks for actions as classes located within include files. 
 * The classes each have a special method as defined by {@link ACTIONS_CLASSES_METHOD} 
 * which is called in order to execute the action.
 *
 * @package harmoni.actions.sources
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ClassesActionSource.class.php,v 1.12 2007/10/17 19:03:31 adamfranco Exp $
 */
class ClassesActionSource 
	extends ActionSource
{

	/**
	 * @var string $_basePath The base path on the filesystem to look for module 
	 *		folders.
	 * @access private
	 **/
	var $_basePath;
	
	/**
	 * @var string $_fileExtension The extension to add onto action names to locate 
	 *		their associated files.
	 * @access private
	 **/
	var $_fileExtension;
	
	/**
	 * @var string $_classNameSuffix Suffix to append to the name of classes 
	 * @access private
	 */
	var $_classNameSuffix;
	
	/**
	 * Constructor
	 * @param string $basePath The base path on the filesystem which contains the
	 * 		module folders.
	 * @param string $fileExtension The extension to add onto action names to find 
	 *		the files, such that the action "welcome" might look for a file named 
	 *		"welcome.class.php" with a file extension of ".class.php".
	 * @param optional string $classNameSuffix A string to append to the names of
	 *		action classes to prevent namespace conflicts with libraries/other 
	 *		classes. For example, with a suffix of 'Action', an action 'welcome'
	 *		would correspond to a class named 'welcomeAction'.
	 *
	 * @return void
	 * @access public
	 */
	function __construct($basePath, $fileExtension, $classNameSuffix = '') {
		$this->_basePath = preg_replace('#'.DIRECTORY_SEPARATOR."$#", "", $basePath);
		$this->_fileExtension = $fileExtension;
		$this->_classNameSuffix = $classNameSuffix;
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
		return file_exists($fullPath);
	}
	
	/**
	 * Makes a full pathname to an action file.
	 * @access private
	 * @return string
	 */
	function _mkFullPath($module, $action)
	{
		return $this->_basePath . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $action . $this->_fileExtension;
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
		
		$actionClassname = $action.$this->_classNameSuffix;
		
		if (!class_exists($actionClassname)) {
			throwError( new HarmoniError("ClassesActionSource::executeAction($module, $action) - could not proceed because the class name '$action' is not defined!","ActionHandler", true));
		}
		
		$class = new $actionClassname;
		
		$method = ACTIONS_CLASSES_METHOD;
		
		if (!method_exists($class, $method)) {
			throwError( new HarmoniError("ClassesActionSource::executeAction($module, $action) - could not proceed because the method '$method()' is not defined in the class '$action'!","ActionHandler", true));
		}
		
		$result =$class->$method();
		
		return $result;
	}
}