<?php
//require_once(HARMONI."architecture/harmoni/Harmoni.interface.php");
require_once(HARMONI."actionHandler/ActionHandler.class.php");
require_once(HARMONI."utilities/FieldSetValidator/ReferencedFieldSet.class.php");
require_once(HARMONI."utilities/FieldSetValidator/FieldSet.class.php");
require_once(HARMONI."languageLocalizer/LanguageLocalizer.class.php");
require_once(HARMONI."architecture/harmoni/HarmoniConfig.class.php");
require_once(HARMONI."architecture/request/RequestContext.class.php");
require_once(HARMONI."architecture/harmoni/BrowseHistoryManager.class.php");
require_once(HARMONI."actionHandler/DottedPairValidatorRule.class.php");
require_once(HARMONI."/architecture/output/BasicOutputHandler.class.php");
require_once(HARMONI."/architecture/output/BasicOutputHandlerConfigProperties.class.php");
require_once(OKI2."/osid/OsidContext.php");

$__harmoni = null;

/**
 * The Harmoni class combines the functionality of login, authentication, 
 * action-handling and theme-output. It makes use of the the 
 * {@link ActionHandler} classes.
 *
 * The Harmoni class implements the Singleton pattern. There is only ever
 * on instance of the Harmoni object and it is accessed only via the 
 * {@link instance Harmoni::instance()} method.
 *
 * @package harmoni.architecture
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Harmoni.class.php,v 1.56 2008/03/20 19:12:36 adamfranco Exp $
 **/
class Harmoni {

/*********************************************************
 * Class Methods - Instance-Creation/Singlton
 *********************************************************/
 	/**
 	 * @var object  $instance;  
 	 * @access private
 	 * @since 10/10/07
 	 * @static
 	 */
 	private static $instance;

	/**
	 * This class implements the Singleton pattern. There is only ever
	 * one instance of the this class and it is accessed only via the 
	 * ClassName::instance() method.
	 * 
	 * @return object 
	 * @access public
	 * @since 5/26/05
	 * @static
	 */
	public static function instance () {
		if (!isset(self::$instance))
			self::$instance = new Harmoni;
		
		return self::$instance;
	}

/*********************************************************
 * Instance Variables
 *********************************************************/

	/**
	 * @access private
	 * @var string $_currentAction A dotted-pair module.action
	 **/
	var $_currentAction;
	
	/**
	 * @access private
	 * @var object OutputHandler $_outputHandler The handler we are using for output.
	 **/
	var $_outputHandler;
	
	/**
	 * @access public
	 * @var object $ActionHandler The {@link ActionHandler} object.
	 **/
	var $ActionHandler;
	
	/**
	 * @access public
	 * @var object RequestContext $request
	 */
	var $request;
	
	/**
	 * @access public
	 * @var object BrowseHistoryManager $history
	 */
	var $history;
	
	/**
	 * @access public
	 * @var object $config A {@link HarmoniConfig} {@link DataContainer} for Harmoni-specific options.
	 **/
	var $config;
	
	var $_attachedData;
	
	var $_preExecActions;
	var $_postExecActions;
	var $_postProcessAction;
	var $_postProcessIgnoreList;
	
	var $result;

/*********************************************************
 * Instance Methods
 *********************************************************/	

	/**
	 * The constructor.
	 * @access private
	 * @return void
	 **/
	private function __construct() {		
		$this->ActionHandler = new ActionHandler($this);
		
		// set up config options
		$this->config = new HarmoniConfig();
		
		// set up request context / handler
		$this->request = new RequestContext();
		
		// set up the history manager
		$this->history = new BrowseHistoryManager();
		
		$this->_attachedData = new ReferencedFieldSet();
		$this->_preExecActions = array();
		$this->_postExecActions = array();
		
		// Set up a default OutputHandler
		$osidContext = new OsidContext;
		$osidContext->assignContext('harmoni', $this);
		$configuration = new BasicOutputHandlerConfigProperties;
		$outputHandler = new BasicOutputHandler;
		$outputHandler->assignOsidContext($osidContext);
		$outputHandler->assignConfiguration($configuration);
		$this->attachOutputHandler($outputHandler);
	}
	
