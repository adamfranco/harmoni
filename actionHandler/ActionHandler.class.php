<?php

require_once(HARMONI."actionHandler/ActionHandler.interface.php");
require_once(HARMONI."actionHandler/DottedPairValidatorRule.class.php");

/**
 * The ActionHandler interface defines the required methods for an ActionHandler class.
 * 
 * The ActionHandler takes care of: authentication, and then executing PHP
 * scripts in a user-defined place with user-defined options.
 * 
 * An action can be a: flat PHP file, an entire PHP class, or a specific method
 * within a class. Actions are organized into modules, which can be: a folder or a class.
 * A specific actions is referenced by "module->action" certain module/action options
 * are not compatible (such as modules=folders and actions=method-within-class).
 * 
 * An action is passed the following items:<br/>
 * <li>A {@link FieldSet} object of post/get variables from the web browser.
 * <li>A {@link Context} object.
 * <li>A {@link LoginState} object.
 *
 * @package harmoni.actions
 * @version $Id: ActionHandler.class.php,v 1.2 2003/07/22 22:05:46 gabeschine Exp $
 * @copyright 2003 
 **/
class ActionHandlerInterface {
	/**
	 * @access private
	 * @var array $_threads A hashed-array of subsequent actions for any given action.
	 **/
	var $_threads;
	
	/**
	 * @access private
	 * @var string $_modulesPath The path in the filesystem of the modules.
	 **/
	var $_modulesPath;
	
	/**
	 * @access private
	 * @var string $_modulesFileExtension The file extension for modules (only needed when
	 * they are classes).
	 **/
	var $_modulesFileExtension;
	
	/**
	 * @access private
	 * @var string $_actionsFileExtension The file extension for actions (only needed when
	 * actions are either files or classes).
	 **/
	var $_actionsFileExtension;
	
	/**
	 * @access private
	 * @var integer $_modulesType What the modules are: folders or classes.
	 **/
	var $_modulesType;
	
	/**
	 * @access private
	 * @var integer $_actionsType What the actions are: files, classes or class-methods.
	 **/
	var $_actionsType;
	
	/**
	 * @access private
	 * @var array $_actionsExecuted An array of actions we've already executed. Used in order
	 * to avoid infinite-loops created by stupid people creating stupid action threads.
	 **/
	var $_actionsExecuted;
	
	/**
	 * @access private
	 * @var object $_httpVars A {@link FieldSet} object containing HTTP variables from GET and POST.
	 **/
	var $_httpVars;
	
	/**
	 * @access private
	 * @var object $_context
	 **/
	var $_context;
	
	/**
	 * @access private
	 * @var object $_loginState
	 **/
	var $_loginState;
	
	/**
	 * The constructor.
	 * @param object $httpVars A {@link FieldSet} object of HTTP variables.
	 * @param optional object $context A {@link Context} object.
	 * @param optional object $loginState A {@link LoginState} object.
	 * @access public
	 * @return void
	 **/
	function ActionHandler($httpVars, $context=null, $loginState=null) {
		$this->_httpVars =& $httpVars;
		$this->_context =& $context;
		$this->_loginState =& $loginState;
		$this->_actionsExecuted = array();
		$this->_threads = array();
	}
	
	
	/**
	 * The execute function takes a module and action. The method executes
	 * the given action, taking the result and either executing another action
	 * (based on the user specified options) or returning the result from the action.
	 * @param string $module The module name.
	 * @param string $action The action name.
	 * @access public
	 * @return ref mixed Returns whatever is recieved from the last action
	 * to execute. Can be: a {@link Layout} object, TRUE/FALSE, etc.
	 **/
	function & execute($module, $action) {
		// first make sure that the pair of actionType/moduleType we have is valid
		// eg, if modules are folder, actions cannot be class-methods.
		// if modules are classes, actions cannot be flatfiles.
		$are_ok = false;
		if ($this->_modulesType == MODULES_FOLDERS) {
			if ($this->_actionsType == ACTIONS_FLATFILES) $are_ok = true;
			if ($this->_actionsType == ACTIONS_CLASSES) $are_ok = true;
		} else if ($this->_modulesType == MODULES_CLASSES) {
			if ($this->_actionsType == ACTIONS_CLASS_METHODS) $are_ok = true;
		}
		if (!$are_ok) {
			// throw an error
			throwError(new Error("ActionHandler::execute() - Could not proceed: an illegal combination of modulesType and actionsType was set.","ActionHandler",true));
			return $are_ok;
		}
		
		// make sure we have a login state
		if (!$this->_loginState)
			throwError(new Error("ActionHandler::execute() - Could not proceed: it seems we do not yet have a LoginState object set.","ActionHandler",true));
		
		$this->_execute($module, $action);
	}
	
