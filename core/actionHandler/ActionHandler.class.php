<?php
/**
 * @package harmoni.actions
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ActionHandler.class.php,v 1.24 2007/11/01 17:36:51 adamfranco Exp $
 */

//require_once(HARMONI."actionHandler/ActionHandler.interface.php");
require_once(HARMONI."actionHandler/DottedPairValidatorRule.class.php");

require_once(HARMONI."actionHandler/actionSources/ClassesActionSource.class.php");
require_once(HARMONI."actionHandler/actionSources/FlatFileActionSource.class.php");
require_once(HARMONI."actionHandler/actionSources/ClassMethodsActionSource.class.php");

require_once(HARMONI."architecture/events/EventTrigger.abstract.php");

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
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ActionHandler.class.php,v 1.24 2007/11/01 17:36:51 adamfranco Exp $
 */
class ActionHandler extends EventTrigger {
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
	 * @var array $_modulesSettings A variable for backward compatibility. Don't worry about it.
	 **/
	var $_modulesSettings;
	
	/**
	 * @access private
	 * @var array $_actionSources An array of {@link ActionSource} objects.
	 */
	var $_actionSources;
	
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
	 * @var array $_tokenRequiredActions;  
	 * @access private
	 * @since 8/14/08
	 */
	private $_tokenRequiredActions;
	
	/**
	 * The constructor.
	 * @param object $httpVars A {@link FieldSet} object of HTTP variables.
	 * @param optional object $context A {@link Context} object.
	 * @param optional object $loginState A {@link LoginState} object.
	 * @access public
	 * @return void
	 **/
	function ActionHandler() {
		$this->_actionsExecuted = array();
		$this->_threads = array();
		$this->_actionSources = array();
		
		$this->_modulesSettings["callCount"] = 0;
		
		
		// Set our request token to use for CSFR checking
		$this->_tokenRequiredActions = array();
	}
	
	/**
	 * Initialize any session variables.
	 * 
	 * @return void
	 * @access public
	 * @since 8/14/08
	 */
	public function postSessionStart () {
		if (!isset($_SESSION['__Harmoni_Request_Token']) || !strlen($_SESSION['__Harmoni_Request_Token']))
			$_SESSION['__Harmoni_Request_Token'] = md5(uniqid(rand(), TRUE));
	}
	