	/**
	 * Adds an action, or multiple, (see the {@link ActionHandler}) to execute before executing the action requested by the end user.
	 * @param string $action,... A number of actions (module.action) to execute.
	 * @access public
	 * @return void
	 */
	function addPreExecActions($actions)
	{
		$args = func_get_args();
		$rule = DottedPairValidatorRule::getRule();
		foreach ($args as $arg) {
			if ($rule->check($arg)) $this->_preExecActions[] = $arg;
		}
	}
	
	/**
	 * Adds an action, or multiple, (see the {@link ActionHandler}) to execute after executing the action requested by the end user.
	 * @param string $action,... A number of actions (module.action) to execute.
	 * @access public
	 * @return void
	 */
	function addPostExecActions($actions)
	{
		$args = func_get_args();
		$rule = DottedPairValidatorRule::getRule();
		foreach ($args as $arg) {
			if ($rule->check($arg)) $this->_postExecActions[] = $arg;
		}
	}
	
	/**
	 * Sets the action to call after the browser-requested action has executed but before the output from that action is processed. The result from the previous action can be accessed as Harmoni::result.
	 * @param string $action A dotted-pair action (module.action) to use for post processing.
	 * @param optional array $ignore An array of dotted-pair actions for which we will NOT execute the post-process action.
	 * @access public
	 * @return void
	 */
	function setPostProcessAction($action, $ignore=null)
	{
		$rule1 = DottedPairValidatorRule::getRule();
		$rule2 = ArrayValidatorRuleWithRule::getRule($rule1);
		ArgumentValidator::validate($action, $rule1);
		if ($ignore) ArgumentValidator::validate($ignore, $rule2);
		
		$this->_postProcessIgnoreList = $ignore?$ignore:array();
		$this->_postProcessAction = $action;
	}
	
	/**
	 * Returns TRUE if $action is contained somewhere within the array of actions: $array.
	 * @param string $action
	 * @param array $array
	 * @access private
	 * @return bool
	 */
	function _isActionInArray($action, $array)
	{
		if (in_array($action, $array)) return true;
		
		preg_match("/(.+)\.(.+)/",$action,$r);
		$reqMod = $r[1];
		$reqAct = $r[2];
		foreach ($array as $pair) {
			preg_match("/(.+)\.(.+)/",$pair,$r);
			$mod = $r[1];
			$act = $r[2];
			
			if ($mod == $reqMod && $act == "*") return true;
		}
		return false;
	}
	
	/**
	 * Returns a pretty version string of our running Harmoni framework version.
	 * @param optional string $versionStr An optional harmoni version string. If it is a partial string, we will return a full three-part version string.
	 * @access public
	 * @return string
	 */
	function getVersionStr($versionStr=null) {
		if ($versionStr) $harmoniVersion = $versionStr;
		else include HARMONI."version.inc.php";
		$ar = $this->_getVersionParts($harmoniVersion);
		
		return $ar[0] . "." . $ar[1] . "." . $ar[2];
	}
	
	/**
	 * Returns the numeric representation of our framework version. The format is XXMMRR, two digits for each of the major, minor and release numbers. NOTE: leading 0's are omitted.
	 * @param optional string $versionStr An optional harmoni version string "M[.m[.r]]" to turn into a number. Otherwise, the actual running Harmoni version number will be used.
	 * @access public
	 * @return integer
	 */
	function getVersionNumber($versionStr=null)
	{
		if ($versionStr) $harmoniVersion = $versionStr;
		else include HARMONI."version.inc.php";
		
		$ar = $this->_getVersionParts($harmoniVersion);
		
		$num = (integer) preg_replace("/^0+/","",sprintf("%02d%02d%02d",$ar[0],$ar[1], $ar[2]));
		return $num;
	}
	
	/**
	 * Returns an array of the Harmoni version string containing the major, minor and release numbers, in that order.
	 * @param string $string
	 * @access public
	 * @return array
	 */
	function _getVersionParts($string)
	{
		preg_match("/([0-9]+)(\.([0-9]+))?(\.([0-9]+))?/", $string, $matches);
		$major = (integer) $matches[1];
		$minor = (integer) $matches[3]?$matches[3]:0;
		$release = (integer) $matches[5]?$matches[5]:0;
		
		return array($major, $minor, $release);
	}
	
