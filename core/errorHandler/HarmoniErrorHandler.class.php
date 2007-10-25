<?php
/**
 * @since 10/10/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniErrorHandler.class.php,v 1.11 2007/10/25 16:14:14 adamfranco Exp $
 */ 

/**
 * This is an error handler class that can display and log errors and exceptions.
 *
 * The HarmoniErrorHandler's execution is primarily controlled by the state of the
 * 'error_reporting' and 'display_errors' directives. Any errors that match the current
 * error_reporting level and all uncaught Exceptions will be processed by the
 * error handler and logged. If the display_errors directive is set to 'On', then
 * these errors and exceptions will also be printed to the screen, otherwise they 
 * will be only logged.
 * 
 * In addition to the behavior devined by the 'error_reporting' and 'display_errors' directives,
 * the HarmoniErrorHandler also allows setting of which error_levels are fatal, causing
 * the execution to halt. This is set with the $errorHandler->fatalErrors() method
 * which has the same parameter syntax as the error_reporting() function.
 * 
 * @since 10/10/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniErrorHandler.class.php,v 1.11 2007/10/25 16:14:14 adamfranco Exp $
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
	 * @var integer $fatalErrors; The bitwise integer that determines whether or not
	 * to halt execution when an error occurs.
	 * @access private
	 * @since 10/17/07
	 */
	private $fatalErrors;
	
	/**
	 * @var integer $defaultFatalErrors; The bitwise integer that determines whether or not
	 * to halt execution when an error occurs.
	 * @access private
	 * @since 10/17/07
	 */
	private $defaultFatalErrors;
	
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
		
		$this->defaultFatalErrors = (E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR);
		$this->fatalErrors = $this->defaultFatalErrors;
		
	}
	
	/**
	 * Make particular error types fatal. Syntax is the same as error_reporting().
	 * 
	 * @param optional int $type A integer bitmap like the error_reporting levels.
	 * @return int If no argument is passed the current fatal errors will be returned.
	 * @access public
	 * @since 10/10/07
	 */
	public function fatalErrors () {
		if (!func_num_args())
			return $this->fatalErrors;
		
		$args = func_get_args();
		$level = $args[0];
		if (!is_int($level) || func_num_args() > 1)
			throw new NullArgumentException("You must specify an integer error level. Should be one or a bitwise combination of E_ERROR, E_WARNING, E_PARSE, E_NOTICE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE, E_RECOVERABLE_ERROR, E_STRICT.");
		
		$this->fatalErrors = $level;
	}
	
	/**
	 * Answer the default fatal error level
	 * 
	 * @return int
	 * @access public
	 * @since 10/17/07
	 */
	public function getDefaultFatalErrorLevel () {
		return $this->defaultFatalErrors;
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
		// do a bitwise comparison of the error level to the current error_reporting level
		// and do not print or log if it doesn't match.
		if (!($errorType & error_reporting())) {
			// Check if the error level is fatal continue and if not.
			$handler = HarmoniErrorHandler::instance();
			if (!($errorType & $handler->fatalErrors))
				return;
			// Die if the error is fatal.
			else
				die();
		}
		
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
		// Only print Errors to the screen if the display_errors directive instructs
		// us to do so.
		if (ini_get('display_errors') === true || ini_get('display_errors') === 'On' 
			|| ini_get('display_errors') === 'stdout' || ini_get('display_errors') === '1')
		{
			$this->printError($errorType, $errorMessage, $backtrace);
		}
		
		// Log the error.
		$this->logError($errorType, $errorMessage, $backtrace);
		
		// Exit if the error is fatal
		// do a bitwise comparison of the error level to the current fatalErrors level
		if (!($errorType & $this->fatalErrors))
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
		if (method_exists($exception, "getType") && $exception->getType())
			$type = $exception->getType();
		else
			$type = get_class($exception);
		
		// Only print Exceptions to the screen if the display_errors directive instructs
		// us to do so.
		if (ini_get('display_errors') === true || ini_get('display_errors') === 'On' 
			|| ini_get('display_errors') === 'stdout' || ini_get('display_errors') === '1')
		{
			if (ini_get('html_errors'))
				self::printMessage('Uncaught Exception of type', $type, $exception->getMessage(), $exception->getTrace());
			else
				self::printPlainTextMessage('Uncaught Exception of type', $type, $exception->getMessage(), $exception->getTrace());
		}
		
		// Log the Exception
		self::logMessage($type, $exception->getMessage(), $exception->getTrace());
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
		if (ini_get('html_errors'))
			self::printMessage('Error', $this->errorTypes[$errorType], $errorMessage, $backtrace);
		else
			self::printPlainTextMessage('Error', $this->errorTypes[$errorType], $errorMessage, $backtrace);
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
	public static function printPlainTextMessage ( $errorOrException, $type, $message, array $backtrace ) {
		print "\n*****************************************************************************";
		print "\n* ".$errorOrException.": ";
		print "\n*\t".$type;
		print "\n* with message ";
		print "\n*\t".$message;
		print "\n* in";
		print "\n*";
		self::printPlainTextDebugBacktrace($backtrace);
		print "\n*****************************************************************************";
	}
	
	/**
	 * Log an error with the Logging OSID implementation.
	 * 
	 * @param string $errorType
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
	 * Log an Exception.
	 * 
	 * @param object Exception $exception
	 * @param optional string $logName Defaults to the Harmoni log
	 * @return void
	 * @access public
	 * @since 10/24/07
	 */
	public static function logException (Exception $exception, $logName = 'Harmoni') {
		if (method_exists($exception, "getType") && $exception->getType())
			$type = $exception->getType();
		else
			$type = get_class($exception);
		
		self::logMessage($type, $exception->getMessage(), $exception->getTrace(), $logName);
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
	public static function logMessage ($type, $message, array $backtrace, $logName = 'Harmoni') {
		/*********************************************************
		 * Log the error in the default system log if the log_errors
		 * directive is on.
		 *********************************************************/
		if (ini_get('log_errors') === true || ini_get('log_errors') === 'On' 
			|| ini_get('log_errors') === '1')
		{
			error_log("PHP ".$type.":  ".$message);
		}
		
		/*********************************************************
		 * Log the error using the Logging OSID if available.
		 *********************************************************/
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
			$logName = preg_replace('/[^a-z0-9_\s-.]/i', '', $logName);
			try {
				$loggingManager = Services::getService("Logging");
				$log =$loggingManager->getLogForWriting($logName);
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
			} catch (Exception $e) {
				// Just continue if we can't log the exception.
			}
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
				if (isset($trace['args']))
					$args = ArgumentRenderer::renderManyArguments($trace['args'], false, false);
				else
					$args = '';
				
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
	
	/**
	 * Prints a debug_backtrace() array in a pretty plain text way...
	 * @param optional array $trace The array. If null, a current backtrace is used.
	 * @param optional boolean $return If true will return the HTML instead of printing it.
	 * @access public
	 * @return void
	 */
	 public static function printPlainTextDebugBacktrace($trace = null, $return=false) {
	 	if (is_array($trace))
	 		$traceArray = $trace;
	 	else 
			$traceArray = debug_backtrace();
		
	
		if ($return) ob_start();
		
		$filenameSize = 5;
		if (is_array($traceArray)) {
			foreach($traceArray as $trace) {
				$filenameSize = max($filenameSize, strlen(basename($trace['file'])));
			}
		}
		$filenameSize = $filenameSize + 2;
			
		print "\n* # ";
		print "\tFile";
		for ($j = 4; $j < $filenameSize; $j++)
			print " ";
		print "Line";
		print "\tCall ";
		print "\n*-----------------------------------------------------------------------------";		
		if (is_array($traceArray)) {			
			foreach($traceArray as $i => $trace) {
				/* each $traceArray element represents a step in the call hiearchy. Print them from bottom up. */
				$file = basename($trace['file']);
				$line = $trace['line'];
				$function = $trace['function'];
				$class = isset($trace['class'])?$trace['class']:'';
				$type = isset($trace['type'])?$trace['type']:'';
				$args = ArgumentRenderer::renderManyArguments($trace['args'], false, false);
				
				print "\n* $i";
				print "\t".$file;
				for ($j = strlen($file); $j < $filenameSize; $j++)
					print " ";
				print "".$line;
				print "\t";
				if ($class || $type || $function || $args) {
					print $class.$type.$function."(".$args.");";
				}
			}
		}
		
		if ($return) return ob_get_clean();
	}
}


?>