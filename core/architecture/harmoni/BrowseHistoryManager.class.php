<?php

/**
 * Keeps track of the last important page the user visited, and returns them there
 * when called upon to do so. 
 *
 * @package harmoni.architecture
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BrowseHistoryManager.class.php,v 1.6 2006/11/30 22:00:31 adamfranco Exp $
 **/

class BrowseHistoryManager {

	/**
	 * Marks the current return-point after an operation has completed. The 
	 * function can take three forms:
	 * 
	 * void markReturnURL(string $op)					- takes the current URL from Harmoni::request
	 * void markReturnURL(string $op, string $url)		- take a URL as a string
	 * void markReturnURL(string $op, URLWriter $obj)	- takes a {@link URLWriter} object and creates
	 *										  			  the URL from that
	 *
	 * @return void
	 * @param string $operation The label (or operation) under which to store the URL.
	 * 							Later, a script may call goBack($operation) to return
	 * 							the browser to this URL.
	 * @param optional mixed $arg Either a string, an object ({@link URLWriter}), or nothing. 
	 * @access public
	 */
	function markReturnURL($operation, $arg = null) {
		$url = '';
		if ($arg == null) {
			$harmoni =& Harmoni::instance();
			$urlObj =& $harmoni->request->mkURLWithPassthrough();
			$url = $urlObj->write();
		} else if (is_string($arg))
			$url = $arg;
		else if (is_object($arg)) 
			$url = $arg->write(); // a URLWriter object
		
		
		$_SESSION['__returnURL'][$operation] = $url;
//		print "for operation: $operation -- $url <br>";
	}
	
	/**
	 * Sends the browser to the last URL marked with {@link BrowseHistoryManager::markReturnURL markReturnURL()}.
	 * @param string $operation The name of the operation under which the URL
	 * is stored. 
	 * @return void
	 * @access public
	 */
	function goBack($operation) {
		RequestContext::sendTo($this->getReturnURL($operation));
		exit();
	}
	
	/**
	 * Answer a marked url
	 * 
	 * @param string $operation The name of the operation under which the URL
	 * is stored. 
	 * @return object URLWriter
	 * @access public
	 * @since 6/7/05
	 */
	function getReturnURL($operation) {
		if (isset($_SESSION['__returnURL'][$operation])) {
			$url = $_SESSION['__returnURL'][$operation];
		} else {
			$harmoni =& Harmoni::instance();
			$url = $harmoni->request->quickURL(
				$harmoni->config->get("defaultModule"),
				$harmoni->config->get("defaultAction")
			);
		}
		return $url;
	}
}

?>