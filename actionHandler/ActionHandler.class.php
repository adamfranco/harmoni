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
 * <li>An array of post/get variables from the web browser.
 * <li>An array of session variables.
 * <li>An array of cookie items from the browser.
 * <li>A {@link Context} object.
 * <li>A {@link LoginState} object.
 *
 * @package harmoni.actions
 * @version $Id: ActionHandler.class.php,v 1.1 2003/07/22 14:41:40 gabeschine Exp $
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
	 * The execute function takes a module and action (if none is specified,
	 * it executes the "default" action within the module). The method executes
	 * the given action, taking the result and either executing another action
	 * (based on the user specified options) or returning the result from the action.
	 * @param string $module The module name.
	 * @param optional string $action The action name.
	 * @access public
	 * @return ref mixed Returns whatever is recieved from the last action
	 * to execute. Can be: a {@link Layout} object, TRUE/FALSE, etc.
	 **/
	function & execute($module, $action=null) {
		// first make sure that the pair of actionType/moduleType we have is valid
		// eg, if modules are folder, actions cannot be class-methods.
		// if modules are classes, actions cannot be flatfiles.
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
}

?>