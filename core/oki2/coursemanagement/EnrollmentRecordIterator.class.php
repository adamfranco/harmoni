<?php 

require_once(OKI2."/osid/coursemanagement/EnrollmentRecordIterator.php");
require_once(HARMONI."oki2/shared/HarmoniIterator.class.php");

/**
 * EnrollmentRecordIterator provides access to EnrollmentRecords.
 * EnrollmentRecord provides access to these objects sequentially, one at a
 * time.  The purpose of all Iterators is to to offer a way for OSID methods
 * to return multiple values of a common type and not use an array.	 Returning
 * an array may not be appropriate if the number of values returned is large
 * or is fetched remotely.	Iterators do not allow access to values by index,
 * rather you must access values in sequence. Similarly, there is no way to go
 * backwards through the sequence unless you place the values in a data
 * structure, such as an array, that allows for access by index.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid_v2.coursemanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: EnrollmentRecordIterator.class.php,v 1.4 2005/01/19 22:28:21 adamfranco Exp $
 */
class HarmoniEnrollmentRecordIterator
	extends HarmoniIterator
//	implements EnrollmentRecordIterator
{
	/**
	 * Return true if there is an additional  EnrollmentRecord ; false
	 * otherwise.
	 *	
	 * @return boolean
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function hasNextEnrollmentRecord () { 
		 return $this->hasNext();
	} 

	/**
	 * Return the next EnrollmentRecord.
	 *	
	 * @return object EnrollmentRecord
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NO_MORE_ITERATOR_ELEMENTS
	 *		   NO_MORE_ITERATOR_ELEMENTS}
	 * 
	 * @access public
	 */
	function &nextEnrollmentRecord () { 
		return $this->next();
	} 
}

?>