	/**
	 * If called within an executing action, will execute $module.$action
	 * after calling action has stopped.
	 * @param string $module The module, or a "module.action" pair, in which case the second parameter can be omitted.
	 * @param optional string $action The action to execute.
	 * @access public
	 * @return void
	 */
	function forward( $module, $action=null ) {
		debug::output("attempting to forward to action: $module.$action",DEBUG_SYS5,"ActionHandler");
		$test = DottedPairValidatorRule::getRule();
		if ($this->_executing) {
			if ($test->check($module) && !$action) {
				$this->_forwardToAction = $module;
			}
			if ($module && $action) {
				$this->_forwardToAction = $module . "." . $action;
			}
			$this->triggerEvent("edu.middlebury.harmoni.actionhandler.action_forwarded", $this, array("from"=>$this->_executing, "to"=>$this->_forwardToAction));
			return;
			throw new UnknownActionException("ActionHandler::forward($module, $action) - could not proceed. The action does not seem to be valid.");
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
	function execute($module, $action) {
		
		$this->_executing = $module.".".$action;
		$result =$this->_execute($module, $action);
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
	function _execute($module, $action) {
		debug::output("executing action '$module.$action'...",DEBUG_SYS5,"ActionHandler");
		$_pair = "$module.$action";
		// if we've already executed this action, we're probably stuck
		// in an infinite loop. no good!
		if (in_array($_pair, $this->_actionsExecuted)) {
			throw new HarmoniException("ActionHandler::execute($_pair) - could not proceed: 
								it seems we have already executed this action before. 
								Are we in an infinite loop?");
			return false;
		}
		
		if ($this->requiresRequestToken($module, $action)
				&& !$this->isRequestTokenValid())
			throw new PermissionDeniedException("Required request token does not match. Cannot Execute this action.");
	
		// go through each of the ActionSources and see if they have an action to execute. if so, execute it and stop
		// cycling through them (only the first action will be executed).
		$executedAction = false;
		$result = null;

		foreach (array_keys($this->_actionSources) as $sourceID) {
			$source =$this->_actionSources[$sourceID];
			if ($source->actionExists($module, $action)) {
				$result =$source->executeAction($module, $action);
				$executedAction = true;
				break;
			}
		}
		
		if (!$executedAction) {
			throw new UnknownActionException("ActionHandler::execute($module, $action) - could not proceed: no action source could find an
				action to associate with this module/action pair.");
		}
		
		// we've now executed this action -- add it to the array
		$this->_actionsExecuted[] = $_pair;
		
		$this->triggerEvent("edu.middlebury.harmoni.actionhandler.action_executed", $this, array("action"=>$_pair));
		
		// now that we have our $result, let's check if we should do anything
		// else or just return back to our caller.
		// if the action that was executing called forward(), execute that action.
		// otherwise, check if we have a thread to follow.
		if ($this->_forwardToAction) {
			$forward = $this->_forwardToAction;
			$this->_forwardToAction = false;
			
			return $this->_executePair($forward);
		}
		if (isset($this->_threads[$_pair])) {
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
		$res =$this->_execute($module, $action);
		return $res;
	}
	
	/**
	 * Executes a module.action pair.
	 * @param string $pair
	 * @access public
	 * @return mixed
	 **/
	function executePair($pair) {
		ArgumentValidator::validate($pair, DottedPairValidatorRule::getRule());
		$res =$this->_executePair($pair);
		return $res;
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
	 * @deprecated 5/28/2004 see {@link ActionHandler::addActionSource()}
	 * @return void
	 **/
	function setModulesLocation($location, $type, $fileExtension=null) {
		// if $type=MODULES_CLASSES and $fileExtension is not set, throw an error
		if ($type==MODULES_CLASSES && !$fileExtension) {
			throwError(new Error("ActionHandler::setModulesLocation($location) - could not proceed: with \$type = MODULES_CLASSES you must specify the 3rd argument 'fileExtension'!","ActionHandler",true));
			return false;
		}
		
		$this->_modulesSettings["location"] = $location;
		$this->_modulesSettings["type"] = $type;
		$this->_modulesSettings["ext"] = $ext;
		
		$this->_modulesSettings["callCount"]++;
		
		if ($this->_modulesSettings["callCount"] == 2) $this->_compatActionSource();
		
	}
	
	/**
	 * Sets the default way for how we locate actions. Action Types for
	 * particular modules can be set with setActionsTypeForModulesLocation() method.
	 * @param integer $type Should be any of ACTIONS_FLATFILES, ACTIONS_CLASSES, ACTIONS_CLASS_METHODS.
	 * @param optional string $fileExtension If $type=ACTIONS_FLATFILES or ACTIONS_CLASSES, the extension to apply to
	 * the action name to find the file (ie, ".inc.php" would give "action1name.inc.php").
	 * @use ACTIONS_FLATFILES
	 * @use ACTIONS_CLASSES
	 * @use ACTIONS_CLASS_METHODS
	 * @access public
	 * @deprecated 5/28/2004 see {@link ActionHandler::addActionSource()}
	 * @return void
	 **/
	function setActionsType($type, $fileExtension=null) {
		// we need a fileExtension for FLATFILES and CLASSES
		if (($type == ACTIONS_FLATFILES || $type == ACTIONS_CLASSES) && !$fileExtension) {
			throwError(new Error("ActionHandler::setActionsType - since \$type = ACTIONS_FLATFILE or ACTIONS_CLASSES, you must pass 2nd argument 'fileExtension'!","ActionHandler",true));
			return false;
		}
		
		$this->_modulesSettings["actionType"] = $type;
		$this->_modulesSettings["actionExt"] = $fileExtension;
		
		$this->_modulesSettings["callCount"]++;
		
		if ($this->_modulesSettings["callCount"] == 2) $this->_compatActionSource();
		
	}
	
	/**
	 * For backward compatibility with deprecated functions -- will add an action source based on settings given with old functions.
	 * @access private
	 * @return void
	 */
	function _compatActionSource()
	{

		// we have three options here.
		// 1) modules = folders, actions = flat files
		// 2) modules = folders, actions = classes
		// 3) modules = classes, actions = methods
		if ($this->_modulesSettings["type"] == MODULES_FOLDERS && $this->_modulesSettings["actionType"] == ACTIONS_FLATFILES) {
			$this->addActionSource( new FlatFileActionSource($this->_modulesSettings["location"], $this->_modulesSettings["actionExt"]));
		}
		if ($this->_modulesSettings["type"] == MODULES_FOLDERS && $this->_modulesSettings["actionType"] == ACTIONS_CLASSSES) {
			$this->addActionSource( new ClassesActionSource($this->_modulesSettings["location"], $this->_modulesSettings["actionExt"]));
		}
		if ($this->_modulesSettings["type"] == MODULES_CLASSES && $this->_modulesSettings["actionType"] == ACTIONS_CLASS_METHODS) {
			$this->addActionSource( new ClassMethodsActionSource($this->_modulesSettings["location"], $this->_modulesSettings["ext"]));
		}
		// done.
	}
	
	/**
	 * Adds a location for actions to the list of locations.
	 * @param ref object $actionsTypeObject An {@link ActionSource} object, specifying how to handle the given directory.
	 * @access public
	 * @return void
	 */
	function addActionSource( $actionSourceObject )
	{
		$this->_actionSources[] =$actionSourceObject;
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
		$dp = DottedPairValidatorRule::getRule();
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
	function getExecutedActions() {
		return $this->_actionsExecuted;
	}
	
	/**
	 * Set a list of actions that require request tokens to prevent Cross-Site Request Forgery
	 * attacks. All actions that could potentially change data should require this.
	 *
	 * Actions in this list will not be able to be loaded directly.
	 * 
	 * @param array $actions An array of module.action strings. '*' wildcards are allowed.
	 * @return void
	 * @access public
	 * @since 8/14/08
	 */
	public function addRequestTokenRequiredActions ($actions) {
		ArgumentValidator::validate($actions, ArrayValidatorRuleWithRule::getRule(
			DottedPairValidatorRule::getRule()));
		$this->_tokenRequiredActions = array_merge($this->_tokenRequiredActions, $actions);
	}
	
	/**
	 * Answer an array of actions that require request tokens. Needed for javascript url writing.
	 * 
	 * @return array
	 * @access public
	 * @since 8/14/08
	 */
	public function getRequestTokenRequired () {
		return $this->_tokenRequiredActions;
	}
	
	/**
	 * Check to see if the selected module and action require Cross-Site Request Forgery
	 * checking. All actions that could potentially change data should require this.
	 * This list of actions can be configured using $harmoni->ActionHandler->addRequestTokenRequiredActions();
	 * 
	 * @param string $module
	 * @param string $action
	 * @return boolean
	 * @access public
	 * @since 8/14/08
	 */
	public function requiresRequestToken ($module, $action) {
		$harmoni = Harmoni::instance();
		return $harmoni->_isActionInArray($module.'.'.$action, $this->_tokenRequiredActions);
	}
	
	/**
	 * Validate the request token against the one in the current Session to prevent
	 * Cross-Site Request Forgery (giving the user a url to an action that will have
	 * a bad effect). If the token is not set in the session, then we have a new session
	 * and an invalid request.
	 * 
	 * @return boolean
	 * @access protected
	 * @since 8/14/08
	 */
	protected function isRequestTokenValid () {
		if (!isset($_SESSION['__Harmoni_Request_Token']))
			return false;
		$harmoni = Harmoni::instance();
		$harmoni->request->startNamespace('request');
		$token = RequestContext::value('token');
		$harmoni->request->endNamespace();
		if ($_SESSION['__Harmoni_Request_Token'] == $token)
			return true;
		else
			return false;
	}
	
	/**
	 * Answer the request token for the current user
	 * 
	 * @return string
	 * @access public
	 * @since 8/14/08
	 */
	public function getRequestToken () {
		if (!isset($_SESSION['__Harmoni_Request_Token']) || !strlen($_SESSION['__Harmoni_Request_Token']))
			throw new ConfigurationErrorException("The Request Token should have been set in the session already.");
		return $_SESSION['__Harmoni_Request_Token'];
	}
}

require_once(HARMONI."/errorHandler/HarmoniException.class.php");

/**
 * This class defines Exceptions to be thrown when a valid Action cannot be loaded.
 * 
 * @since 11/1/07
 * @package harmoni.actions
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ActionHandler.class.php,v 1.24 2007/11/01 17:36:51 adamfranco Exp $
 */
class UnknownActionException
	extends HarmoniException
{
	
}
?>