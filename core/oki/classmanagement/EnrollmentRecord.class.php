<?

	/**
	 * EnrollmentRecord stores a student (Agent) and an Enrollment Status Type.  The EnrollmentRecord is the result of adding or changing a student in a CourseSection.  If the student is removed from the CourseSection, there will no longer be an EnrollmentRecord for the student.  The joining of a status type to a student allows for the characterization of the student.  For example, students might be added as regular students or auditing.  Students might be on the enrollment list, but their status might be withdrawn passing or withdrawn failing, etc.   <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class HarmoniEnrollmentRecord // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Id of the Agent representing a student enrolled in the CourseSection.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation agentId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function & getStudent() { /* :: interface :: */ }

	/**
	 * Get the Status Type for a student.  Students Status Type is supplied when the student is added or changed in the CourseSection.  The CourseManagementManager returns the Status Types supported by this implementation.
	 * @return object osid.shared.Type Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function & getStatus() { /* :: interface :: */ }
}