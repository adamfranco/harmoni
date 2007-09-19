<?php
/**
 * @since 9/5/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniException.class.php,v 1.4 2007/09/19 14:04:09 adamfranco Exp $
 */ 

/**
 * The HarmoniException adds pretty HTML formatting to the built-in exception class.
 * 
 * @since 9/5/07
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniException.class.php,v 1.4 2007/09/19 14:04:09 adamfranco Exp $
 */
class HarmoniException
	extends Exception
{
	/**
	 * @var string $type;  
	 * @access private
	 * @since 9/5/07
	 */
	private $type = '';
	
	/**
	 * @var boolean $isFatal;  
	 * @access private
	 * @since 9/5/07
	 */
	private $isFatal = true;
	
	/**
	 * Constructor
	 * 
	 * @param string $message
	 * @param optional integer $code
	 * @param optional string $type
	 * @return void
	 * @access public
	 * @since 9/5/07
	 */
	public function __construct ($message, $code = 0, $type = '', $isFatal = true) {
		parent::__construct($message, $code);
		$this->type = $type;
		$this->isFatal = $isFatal;
	}
	
	/**
	 * Answer the type of error (generally the package it occurred in).
	 * 
	 * @return string
	 * @access public
	 * @since 9/5/07
	 */
	public function getType () {
		return $this->type;
	}
	
	/**
	 * Answer true if this exception causes a fatal error if not caught.
	 * 
	 * @return boolean
	 * @access public
	 * @since 9/5/07
	 */
	public function isFatal () {
		return $this->isFatal;
	}
}

/**
 * Print an exception with HTML formatting.
 * 
 * @param object Exception $exception
 * @return void
 * @access public
 * @since 9/5/07
 */
function printExceptionInHtml ( Exception $exception ) {
	print "\n<div style='background-color: #FAA; border: 2px dotted #F00; padding: 10px;'><strong>Fatal error</strong>: Uncaught exception of type";
	print "\n\t<div style='padding-left: 20px; font-style: italic;'>".get_class($exception)."</div>";
	print "with message ";
	print "\n\t<div style='padding-left: 20px; font-style: italic;'>".$exception->getMessage()."</div>";
	print "\n\tin";
	print "\n\t<div style='padding-left: 20px;'>";
	printDebugBacktrace($exception->getTrace());
	print "\n\t</div>";
	print "\n</div>";
	
	logException($exception);
}

/**
 * Log an exception to the logging system if possible.
 * 
 * @param object Exception $exception
 * @return void
 * @access public
 * @since 9/5/07
 */
function logException ( Exception $exception ) {
	// If we have an error in the error handler or the logging system, 
	// don't infinitely loop trying to log the error of the error....
	$errorLoggingRecursion = FALSE;
	$backtrace = debug_backtrace();
	for ($i = 1; $i < count($backtrace); $i++) {
		if (isset($backtrace[$i]['function']) 
			&& strtolower($backtrace[$i]['function']) == 'logException') 
		{
			$errorLoggingRecursion = true;
			break;
		}
	}
	if (class_exists('Services') && Services::serviceRunning("Logging") && !$errorLoggingRecursion) {
		$loggingManager = Services::getService("Logging");
		$log =$loggingManager->getLogForWriting("Harmoni");
		$formatType = new Type("logging", "edu.middlebury", "AgentsAndNodes",
						"A format in which the acting Agent[s] and the target nodes affected are specified.");
		$priorityType = new Type("logging", "edu.middlebury",
							((method_exists($exception, "isFatal") && !$exception->isFatal())?"Error":"Fatal_Error"),
							"Events involving critical system errors.");
		
		$item = new AgentNodeEntryItem(((method_exists($exception, "getType"))?$exception->getType():get_class($exception)), $exception->getMessage());
		$item->setBacktrace($exception->getTrace());
		$item->addTextToBactrace("\n<div><strong>REQUEST_URI: </strong>".$_SERVER['REQUEST_URI']."</div>");
		if (isset($_SERVER['HTTP_REFERER']))
				$item->addTextToBactrace("\n<div><strong>HTTP_REFERER: </strong>".$_SERVER['HTTP_REFERER']."</div>");
		$item->addTextToBactrace("\n<div><strong>GET: </strong><pre>".print_r($_GET, true)."</pre></div>");
		$item->addTextToBactrace("\n<div><strong>POST: </strong><pre>".print_r($_POST, true)."</pre></div>");
		$item->addTextToBactrace("\n<div><strong>HTTP_USER_AGENT: </strong><pre>".print_r($_SERVER['HTTP_USER_AGENT'], true)."</pre></div>");
		$log->appendLogWithTypes($item,	$formatType, $priorityType);
		
	}
}

set_exception_handler("printExceptionInHtml");

?>