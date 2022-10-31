<?php
/**
 * @since 12/8/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TagFilterIterator.class.php,v 1.2 2007/09/04 20:25:29 adamfranco Exp $
 */ 

/**
 * <##>
 * 
 * @since 12/8/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TagFilterIterator.class.php,v 1.2 2007/09/04 20:25:29 adamfranco Exp $
 */
class TagFilterIterator
	extends HarmoniIterator
{

	/**
	 * Constructor
	 * 
	 * @param object TagIterator $sourceIterator
	 * @param array $filterValues Values to filter out of the resulting tags.
	 * @return object
	 * @access public
	 * @since 12/8/06
	 */
	function __construct ( $sourceIterator, $filterValues = array() ) {
		parent::__construct($null = null);
		$this->_sourceIterator =$sourceIterator;
		$this->_toFilter = array();
		
		foreach ($filterValues as $string) {
			$tag = new Tag($string);
			if ($tag->getValue())
				$this->_toFilter[] = $tag->getValue();
		}
		
		$this->_nextElement = null;
		$this->_numSoFar = 0;
		
		// Load our first element
		$this->advance();
	}
		
	/**
	 * Answer true if there are more elements
	 * 
	 * @return boolean
	 * @access public
	 * @since 12/8/06
	 */
	function hasNext () {
		return !is_null($this->_nextElement);
	}
	
	/**
	 * Answer the next Tag
	 * 
	 * @return object
	 * @access public
	 * @since 12/8/06
	 */
	function next () {
		$next =$this->_nextElement;
		
		$this->advance();
		$this->_numSoFar++;
		
		return $next;
	}
	
	/**
	 * Gives the number of items in the iterator
	 *
	 * @return int
	 * @public
	 */
	 function count () {
	 	if (!isset($this->_count)) {
	 		$remainingElements = array();
	 		while ($this->hasNext()) {
	 			$remainingElements[] =$this->_nextElement;
	 			$this->advance();
	 		}
	 		// Store the count
	 		$this->_count = $this->_numSoFar + count($remainingElements);
	 		
	 		// Reload the remaining elements into a new source iterator.
	 		$this->_sourceIterator = new HarmoniIterator($remainingElements);
	 		$this->advance();
	 	}
	 	return $this->_count;
	 }
	
	/**
	 * Skips the next item in the iterator
	 *
	 * @return void
	 * @public
	 */
	 function skipNext() {
	 	$this->advance();
	 	$this->_numSoFar++;
	 }
	
	/**
	 * Advance to the next valid element
	 * 
	 * @return void
	 * @access public
	 * @since 12/8/06
	 */
	function advance () {
		unset($this->_nextElement);
		$this->_nextElement = null;
		
		while (is_null($this->_nextElement) && $this->_sourceIterator->hasNext()) {
			$nextTag =$this->_sourceIterator->next();
			if (!in_array($nextTag->getValue(), $this->_toFilter)) {
				$this->_nextElement =$nextTag;
			}
		}
	}
	
}

?>