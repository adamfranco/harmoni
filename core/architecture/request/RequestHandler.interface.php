<?php

/**
 * @package harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RequestHandler.interface.php,v 1.5 2008/01/25 17:06:22 adamfranco Exp $
 */ 

/**
 * The job of a RequestHandler is twofold:
 * 
 * 1) handle incoming request data -- could be from $_REQUEST-type arrays, 
 * could be from session variables, etc.
 * 2) handle the production of URLs with given contextual data/query using an 
 * associated URLWriter class.
 *
 * @package harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RequestHandler.interface.php,v 1.5 2008/01/25 17:06:22 adamfranco Exp $
 */

interface RequestHandler {
	
	/**
	 * Returns an associative array of key=value pairs corresponding to the request
	 * data from the browser. This could just be the data from $_REQUEST, in the
	 * simplest case.
	 *
	 * @return array
	 * @access public
	 */
	public function getRequestVariables();
	
	/**
	 * Returns an associative array of file upload data. This will usually come from
	 * the $_FILES superglobal.
	 * 
	 * @return array
	 * @access public
	 */
	public function getFileVariables();
	
	/**
	 * Returns a new {@link URLWriter} object corresponding to this RequestHandler.
	 *
	 * @param optional string $base
	 * @return ref object URLWriter
	 * @access public
	 */
	public function createURLWriter($base = null);
	
	/**
	 * Returns a dotted-pair string representing the module and action requested
	 * by the end user ("module.action" format).
	 * 
	 * @return string
	 * @access public
	 */
	public function getRequestedModuleAction();
	
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
	public static function getParameterListFromUrl ($inputUrl, $base = null);
	
}

?>