<?

require_once HARMONI."actionHandler/ActionSource.abstract.php";

/**
 * The ClassesActionSource looks for actions as classes located within include files. The classes each have a special method
 * as defined by {@link ACTIONS_CLASSES_METHOD} which is called in order to execute the action.
 * @package harmoni.actionhandler.sources
 * @copyright 2004
 * @version $Id: ClassesActionSource.class.php,v 1.1 2004/05/28 19:06:12 gabeschine Exp $
 */
class ClassesActionSource {

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
	 * @param string $basePath The base path on the filesystem which contains the module folders.
	 * @param string $fileExtension The extension to add onto action names to find the files, such that
	 * the action "welcome" might look for a file named "welcome.class.php" with a file extension of ".class.php".
	 * @return void
	 * @access public
	 */
	function ClassesActionSource($basePath, $fileExtension) {
		$this->_basePath = ereg_replace(DIRECTORY_SEPARATOR."$", "", $basePath);
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
	 * @param ref object $harmoni A reference to a {@link Harmoni} object.
	 * @access public
	 * @return ref mixed A {@link Layout} or TRUE/FALSE
	 */
	function &executeAction($module, $action, &$harmoni)
	{
		$fullPath = $this->_mkFullPath($module, $action);
		if (!$this->actionExists($module, $action)) {
			throwError( new Error("ClassesActionSource::executeAction($module, $action) - could not proceed because the file to include does not exist!", "ActionHandler", true));
		}
		
		include($fullPath);
		
		if (!class_exists($action)) {
			throwError( new Error("ClassesActionSource::executeAction($module, $action) - could not proceed because the class name '$action' is not defined!","ActionHandler", true));
		}
		
		$class = @new $action;
		
		$method = ACTIONS_CLASSES_METHOD;
		
		if (!method_exists($class, $method)) {
			throwError( new Error("ClassesActionSource::executeAction($module, $action) - could not proceed because the method '$method()' is not defined in the class '$action'!","ActionHandler", true));
		}
		
		$result =& $class->$method($harmoni);
		
		return $result;
	}
}