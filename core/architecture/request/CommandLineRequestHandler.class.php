<?php
/**
 * @since 11/1/07
 * @package  harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CommandLineRequestHandler.class.php,v 1.2 2008/01/25 17:06:22 adamfranco Exp $
 */ 

require_once(HARMONI."architecture/request/RequestHandler.interface.php");
require_once(dirname(__FILE__)."/ArgumentParser.inc.php");

/**
 * The CommandLineRequestHandler converts command line options of the form --name=value
 * into RequestContext parameters.
 * 
 * @since 11/1/07
 * @package  harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CommandLineRequestHandler.class.php,v 1.2 2008/01/25 17:06:22 adamfranco Exp $
 */
class CommandLineRequestHandler
	implements RequestHandler
{
	
	/**
	 * @var array $options;  
	 * @access private
	 * @since 11/1/07
	 */
	private $options = array();
	
	/**
	 * @var array $input;  
	 * @access private
	 * @since 11/1/07
	 */
	private $input = array();
	
	/**
	 * Constructor
	 * 
	 * @param array $argumentValues
	 * @return void
	 * @access public
	 * @since 11/1/07
	 */
	public function __construct (array $argumentValues ) {
		$this->options = getOptionArray($argumentValues);
		$this->input = getParameterArray($argumentValues);
	}
	
	/**
	 * Returns an associative array of key=value pairs corresponding to the request
	 * data from the browser. This could just be the data from $_REQUEST, in the
	 * simplest case.
	 *
	 * @return array
	 * @access public
	 */
	public function getRequestVariables() {
		return $this->options;
	}
	
	/**
	 * Returns an associative array of file upload data. This will usually come from
	 * the $_FILES superglobal.
	 * 
	 * @return array
	 * @access public
	 */
	public function getFileVariables() {
		return $this->input;
	}
	
	/**
	 * Returns a new {@link URLWriter} object corresponding to this RequestHandler.
	 *
	 * @param optional string $base
	 * @return ref object URLWriter
	 * @access public
	 */
	public function createURLWriter($base = null) {
		return new CommandLineUrlWriter($base);
	}
	
	/**
	 * Returns a dotted-pair string representing the module and action requested
	 * by the end user ("module.action" format).
	 * 
	 * @return string
	 * @access public
	 */
	public function getRequestedModuleAction() {
		if (isset($this->options["module"]))
			$mod = preg_replace('/[^a-zA-Z0-9_\-]/i', '', $this->options["module"]);
		else
			$mod = NULL;
		
		if (isset($this->options["action"]))
			$act = preg_replace('/[^a-zA-Z0-9_\-]/i', '', $this->options["action"]);
		else
			$act = NULL;
		
		return $mod .".". $act;
	}
	
	/**
	 * Given an input url written by the current handler, return a url-encoded
	 * string of parameters and values. Ampersands separating parameters should
	 * use the XML entity representation, '&amp;'.
	 * 
	 * For instance, the PathInfo handler would for the following input
	 *		http://www.example.edu/basedir/moduleName/actionName/parm1/value1/param2/value2
	 * would return
	 *		module=moduleName&amp;action=actionName&amp;param1=value1&amp;param2=value2
	 * 
	 * @param string $inputUrl
	 * @param optional string $base Defaults to MYURL
	 * @return mixed string URL-encoded parameter list or FALSE if unmatched
	 * @access public
	 * @since 1/25/08
	 * @static
	 */
	public static function getParameterListFromUrl ($inputUrl, $base = null) {
		if (is_null($base))
			$base = MYURL;
		
		$pattern = "/^".str_replace('/', '\/', $base).' (--([^\\s=]+)=(.+))*$/i';
		if (!preg_match($pattern, $inputUrl, $matches))
			return FALSE;
		else {
			$params = array();
			for ($i = 0; $i < count($matches[2]); $i++) 
				$params[] = $matches[2]."=".$matches[3];
			
			return implode("&amp;", $params);
		}
	}
	
}


require_once(HARMONI."architecture/request/URLWriter.abstract.php");

/**
 * The purpose of a URLWriter is to generate URLs from contextual data. This
 * data would be the current/target module and action, any contextual name=value
 * pairs specified by the code, and any additional query data.
 * 
 * @since 11/1/07
 * @package harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CommandLineRequestHandler.class.php,v 1.2 2008/01/25 17:06:22 adamfranco Exp $
 */
class CommandLineUrlWriter
	extends URLWriter
{
		
	/** 
	 * The following function has many forms, and due to PHP's lack of
	 * method overloading they are all contained within the same class
	 * method. 
	 * 
	 * write()
	 * write(array $vars)
	 * write(string $key1, string $value1, [string $key2, string $value2, [...]])
	 * 
	 * @access public
	 * @return string The URL. 
	 */
	public function write(/* variable-length argument list*/) {
		if (!defined("MYURL")) {
			throwError( new HarmoniError("GETMethodURLWriter requires that 'MYURL' is defined and set to the full URL of the main index PHP script of this Harmoni program!", "GETMethodRequestHandler", true));
		}
		
		$num = func_num_args();
		$args = func_get_args();
		
		if ($num > 1 && $num % 2 == 0) {
			for($i = 0; $i < $num; $i+=2) {
				$this->_vars[RequestContext::name($args[$i])] = $args[$i+1];
			}
		} else if ($num == 1 && is_array($args[0])) {
			$this->setValues($args[0]);
		}
		
		$url = $this->_base;
		$pairs = array();
		$harmoni = Harmoni::instance();
		if (!$harmoni->config->get("sessionUseOnlyCookies") && defined("SID") && SID) 
			$pairs[] = strip_tags(SID);
		$pairs[] = "--module=".$this->_module;
		$pairs[] = "--action=".$this->_action;
		foreach ($this->_vars as $key=>$val) {
			if (is_object($val)) {
				throwError( new HarmoniError("Expecting string for key '$key', got '$val'.", "GETMethodRequestHandler", true));
			}
			$pairs[] = "--" . $key . "=" . escapeshellarg($val);
		}
		
		$url .= " " . implode(" ", $pairs);
		
		return $url;
	}
	
}

/**
 * An exception to be thrown when help is requested.
 * 
 * @since 11/1/07
 * @package harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CommandLineRequestHandler.class.php,v 1.2 2008/01/25 17:06:22 adamfranco Exp $
 */
class HelpRequestedException
	extends HarmoniException
{
	
}

?>