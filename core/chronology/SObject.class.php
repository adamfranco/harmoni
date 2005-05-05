<?php
/**
 * @since 5/5/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SObject.class.php,v 1.1 2005/05/05 23:11:22 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 

/**
 * SObject (Squeak/Smalltalk-like object).
 *
 * In Smalltalk, all object share a common class, "Object", which defines common
 * methods for all objects. This class holds a subset of those methods in Object
 * that are needed in this package.
 * 
 * @since 5/5/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SObject.class.php,v 1.1 2005/05/05 23:11:22 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class SObject {

/*********************************************************
 * Class Methods
 *********************************************************/
		
	/**
	 * Create an object that has similar contents to aSimilarObject.
	 * If the classes have any instance varaibles with the same names, copy them across.
	 * If this is bad for a class, override this method.
	 * 
	 * @param string $targetClass As mentiond here, 
	 *	{@link http://www.php.net/manual/en/ref.classobj.php} there is no good way
	 *		to inherit class methods such that they can know the class of 
	 *		the reciever (child class) instead of the class name of the implementer
	 *		(parent class). As such, we need to pass our target classname.
	 * @param object $aSimilarObject
	 * @return object
	 * @access public
	 * @since 5/5/05
	 */
	function &newFrom ( $targetClass, &$aSimilarObject ) {
		$newObject =& new $targetClass();
		$newObject->copySameFrom($aSimilarObject);
		return $newObject;
	}
	
/*********************************************************
 * Instance Methods
 *********************************************************/
 	
 	/**
 	 * Create an object of class aSimilarClass that has similar contents to the 
 	 * receiver.
 	 *
 	 * 'as' seems to be a reserved word, so 'asA' is used instead.
 	 * 
 	 * @param string $aSimilarClass
 	 * @return object
 	 * @access public
 	 * @since 5/5/05
 	 */
 	function &asA ( $aSimilarClass ) {
 		return SObject::newFrom($aSimilarClass, $this);
 	}
 
 	/**
 	 * Copy to myself all instance variables named the same in otherObject.
	 * This ignores otherObject's control over its own inst vars.
 	 * 
 	 * @param object $otherObject
 	 * @return void
 	 * @access public
 	 * @since 5/5/05
 	 */
 	function copySameFrom ( &$otherObject ) {
 		$myVars = get_object_vars($this);
 		$otherVars = get_object_vars($otherObject);
 		
 		foreach (array_keys($myVars) as $varName) {
 			if (key_exists($varName, $otherVars))
	 			$this->$varName = $otherVars[$varName];
 		}
 	}
}

?>