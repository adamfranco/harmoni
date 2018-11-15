<?php
/**
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Cache.class.php,v 1.3 2007/09/04 20:25:54 adamfranco Exp $
 */

define("CACHE_VARIABLE","__cache");

$_temp = CACHE_VARIABLE;
$$_temp = array();
unset($_temp);

/**
 * This class acts as a basic cache. It stores data in a multi-dimensional
 * associative array that is built at execution time to store any arbitrary data
 * by "filing". 
 * @package harmoni.utilities
 * @copyright 2004
 * @version $Id: Cache.class.php,v 1.3 2007/09/04 20:25:54 adamfranco Exp $
 */
class Cache {

	function Cache() {
		die("<b>Cache is a static class - it should not be instantiated!</b>");
	}
	
	/**
	 * Stores an object. 
	 * @param ref mixed $object Any variable that should be stored.
	 * @param string $ident1 The first identifier for the object.
	 * @param optional string $ident2,... Any number of additional identifiers.
	 * @return void
	 * @access public
	 */
	function store($object, $ident1) {
		$string = '';
		$displayParts = array();
		for ($i=1; $i<func_num_args(); $i++) {
			$part = func_get_arg($i);
			$string .= "['$part']";
			$displayParts[] = $part;
		}
		
		$cache =$GLOBALS[CACHE_VARIABLE];
		
		$eval = '$bool = isset($cache'.$string.');';
		eval($eval);
		if ($bool) {
			throwError( new HarmoniError(
				"Cache - an item with identifyer <b>".implode(":",$displayParts)."</b> is already stored!","Cache",true));
		}
		
		$eval = '$cache'.$string.' =$object;';
		eval($eval);
	}

	/**
	 * Checks to see if we have any data stored under the given identifiers. 
	 * @param string $ident1 The first identifier for the object.
	 * @param optional string $ident2,... Any number of additional identifiers.
	 * @return boolean
	 * @access public
	 */
	function contains($ident1) {
		$string = '';
		for ($i=0; $i<func_num_args(); $i++) {
			$part = func_get_arg($i);
			$string .= "['$part']";
			$displayParts[] = $part;
		}
		
		$cache =$GLOBALS[CACHE_VARIABLE];
		
		$eval = '$bool = isset($cache'.$string.');';
		eval($eval);
		return $bool;
	}
	
	/**
	 * Retrieves stored data specified by the given identifiers.
	 * @param string $ident1 The first identifier for the object.
	 * @param optional string $ident2,... Any number of additional identifiers.
	 * @return ref mixed
	 * @access public
	 */
	function get($ident1) {
		$string = '';
		for ($i=0; $i<func_num_args(); $i++) {
			$part = func_get_arg($i);
			$string .= "['$part']";
			$displayParts[] = $part;
		}
		
		$cache =$GLOBALS[CACHE_VARIABLE];
		
		$eval = '$bool = isset($cache'.$string.');';
		eval($eval);
		
		if (!$bool) {
			throwError( new HarmoniError(
				"Cache - no item with identifyer <b>".implode(":",$displayParts)."</b> is stored!","Cache",true));
		}
		
		$eval = '$object =$cache'.$string.';';
		eval($eval);
		return $object;
	}
	
}