	/**
	* @return ref mixed
	* @param string $key
	* @param mixed $value
	* Attaches some arbitrary data to the Harmoni object so that actions or later
	* functions can make use of it.
	*/
	function attachData($key, $value) {
		$this->_attachedData->set($key,$value);
		return $value;
	}
	
	/**
	* Same as {@link Harmoni::getAttachedData getAttachedData()}.
	* @return ref mixed
	* @param string $key
	* Returns the data attached by {@link Harmoni::attachData} referenced by $key.
	* @deprecated 12/27/03 See getAttachedData()
	*/
	function getData($key) {
		return $this->_attachedData->get($key);
	}
	
	/**
	* @return ref mixed
	* @param string $key
	* Returns the data attached by {@link Harmoni::attachData} referenced by $key.
	*/
	function getAttachedData($key) {
		return $this->_attachedData->get($key);
	}	
	
	/**
	* @return void
	* @param string $module
	* @param string $action
	* An alias for {@link ActionHandler::forward()}. Purely for convenience.
	*/
	function forward($module, $action) {
		$this->ActionHandler->forward($module, $action);
	}
	
	function _detectCurrentAction() {
		
		// find what action we are trying to execute
		$pair = $this->request->getRequestedModuleAction();
		
		// now, let's find out what we got handed. could be any of:
		// 1) module.action <-- great
		// 2) module.	<-- ok, we'll use default action
		// 3) module	<-- same as above
		// 3) .action <-- no good!
		// 4) .		<-- ok, we'll use defaults
		if (preg_match("/^[[:alnum:]_-]+\.[[:alnum:]_-]+$/",$pair))
			list ($module, $action) = explode(".",$pair);
		else if (preg_match("/^[[:alnum:]_-]+\.?$/",$pair)) {
			$module = str_replace(".","",$pair);
			$action = $this->config->get("defaultAction");
		} else if (preg_match("/^\.[[:alnum:]_-]+$/",$pair)) {
			// no good! throw an error
			throw new UnknownActionException("Harmoni::execute() - Could not execute action '$pair' - a module needs to be specified!");
			return false;
		} else if (preg_match("/^\.?$/",$pair)) {
			$module = $this->config->get("defaultModule");
			$action = $this->config->get("defaultAction");
			
			// Set default params from the config
			if (!is_null($this->config->get('defaultParams'))) {
				foreach ($this->config->get('defaultParams') as $key => $val) {
					$this->request->setRequestParam($key, $val);
				}
			}
		}
		// that should cover it -- we now have a module and action to work with!
		$pair = "$module.$action";
		$this->setCurrentAction($pair);
	}
	
	/**
	 * Executes the Harmoni procedures: action
	 * processing and themed output to the browser. Certain options must be 
	 * set before execute() can be called.
	 * @access public
	 * @return void
	 **/
	function execute() {
		$this->config->checkAll();
		
		// update the request handler
		$this->request->update();
		
		// detect the current action
		$this->_detectCurrentAction();
		
		// check if we have any pre-exec actions. if so, execute them
		if (count($this->_preExecActions)) {
			foreach ($this->_preExecActions as $pair) {
				$this->ActionHandler->executePair($pair);
			}
		}
		
		// check if we've still got the same action
		$pair = $this->getCurrentAction();
		list($module,$action) = explode(".",$pair);
		
		// ok, now we execute the action
		// 1) call the action, get the return result
		// 2) Take whatever it returns (true, false, or Layout)
		// 3) Pass that on to the theme/OutputHandler
		// That's it! program finished!

		ob_start();
		$this->result =$this->ActionHandler->execute($module, $action);
		$this->printedResult = ob_get_contents();
		ob_end_clean();
		
		$lastExecutedAction = $this->ActionHandler->lastExecutedAction();

		// if we have a post-process action, let's try executing it.
		if (isset($this->_postProcessAction) && 
			!$this->_isActionInArray($lastExecutedAction, $this->_postProcessIgnoreList)) 
		{
			$this->result =$this->ActionHandler->executePair($this->_postProcessAction);
		}
		
		// check if we have any post-exec actions. if so, execute them
		if (count($this->_postExecActions)) {
			foreach ($this->_postExecActions as $pair) {
				$this->ActionHandler->executePair($pair);
			}
		}

		$this->_outputHandler->output($this->result, $this->printedResult);
	}
	
