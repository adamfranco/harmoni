<?php

/**
 * A {@link HarmoniType} for DR Assets that will define CanonicalCourses.
 *
 * @package harmoni.osid_v2.coursemanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CanonicalCourseAssetType.class.php,v 1.4 2007/04/12 15:37:28 adamfranco Exp $
 */
class CanonicalCourseAssetType extends HarmoniType {

	function CanonicalCourseAssetType() {
		parent::HarmoniType("Harmoni","ClassManagement","CanonicalCourse");
	}
}

?>