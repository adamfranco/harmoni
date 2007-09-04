<?php

require_once(OKI2."/osid/repository/RecordStructureIterator.php");
require_once(HARMONI."oki2/shared/HarmoniIterator.class.php");

/**
 * RecordStructureIterator provides access to these objects sequentially, one
 * at a time.  The purpose of all Iterators is to to offer a way for OSID
 * methods to return multiple values of a common type and not use an array.
 * Returning an array may not be appropriate if the number of values returned
 * is large or is fetched remotely.	 Iterators do not allow access to values
 * by index, rather you must access values in sequence. Similarly, there is no
 * way to go backwards through the sequence unless you place the values in a
 * data structure, such as an array, that allows for access by index.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: HarmoniRecordStructureIterator.class.php,v 1.10 2007/09/04 20:25:43 adamfranco Exp $ 
 */
class HarmoniRecordStructureIterator
	extends HarmoniIterator
	//implements RecordStructureIterator
{ // begin RecordStructureIterator

	/**
	 * Return true if there is an additional  RecordStructure ; false
	 * otherwise.
	 *	
	 * @return boolean
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function hasNextRecordStructure () { 
		return $this->hasNext();
	}

	 /**
	 * Return the next RecordStructure.
	 *	
	 * @return object RecordStructure
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NO_MORE_ITERATOR_ELEMENTS
	 *		   NO_MORE_ITERATOR_ELEMENTS}
	 * 
	 * @access public
	 */
	
	function nextRecordStructure () { 
		return $this->next();
	}

} // end RecordStructureIterator

?>
