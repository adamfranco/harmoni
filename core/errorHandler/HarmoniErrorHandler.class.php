<?php
/**
 * @since 10/10/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniErrorHandler.class.php,v 1.3 2007/10/11 00:32:30 adamfranco Exp $
 */ 

/**
 * This is an error handler class that can display and log errors
 * 
 * @since 10/10/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniErrorHandler.class.php,v 1.3 2007/10/11 00:32:30 adamfranco Exp $
 */
class HarmoniErrorHandler {
		
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
			self::$instance = new HarmoniErrorHandler;
		
		return self::$instance;
	}
	
	/**
	 * @var array $errorTypes;  
	 * @access private
	 * @since 10/10/07
	 */
	private $errorTypes;
	
	/**
	 * @var array $typeFatality;  
	 * @access private
	 * @since 10/10/07
	 */
	private $typeFatality;
	
	/**
	 * @var array $typeLogging;  
	 * @access private
	 * @since 10/10/07
	 */
	private $typeLogging;
	
	/**
	 * Constructor
	 * 
	 * @return void
	 * @access private
	 * @since 10/10/07
	 */
	private function __construct () {
		$this->errorTypes = array(
			E_ERROR         	=> 'Error',
			E_WARNING       	=> 'Warning',
			E_PARSE         	=> 'Parsing Error',
			E_NOTICE        	=> 'Notice',
			E_CORE_ERROR    	=> 'Core Error',
			E_CORE_WARNING  	=> 'Core Warning',
			E_COMPILE_ERROR 	=> 'Compile Error',
			E_COMPILE_WARNING	=> 'Compile Warning',
			E_USER_ERROR    	=> 'User Error',
			E_USER_WARNING  	=> 'User Warning',
			E_USER_NOTICE   	=> 'User Notice',
			E_RECOVERABLE_ERROR	=> 'Catchable Fatal Error',
			E_STRICT			=> 'Runtime Notice'
		);
		
		$this->typeFatality = array(
			E_ERROR         	=> true,
			E_WARNING       	=> false,
			E_PARSE         	=> true,
			E_NOTICE        	=> false,
			E_CORE_ERROR    	=> true,
			E_CORE_WARNING  	=> true,
			E_COMPILE_ERROR 	=> true,
			E_COMPILE_WARNING	=> true,
			E_USER_ERROR    	=> true,
			E_USER_WARNING  	=> false,
			E_USER_NOTICE   	=> false,
			E_RECOVERABLE_ERROR	=> true,
			E_STRICT			=> false
		);
		
		$this->typeLogging = array(
			E_ERROR         	=> true,
			E_WARNING       	=> true,
			E_PARSE         	=> true,
			E_NOTICE        	=> false,
			E_CORE_ERROR    	=> true,
			E_CORE_WARNING  	=> true,
			E_COMPILE_ERROR 	=> true,
			E_COMPILE_WARNING	=> true,
			E_USER_ERROR    	=> true,
			E_USER_WARNING  	=> true,
			E_USER_NOTICE   	=> false,
			E_RECOVERABLE_ERROR	=> true,
			E_STRICT			=> false
		);
	}
	
	/**
	 * Enable logging on particular types
	 * 
	 * @param int $type Can pass multiple types as multiple arguments.
	 * @return void
	 * @access public
	 * @since 10/10/07
	 */
	public function enableLoggingFor ($type) {
		if (!func_num_args())
			throw new NullArgumentException("You must specify one or more error types.");
			
		foreach (func_get_args() as $errorType) {
			if (!$this->validateType($errorType))
				throw new HarmoniException($type." is not a valid type. Should be one of E_ERROR, E_WARNING, E_PARSE, E_NOTICE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE, E_RECOVERABLE_ERROR, E_STRICT.");
			
			$this->typeLogging[$errorType] = true;
		}
	}
	
	/**
	 * Disable logging on particular types
	 * 
	 * @param int $type Can pass multiple types as multiple arguments.
	 * @return void
	 * @access public
	 * @since 10/10/07
	 */
	public function disableLoggingFor ($type) {
		if (!func_num_args())
			throw new NullArgumentException("You must specify one or more error types.");
			
		foreach (func_get_args() as $errorType) {
			if (!$this->validateType($errorType))
				throw new HarmoniException($type." is not a valid type. Should be one of E_ERROR, E_WARNING, E_PARSE, E_NOTICE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE, E_RECOVERABLE_ERROR, E_STRICT.");
			
			$this->typeLogging[$errorType] = false;
		}
	}
	
	/**
	 * Make particular error types fatal.
	 * 
	 * @param int $type Can pass multiple types as multiple arguments.
	 * @return void
	 * @access public
	 * @since 10/10/07
	 */
	public function makeFatal ($type) {
		if (!func_num_args())
			throw new NullArgumentException("You must specify one or more error types.");
			
		foreach (func_get_args() as $errorType) {
			if (!$this->validateType($errorType))
				throw new HarmoniException($type." is not a valid type. Should be one of E_ERROR, E_WARNING, E_PARSE, E_NOTICE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE, E_RECOVERABLE_ERROR, E_STRICT.");
			
			$this->typeFatality[$errorType] = true;
		}
	}
	
	/**
	 * Disable logging on particular types
	 * 
	 * @param int $type Can pass multiple types as multiple arguments.
	 * @return void
	 * @access public
	 * @since 10/10/07
	 */
	public function makeUnfatal ($type) {
		if (!func_num_args())
			throw new NullArgumentException("You must specify one or more error types.");
			
		foreach (func_get_args() as $errorType) {
			if (!$this->validateType($errorType))
				throw new HarmoniException($type." is not a valid type. Should be one of E_ERROR, E_WARNING, E_PARSE, E_NOTICE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE, E_RECOVERABLE_ERROR, E_STRICT.");
			
			$this->typeFatality[$errorType] = false;
		}
	}
	
	/**
	 * Validate a type
	 * 
	 * @param int $type
	 * @return boolean
	 * @access private
	 * @since 10/10/07
	 */
	private function validateType ($type) {
		if (isset($this->errorTypes[$type]))
			return true;
		else
			return false;
	}
	
	/**
	 * Handle an error
	 * 
	 * @param int $errorType
	 * @param string $errorMessage
	 * @return void
	 * @access public
	 * @since 10/10/07
	 * @static
	 */
	public static function handleError ($errorType, $errorMessage) {
		// do a bitwise comparisson of the error level to the current error_reporting
		// level
		if (!($errorType & error_reporting()))
			return;
		
		$backtrace = debug_backtrace();
// 		$backtrace = array_shift(debug_backtrace());

		// Remove the message from the error-handler call from the backtrace
		$backtrace[0]['function'] = '';
		$backtrace[0]['class'] = '';
		$backtrace[0]['type'] = '';
		$backtrace[0]['args'] = array();

		$errorHandler = HarmoniErrorHandler::instance();
		$errorHandler->completeHandlingError($errorType, $errorMessage, $backtrace);
	}
	
	/**
	 * Handle an error
	 * 
	 * @param int $errorType
	 * @param string $errorMessage
	 * @param array $backtrace
	 * @return void
	 * @access private
	 * @since 10/10/07
	 */
	private function completeHandlingError ($errorType, $errorMessage, array $backtrace) {
		$this->printError($errorType, $errorMessage, $backtrace);
		
		// Log the error if needed.
		if (isset($this->typeLogging[$errorType]) && $this->typeLogging[$errorType])
			$this->logError($errorType, $errorMessage, $backtrace);
		
		// Exit if the error is fatal
		if (isset($this->typeFatality[$errorType]) && $this->typeFatality[$errorType] === false)
			return;
		else
			die();
	}
	
	/**
	 * Handle an Exception
	 * 
	 * @param object Exception $exception
	 * @return void
	 * @access public
	 * @since 10/10/07
	 * @static
	 */
	public static function handleException (Exception $exception) {
		if (method_exists($exception, "getType"))
			$type = $exception->getType();
		else
			$type = get_class($exception);
		
		self::printMessage('Uncaught Exception of type', $type, $exception->getMessage(), $exception->getTrace());
		
		self::logMessage($type, $exception->getMessage(), $exception->getTrace());
		
		die();
	}
	
	/**
	 * Print out an error message
	 * 
	 * @param int $errorType
	 * @param string $errorMessage
	 * @param array $backtrace
	 * @return void
	 * @access private
	 * @since 10/10/07
	 */
	private function printError ($errorType, $errorMessage, array $backtrace) {
		self::printMessage('Error', $this->errorTypes[$errorType], $errorMessage, $backtrace);
	}
	
	/**
	 * Print out an error or exception message 
	 * 
	 * @param string $errorOrException A string describing whether this was an error or an uncaught exception.
	 * @param string $type The type of error or exception that occurred
	 * @param string $message A message.
	 * @param array $backtrace
	 * @return void
	 * @access public
	 * @since 10/10/07
	 */
	public static function printMessage ( $errorOrException, $type, $message, array $backtrace ) {
		print "\n<div style='background-color: #FAA; border: 2px dotted #F00; padding: 10px;'><strong>".$errorOrException."</strong>: ";
		print "\n\t<div style='padding-left: 20px; font-style: italic;'>".$type."</div>";
		print "with message ";
		print "\n\t<div style='padding-left: 20px; font-style: italic;'>".$message."</div>";
		print "\n\tin";
		print "\n\t<div style='padding-left: 20px;'>";
		self::printDebugBacktrace($backtrace);
		print "\n\t</div>";
		print "\n</div>";
	}
	
	/**
	 * Log an error with the Logging OSID implementation.
	 * 
	 * @param int $errorType
	 * @param string $errorMessage
	 * @param array $backtrace
	 * @return void
	 * @access private
	 * @since 10/10/07
	 */
	private function logError ($errorType, $errorMessage, array $backtrace) {
		self::logMessage($this->errorTypes[$errorType], $errorMessage, $backtrace);
	}
	
	/**
	 * Log an error or exception with the Logging OSID implemenation
	 * 
	 * @param string $type The type of error or exception that occurred
	 * @param string $message A message.
	 * @param array $backtrace
	 * @return void
	 * @access public
	 * @since 10/10/07
	 * @static
	 */
	public static function logMessage ($type, $message, array $backtrace) {
		// If we have an error in the error handler or the logging system, 
		// don't infinitely loop trying to log the error of the error....
		$testBacktrace = debug_backtrace();
		for ($i = 1; $i < count($testBacktrace); $i++) {
			if (isset($testBacktrace[$i]['function']) 
				&& strtolower($testBacktrace[$i]['function']) == 'logMessage') 
			{
				return;
			}
		}
		
		if (class_exists('Services') && Services::serviceRunning("Logging")) {
			
			$loggingManager = Services::getService("Logging");
			$log =$loggingManager->getLogForWriting("Harmoni");
			$formatType = new Type("logging", "edu.middlebury", "AgentsAndNodes",
							"A format in which the acting Agent[s] and the target nodes affected are specified.");
			$priorityType = new Type("logging", "edu.middlebury", $type,
								"Events involving critical system errors.");
			
			$item = new AgentNodeEntryItem($type, $message);
			$item->setBacktrace($backtrace);
			$item->addTextToBactrace("\n<div><strong>REQUEST_URI: </strong>".$_SERVER['REQUEST_URI']."</div>");
			if (isset($_SERVER['HTTP_REFERER']))
					$item->addTextToBactrace("\n<div><strong>HTTP_REFERER: </strong>".$_SERVER['HTTP_REFERER']."</div>");
			$item->addTextToBactrace("\n<div><strong>GET: </strong><pre>".print_r($_GET, true)."</pre></div>");
			$item->addTextToBactrace("\n<div><strong>POST: </strong><pre>".print_r($_POST, true)."</pre></div>");
			$item->addTextToBactrace("\n<div><strong>HTTP_USER_AGENT: </strong><pre>".print_r($_SERVER['HTTP_USER_AGENT'], true)."</pre></div>");
			$log->appendLogWithTypes($item,	$formatType, $priorityType);
		}
	}
	
	/**
	 * Prints a debug_backtrace() array in a pretty HTML way...
	 * @param optional array $trace The array. If null, a current backtrace is used.
	 * @param optional boolean $return If true will return the HTML instead of printing it.
	 * @access public
	 * @return void
	 */
	 public static function printDebugBacktrace($trace = null, $return=false) {
	 	if (is_array($trace))
	 		$traceArray = $trace;
	 	else 
			$traceArray = debug_backtrace();
		
	
		if ($return) ob_start();
			
		print "\n\n<table border='1'>";
		print "\n\t<thead>";
		print "\n\t\t<tr>";
		print "\n\t\t\t<th>#</th>";
		print "\n\t\t\t<th>File</th>";
		print "\n\t\t\t<th>Line</th>";
		print "\n\t\t\t<th>Call</th>";
		print "\n\t\t</tr>";
		print "\n\t</thead>";
		print "\n\t<tbody>";
		if (is_array($traceArray)) {
			foreach($traceArray as $i => $trace) {
				/* each $traceArray element represents a step in the call hiearchy. Print them from bottom up. */
				$file = basename($trace['file']);
				$line = $trace['line'];
				$function = $trace['function'];
				$class = isset($trace['class'])?$trace['class']:'';
				$type = isset($trace['type'])?$trace['type']:'';
				$args = ArgumentRenderer::renderManyArguments($trace['args'], false, false);
				
				print "\n\t\t<tr>";
				print "\n\t\t\t<td>$i</td>";
				print "\n\t\t\t<td title=\"".$trace['file']."\">$file</td>";
				print "\n\t\t\t<td>$line</td>";
				print "\n\t\t\t<td style='font-family: monospace; white-space: nowrap'>";
				if ($class || $type || $function || $args) {
					print $class.$type.$function."(".$args.");";
				}
				print "</td>";
				print "\n\t\t</tr>";
			}
		}
		print "\n\t</tbody>";
		print "\n</table>";
		
		if ($return) return ob_get_clean();
	}
}

set_exception_handler(array('HarmoniErrorHandler', 'handleException'));


?>