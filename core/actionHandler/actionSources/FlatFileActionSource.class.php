<?

require_once HARMONI."actionHandler/ActionSource.abstract.php";

/**
 * The FlatFileActionSource class allows one to execute Harmoni actions (see {@link ActionHandler}) which are contained within
 * flat files. Modules exist as folders on the file system, and actions exist as PHP source files within those folders. They may
 * be organized like so: <p>
 * basepath/user/login.act.php
 * basepath/user/logout.act.php
 * basepath/main/welcome.act.php
 * <p>
 * In this example, the base path would be "basepath/", and the actions file extension would be ".act.php".
 * @package harmoni.actionhandler.sources
 * @copyright 2004
 * @version $Id: FlatFileActionSource.class.php,v 1.2 2004/05/29 13:39:37 gabeschine Exp $
 */
class FlatFileActionSource {

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
	 * the action "welcome" might look for a file named "welcome.act.php" with a file extension of ".act.php".
	 * @return void
	 * @access public
	 */
	function FlatFileActionSource($basePath, $fileExtension=".php") {
//		$this->_basePath = ereg_replace(DIRECTORY_SEPARATOR."$", "", $basePath);
		$this->_basePath = $basePath;
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
			throwError( new Error("FlatFileActionSource::executeAction($module, $action) - could not proceed because the file to include does not exist!", "ActionHandler", true));
		}
		
		$result = include($fullPath);
		return $result;
	}
}