	/**
	 * Set the OutputHandler to use for theming the output.
	 * 
	 * @param object $outputHandler
	 * @return void
	 * @access public
	 * @since 4/5/05
	 */
	function attachOutputHandler ( $outputHandler ) {
		$this->_outputHandler =$outputHandler;
	}
	
	/**
	 * Get the OutputHandler used for theming the output.
	 * 
	 * @return object $outputHandler
	 * @access public
	 * @since 4/5/05
	 */
	function getOutputHandler () {
		return $this->_outputHandler;
	}
	
	/**
	 * Returns the current action.
	 * @access public
	 * @return string A dotted-pair action.
	 **/
	function getCurrentAction() {
		return $this->_currentAction;
	}
	
	/**
	 * Sets the current Harmoni action.
	 * @param string $action A dotted-pair action string.
	 * @access public
	 * @return void
	 **/
	function setCurrentAction($action) {
		ArgumentValidator::validate($action, DottedPairValidatorRule::getRule());
		$this->_currentAction = $action;
	}
	
	/**
	 * Starts the session.
	 * @access public
	 * @return void
	 **/
	function startSession() {
		// let's start the session
		if (session_id()) return;
		
		ini_set("session.use_cookies",
			($this->config->get("sessionUseCookies")?1:0));
		ini_set("session.use_only_cookies",
			($this->config->get("sessionUseOnlyCookies")?1:0));
		
		session_name($this->config->get("sessionName"));
		
		if (!isset($_COOKIE[$this->config->get("sessionName")]) 
			&& (!isset($_REQUEST[$this->config->get("sessionName")])
				&& !$this->config->get("sessionUseOnlyCookies")))
		{
			session_id(uniqid(str_replace(".","",$_SERVER['REMOTE_ADDR']))); // make new session id.
		}
		$path = $this->config->get("sessionCookiePath");
		if ($path[strlen($path) - 1] != '/') 
			$path .= '/';
		
		if (version_compare(phpversion(), '5.2.0', "<")) {
			if ($this->config->get("sessionCookiesHttpOnly"))
				throw new ConfigurationErrorException('"sessionCookiesHttpOnly" specified, but PHP versions less than 5.2.0 do not support it. Using PHP '.phpversion().'.');
			else	
				session_set_cookie_params(0, $path, $this->config->get("sessionCookieDomain"), $this->config->get("sessionCookiesSecure"));
		} else {
			session_set_cookie_params(0, $path, $this->config->get("sessionCookieDomain"), $this->config->get("sessionCookiesSecure"), $this->config->get("sessionCookiesHttpOnly"));
		}

		
		// If we have a configuration for Actions which allow the session id
		// to be passed in the URL, then check for those actions.
		// If we are at one of those actions we will take our session id from the
		// url and not set a session cookie to prevent fixation.
		if ($this->config->get("sessionInUrlActions") 
			&& is_array($this->config->get("sessionInUrlActions"))
			&& count ($this->config->get("sessionInUrlActions")))
		{
			$this->request->update();
			
			// If our current action is in the allowed list.
			if (in_array($this->request->getRequestedModuleAction(),
					$this->config->get("sessionInUrlActions"))) 
			{
				$usingUrlSid = true;
				if ($this->request->get(session_name()))
					session_id($this->request->get(session_name()));
			}
		}
		
		session_start(); // yay!
		
		// if we are using an SID for a custom action that allows it in the url,
		// overwrite the session cookie with a bogus one to prevent session
		// fixation.
		//
		// This header line will not affect any existing cookies in the browser, it
		// will simply prevent the Set-Cookie header from being sent with a valid
		// session id. In this way, if a person sends another to the a URL where
		// we are allowing the session id in the URL, that person's browser will
		// only use the session id in the URL for this one request, not all future
		// ones.
		if (isset($usingUrlSid)) {
			header('Set-Cookie: dummy=true;', true);
		}
		
		$this->ActionHandler->postSessionStart();
	}

}

?>