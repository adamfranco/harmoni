<?php
/**
 * @since 11/8/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TaggedItemIterator.class.php,v 1.1.2.1 2006/11/08 20:43:16 adamfranco Exp $
 */ 

/**
 * <##>
 * 
 * @since 11/8/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TaggedItemIterator.class.php,v 1.1.2.1 2006/11/08 20:43:16 adamfranco Exp $
 */
class TaggedItemIterator 
	extends HarmoniIterator
{
		
	/**
	 * Constructor
	 * 
	 * @param object SelectQueryResult $result
	 * @return object
	 * @access public
	 * @since 11/8/06
	 */
	function TaggedItemIterator ( &$result ) {
		$this->_result =& $result;
	}
	
	/**
	 * Answer true if there are more items in the iterator
	 * 
	 * @return boolean
	 * @access public
	 * @since 11/8/06
	 */
	function hasNext () {
		return $this->_result->hasNext();
	}
	
	/**
	 * Answer the next Item
	 * 
	 * @return mixed object or false
	 * @access public
	 * @since 11/8/06
	 */
	function &next () {
		if (!$this->hasNext()) {
			$false = false;
			return $false;
		} else {
			$item =& TaggedItem::forDatabaseRow($this->_result->next());
			return $item;
		}
	}
	
	/**
	 * Skip the next Item
	 * 
	 * @return boolean
	 * @access public
	 * @since 11/8/06
	 */
	function skipNext () {
		if (!$this->hasNext()) {
			return false;
		} else {
			$this->_result->next();
			return true;
		}
	}
	
	/**
	 * Gives the number of items in the iterator
	 *
	 * @return int
	 * @public
	 */
	 function count () {
	 	return $this->_result->getNumberOfRows();
	 }
}

?>