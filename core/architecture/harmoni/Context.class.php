<?php

/**
 * The Context class provides easy access to variables for action scripts and classes. 
 *
 * @package harmoni.architecture
 * @version $Id: Context.class.php,v 1.2 2003/11/27 04:55:41 gabeschine Exp $
 * @copyright 2003 
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
	 * @access private
	 * @var object $_contextData Holds data stored for use by actions by {@link Harmoni::attachContextData()}.
	 */
	var $_contextData;
	
	/**
	 * The constructor
	 * @param string $module
	 * @param string $action
	 * @access public
	 * @return void
	 **/
	function Context($module, $action, &$contextData) {
		$this->sid = session_name() . "=" . session_id();
		$this->hiddenFieldSID = "<input type='hidden' name='".session_name()."' value='".session_id()."' />";
		$this->myURL = $_SERVER['PHP_SELF'];
		
		$this->requestAction = $action;
		$this->requestModule = $module;
		$this->requestModuleDotAction = "$module.$action";
		
		if (!$contextData) $contextData =& new FieldSet();
		$this->_contextData =& $contextData;
	}
	
	/**
	* @return mixed
	* @param string $key
	* @desc Returns the data attached by {@link Harmoni::attachContextData} referenced by $key.
	*/
	function &getData($key) {
		return $this->_contextData->get($key);
	}
}

?>