	/**
	 * Executes the given action
	 * @param string $module
	 * @param string $action
	 * @access private
	 * @return mixed
	 **/
	function &_execute($module, $action) {
		$_pair = "$module.$action";
		// if we've already executed this action, we're probably stuck
		// in an infinied loop. no good!
		if (in_array($pair, $this->_actionsExecuted)) {
			throwError(new Error("ActionHandler::execute($_pair) - could not proceed: 
								it seems we have already executed this action before. 
								Are we in an infinite loop?","ActionHandler",true));
			return false;
		}
	
	
		$_includeFile = $this->_modulesPath;
		$_includeFile .= DIRECTORY_SEPARATOR . $module;
		if ($this->_modulesType == MODULES_CLASSES) $_includeFile .= $this->_modulesFileExtension;
		else $_includeFile .= DIRECTORY_SEPARATOR . $action . $this->_actionsFileExtension;
				
		// if we are using flatfiles for actions, we have to set some global variables for it to use
		if ($this->_actionsType == ACTIONS_FLATFILES) {
			$httpVars =& $this->_httpVars;
			$context =& $this->_context;
			$loginState =& $this->_loginState;
		}
		
		// include the file
        $incResult =& @include($_includeFile) or throwError(new Error("ActionHandler::execute($_pair) - could not proceed:
							The file '$_includeFile' produced the following error: ".$php_errormsg,"ActionHandler",true));

		$result = false; // default

		$class = $method = false;
		if ($this->_actionsType == ACTIONS_FLATFILES) {
			$result =& $incResult;
		}
		
		// if actions are classes, execute the class.
		if ($this->_actionsType == ACTIONS_CLASSES) {
			$class = $action;
			$method = ACTIONS_CLASSES_METHOD;
		}
		
		// if actions are class-methods
		if ($this->_actionsType == ACTIONS_CLASS_METHODS) {
			$class = $module;
			$method = $action;
		}
		
		// create the class, execute the method.
		if ($class) {
			$object =& @new $class;
			if (!$object) throwError(new Error("ActionHandler::execute($_pair) - 
							could not proceed: The class '$class' could not be created:
							$php_errormsg","ActionHandler",true));
			
			// execute the $method and get the result.
			$result =& $object->$method(&$this->_httpVars, &$this->_context,
									&$this->_loginState);
		}
		
		// we've now executed this action -- add it to the array
		$this->_actionsExecuted[] = $_pair;
		
		// now that we have our $result, let's check if we should do anything
		// else or just return back to our caller.
		if ($this->_threads[$_pair]) {
			// we have a subsequent action defined...
			// if we failed and there's a fail defined
			if (!$result && ($failAction = $this->_threads[$_pair][0])) {
				return $this->_executePair($failAction);
			}
			
			// if we succeeded and there's a success action defined
			if ($result && ($successAction = $this->_threads[$_pair][1])) {
				return $this->_executePair($successAction);
			}
		}
		
		// otherwise, just return the darned result
		return $result;
		// phew!
	}
	
	/**
	 * Executes a module.action pair.
	 * @param string $pair
	 * @access private
	 * @return mixed
	 **/
	function _executePair($pair) {
		list($module, $action) = explode(".",$pair);
		return $this->_execute($module, $action);
	}
	
	
	/**
	 * Sets the location of the modules to use.
	 * @param string $location The path to the modules.
	 * @param integer $type Should be either MODULES_FOLDERS or MODULES_CLASSES
	 * @param optional string $fileExtension If $type=MODULES_CLASSES, the string to append
	 * onto the module name to find the class file (ie, ".class.php").
	 * @use MODULES_FOLDERS
	 * @use MODULES_CLASSES
	 * @access public
	 * @return void
	 **/
	function setModulesLocation($location, $type, $fileExtension=null) {
		// if $type=MODULES_CLASSES and $fileExtension is not set, throw an error
		if ($type==MODULES_CLASSES && !$fileExtensions) {
			throwError(new Error("ActionHandler::setModulesLocation($location) - could not proceed: with \$type = MODULES_CLASSES you must specify the 3rd argument 'fileExtension'!","ActionHandler",true));
			return false;
		}
		
		$this->_modulesPath = $location;
		$this->_modulesType = $type;
		$this->_modulesFileExtension = $fileExtension;
		// done.
	}
	
	/**
	 * Sets how we locate actions.
	 * @param integer $type Should be any of ACTIONS_FLATFILES, ACTIONS_CLASSES, ACTIONS_CLASS_METHODS.
	 * @param optional string $fileExtension If $type=ACTIONS_FLATFILES or ACTIONS_CLASSES, the extension to apply to
	 * the action name to find the file (ie, ".inc.php" would give "action1name.inc.php").
	 * @use ACTIONS_FLATFILES
	 * @use ACTIONS_CLASSES
	 * @use ACTIONS_CLASS_METHODS
	 * @access public
	 * @return void
	 **/
	function setActionsType($type, $fileExtension=null) {
		// we need a fileExtension for FLATFILES and CLASSES
		if (($type == ACTIONS_FLATFILES || $type == ACTIONS_CLASSES) && !$fileExtension) {
			throwError(new Error("ActionHandler::setActionsType - since \$type = ACTIONS_FLATFILE or ACTIONS_CLASSES, you must pass 2nd argument 'fileExtension'!","ActionHandler",true));
			return false;
		}
		
		$this->_actionsType = $type;
		$this->_actionsFileExtension = $fileExtension;
		// done.
	}
	
	/**
	 * Adds to the action-processing thread. If $action is executed and it returns a failure
	 * or success code, $actionOnFail will be executed afterwards if $action fails, otherwise,
	 * $actionOnSuccess will be executed (or nothing will be if this option isn't included).
	 * @param string $action A "module.action" string specifying which action to set the thread for.
	 * @param string $actionOnFail A "module.action" string specifying what should be executed if
	 * $action fails.
	 * @param optional string $actionOnSuccess A "module.action" string specifying what should be executed
	 * if $action succeeds.
	 * @access public
	 * @return void
	 **/
	function setActionThread($action, $actionOnFail, $actionOnSuccess=null) {
		// first, make sure that each thing we're passed is indeed a dotted pair
		$dp =& new DottedPairValidatorRule;
		ArgumentValidator::validate($action,$dp);
		ArgumentValidator::validate($actionOnFail,$dp);
		if ($actionOnSuccess)
			AgumentValidator::validate($actionOnSuccess,$dp);
			
		// ok, now check if we've already defined a thread for $action.
		// if so, throw a WARNING
		if (isset($this->_threads[$action]))
			throwError(new Error("WARNING: An action thread for '$action' has already been defined! New thread will override the old one!","ActionHandler",false));
		
		// ok, let's do the dirty
		$this->_threads[$action] = array($actionOnFail,$actionOnSuccess);
		// done.
	}
	
	/**
	 * Tells the ActionHandler to use the specified {@link LoginState} object.
	 * @param object $loginState the {@link LoginState} object.
	 * @access public
	 * @return void
	 **/
	function useLoginState($loginState) {
		$this->_loginState =& $loginState;
	}
	
	/**
	 * Tells the ActionHandler to use the specified {@link Context} object.
	 * @param object $context The {@link Context} object.
	 * @access public
	 * @return void
	 **/
	function useContext($context) {
		$this->_context =& $context;
	}
}

?>