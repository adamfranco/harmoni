<?

	/**
	 * Term includes an Unique Id set by the implementation, a TermType, and an osid.sched.Schedule. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 *
	 * @package harmoni.osid.coursemanagement
	 * 
	 * @copyright Copyright &copy; 2005, Middlebury College
	 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
	 *
	 * @version $Id: Term.class.php,v 1.3 2005/01/19 21:10:04 adamfranco Exp $
	 */
class HarmoniTerm // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this Term.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Type for this Term.  This Type is meaningful to the implementation and applications and is not specified by the SID.
	 * @return object osid.shared.Type Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getType() { /* :: interface :: */ }

	/**
	 * Get the Schedule for this Term.  Schedules are defined in osid.sched.  ScheduleItems are returned in chronological order by increasing start date.
	 * @return object osid.scheduling.ScheduleItemIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getSchedule() { /* :: interface :: */ }
}