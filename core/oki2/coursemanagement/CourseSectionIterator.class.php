<?php 

require_once(OKI2."/osid/coursemanagement/CourseSectionIterator.php");
require_once(HARMONI."oki2/shared/HarmoniIterator.class.php");
 
/**
 * CourseSectionIterator provides access to CourseSections.	 CourseSection
 * provides access to these objects sequentially, one at a time.  The purpose
 * of all Iterators is to to offer a way for OSID methods to return multiple
 * values of a common type and not use an array.  Returning an array may not
 * be appropriate if the number of values returned is large or is fetched
 * remotely.  Iterators do not allow access to values by index, rather you
 * must access values in sequence. Similarly, there is no way to go backwards
 * through the sequence unless you place the values in a data structure, such
 * as an array, that allows for access by index.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * <p>
 * Licensed under the {@link org.osid.SidImplementationLicenseMIT MIT
 * O.K.I&#46; OSID Definition License}.
 * </p>
 * 
 * @package org.osid.coursemanagement
 */
class HarmoniCourseSectionIterator
	extends HarmoniIterator
//	implements CourseSectionIterator
{
	/**
	 * Return true if there is an additional  CourseSection ; false otherwise.
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
	 * @public
	 */
	function hasNextCourseSection () { 
		return $this->hasNext();
	} 

	/**
	 * Return the next CourseSection.
	 *	
	 * @return object CourseSection
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
	 * @public
	 */
	function &nextCourseSection () { 
		return $this->next();
	} 
}

?>