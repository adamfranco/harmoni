<?php

/**
 * The Context class provides easy access to variables for action scripts and classes. 
 *
 * @package harmoni.architecture
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Context.class.php,v 1.5 2007/09/04 20:25:30 adamfranco Exp $
 **/
class Context {
	/**
	 * @access public
	 * @var string $sid The session name & id: "name=id"
	 **/
	var $sid;
	
	/**
	 * @access public
	 * @var string $hiddenFieldSID HTML containing a form <b>hidden</b> tag with the SID in it.
	 */ 
	var $hiddenFieldSID;
	
	/**
	 * @access public
	 * @var string $myURL The current script's URL
	 **/
	var $myURL;
	
	/**
	 * @access public
	 * @var string $requestModule The module that was requested by the user.
	 **/
	var $requestModule;
	
	/**
	 * @access public
	 * @var string $requestAction The action requested by the user.
	 **/
	var $requestAction;
	
	/**
	 * @access public
	 * @var string $requestModuleDotAction The dotted-pair for module.action requested by the user.
	 **/
	var $requestModuleDotAction;
	
	/**
	 * @access public
	 * @var array $actionPath An array containing all actions executed so far.
	 */
	var $actionPath;
	
	/**
	 * @access private
	 * @var object $_contextData Holds data stored for use by actions by {@link Harmoni::attachContextData()}.
	 */
//	var $_contextData;
	
	/**
	 * The constructor
	 * @param string $module
	 * @param string $action
	 * @access public
	 * @return void
	 **/
	function Context($module, $action, $execPath) {
		$this->sid = session_name() . "=" . session_id();
		$this->hiddenFieldSID = "<input type='hidden' name='".session_name()."' value='".session_id()."' />";
		$this->myURL = $_SERVER['PHP_SELF'];
		
		$this->requestAction = $action;
		$this->requestModule = $module;
		$this->requestModuleDotAction = "$module.$action";
		
		$this->actionPath =$execPath;
		
//		if (!$contextData) $contextData = new FieldSet();
//		$this->_contextData =$contextData;
	}
}

?>