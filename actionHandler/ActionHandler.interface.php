<?php

/**
 * @const integer MODULES_FOLDERS Specifies that modules are stored in folders. 
 * @package harmoni.actions
 **/
define("MODULES_FOLDERS",1);

/**
 * @const integer MODULES_CLASSES Specifies that modules are stored in classes. 
 * @package harmoni.actions
 **/
define("MODULES_CLASSES",2);

/**
 * @const integer ACTIONS_CLASSES Specifies that actions are stored as classes.
 * @package harmoni.actions
 **/
define("ACTIONS_CLASSES",1);

/**
 * @const integer ACTIONS_CLASS_METHODS Specifies that actions are stored as class-methods.
 * @package harmoni.actions
 **/
define("ACTIONS_CLASS_METHODS",2);

/**
 * @const integer ACTIONS_FLATFILES Specifies that actions are stored as flat files to be included.
 * @package harmoni.actions
 **/
define("ACTIONS_FLATFILES",3);

/**
 * @const string ACTIONS_CLASSES_METHOD The method name to call when executing actions
 * that are classes. (value = 'execute')
 * @package harmoni.actions
 **/
define("ACTIONS_CLASSES_METHOD","execute");

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
 * <li>The {@link Harmoni} object.
 *
 * @package harmoni.interfaces.actions
 * @version $Id: ActionHandler.interface.php,v 1.5 2003/08/06 22:32:40 gabeschine Exp $
 * @copyright 2003 
 **/
class ActionHandlerInterface {
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Tells the ActionHandler to use the specified {@link LoginState} object.
	 * @param ref object $loginState the {@link LoginState} object.
	 * @access public
	 * @return void
	 **/
	function useLoginState(&$loginState) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Tells the ActionHandler to use the specified {@link Context} object.
	 * @param ref object $context The {@link Context} object.
	 * @access public
	 * @return void
	 **/
	function useContext(&$context) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns an array of actions that have been executed this session.
	 * @access public
	 * @return array
	 **/
	function getExecutedActions() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>