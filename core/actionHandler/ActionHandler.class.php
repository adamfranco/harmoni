<?php

//require_once(HARMONI."actionHandler/ActionHandler.interface.php");
require_once(HARMONI."actionHandler/DottedPairValidatorRule.class.php");

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
 * A specific action is referenced by "module.action" certain module/action options
 * are not compatible (such as modules=folders and actions=method-within-class).
 * 
 * An action is passed the following items:<br/>
 * <li>The {@link Harmoni} object.
 *
 * @package harmoni.actions
 * @version $Id: ActionHandler.class.php,v 1.7 2003/11/30 01:30:51 gabeschine Exp $
 * @copyright 2003 
 **/
class ActionHandler {
	/**
	 * @access private
	 * @var object $_harmoni A reference to the {@link Harmoni} object.
	 **/
	var $_harmoni;
	
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
	 * @var string $_forwardToAction
	 */
	var $_forwardToAction = false;
	
	/**
	 * @access private
	 * @var string $_executing
	 */
	var $_executing = false;
	
	/**
	 * The constructor.
	 * @param object $httpVars A {@link FieldSet} object of HTTP variables.
	 * @param optional object $context A {@link Context} object.
	 * @param optional object $loginState A {@link LoginState} object.
	 * @access public
	 * @return void
	 **/
	function ActionHandler(&$harmoni) {
		$this->_harmoni =& $harmoni;
		$this->_actionsExecuted = array();
		$this->_threads = array();
	}
	
	/**
	 * If called within an executing action, will execute $module.$action
	 * after calling action has stopped.
	 * @param string $module The module.
	 * @param string $action The action to execute.
	 * @access public
	 * @return void
	 */
	function forward( $module, $action=null ) {
		debug::output("attempting to forward to action: $module.$action",DEBUG_SYS5,"ActionHandler");
		$test =& new DottedPairValidatorRule;
		if ($this->_executing) {
			if ($test->check($module) && !$action) {
				$this->_forwardToAction = $module;
				return;
			}
			if ($module && $action) {
				$this->_forwardToAction = $module . "." . $action;
				return;
			}
			throwError( new Error("ActionHandler::forward($module, $action) - could not proceed. The action does not seem to be valid.","ActionHandler",true));
		}
		throwError( new Error("ActionHandler::forward($module, $action) - could not proceed. The ActionHandler is not currently executing any actions.","ActionHandler",true));
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
		
		// make sure we have a login state -- BAD! if people choose useAuthentication=false
		// in config, then this will always fail
//		if (!$this->_loginState)
//			throwError(new Error("ActionHandler::execute() - Could not proceed: it seems we do not yet have a LoginState object set.","ActionHandler",true));
		
		$this->_executing = true;
		$result =& $this->_execute($module, $action);
		$this->_executing = false;
		
		return $result;
	}
	
	/**
	 * Executes the given action
	 * @param string $module
	 * @param string $action
	 * @access private
	 * @return mixed
	 **/
	function &_execute($module, $action) {
		debug::output("executing action '$module.$action'...",DEBUG_SYS5,"ActionHandler");
		$_pair = "$module.$action";
		// if we've already executed this action, we're probably stuck
		// in an infinite loop. no good!
		if (in_array($_pair, $this->_actionsExecuted)) {
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
			$harmoni =& $this->_harmoni;
		}
		
		// include the file
		if (!file_exists($_includeFile)) throwError(new Error("ActionHandler::execute($_pair) - 
							could not proceed: The file '$_includeFile' does not exist!","ActionHandler",true));
        if ($this->_actionsType == ACTIONS_FLATFILES)
        	$incResult = include($_includeFile);
		
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
			if (!class_exists($class)) throwError( new Error(
			"ActionHandler::execute($module,$action) - could not proceed because the class '$class'
			does not exist. Make sure you've included the necessary files before execute() is called.",
			"ActionHandler",true));
			$object = @new $class;

			if (!method_exists($object,$method)) throwError ( new Error(
			"ActionHandler::execute($module,$action) - could not proceed because the method '$method'
			is not defined in the class '$class'.","ActionHandler",true));
			
			if (!is_object($object)) throwError(new Error("ActionHandler::execute($_pair) - 
							could not proceed: The class '$class' could not be created:
							$php_errormsg","ActionHandler",true));
			
			// execute the $method and get the result.
			$result =& $object->$method($this->_harmoni);
		}
		
		// we've now executed this action -- add it to the array
		$this->_actionsExecuted[] = $_pair;
		
		// now that we have our $result, let's check if we should do anything
		// else or just return back to our caller.
		// if the action that was executing called forward(), execute that action.
		// otherwise, check if we have a thread to follow.
		if ($this->_forwardToAction) {
			$forward = $this->_forwardToAction;
			$this->_forwardToAction = false;
			
			return $this->_executePair($forward);
		}
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
	function &_executePair($pair) {
		list($module, $action) = explode(".",$pair);
		return $this->_execute($module, $action);
	}
	
	/**
	 * Executes a module.action pair.
	 * @param string $pair
	 * @access public
	 * @return mixed
	 **/
	function &executePair($pair) {
		ArgumentValidator::validate($pair, new DottedPairValidatorRule());
		return $this->_executePair($pair);
	}
	
	/**
	* Returns the last executed action.
	* @return string
	*/
	function lastExecutedAction() {
		return $this->_actionsExecuted[count($this->_actionsExecuted)-1];
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
		if ($type==MODULES_CLASSES && !$fileExtension) {
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
			ArgumentValidator::validate($actionOnSuccess,$dp);
		
		// lets make sure they're not creating a circular loop
		if (($action == $actionOnFail) || ($action == $actionOnSuccess)) {
			throwError ( new Error("ActionHandler::setActionThread($action) - you may not
			specify an action on fail or succeed to forward to the same action.","ActionHandler",true));
		}
		
		// ok, now check if we've already defined a thread for $action.
		// if so, throw a WARNING
		if (isset($this->_threads[$action]))
			throwError(new Error("WARNING: An action thread for '$action' has already been defined! New thread will override the old one!","ActionHandler",false));
		
		// ok, let's do the dirty
		$this->_threads[$action] = array($actionOnFail,$actionOnSuccess);
		// done.
	}
	
	/**
	 * Returns an array of actions that have been executed this session.
	 * @access public
	 * @return array
	 **/
	function &getExecutedActions() {
		return $this->_actionsExecuted;
	}
}

?>