<?

/**
 * This class is used to setup the Harmoni implementation of the ClassManagement package from OKI.
 * @package harmoni.osid.classmanagement
 * @copyright 2004
 * @version $Id: ClassManagementSetup.class.php,v 1.1 2004/06/03 21:27:14 gabeschine Exp $
 */
class ClassManagementSetup {
	
	var $_config;
	
	/**
	 * The constructor.
	 * @param ref object $config A {@link ConfigSystem} object for whatever tool it is we're using.
	 * @access public
	 * @return void
	 */
	function ClassManagementSetup(&$config)
	{
		$this->_config =& $config;
	}
	
	/**
	 * Sets up all of the necessary componenents.
	 * @access public
	 * @return void
	 */
	function setupAll()
	{
		
	}
	
	/**
	 * Sets up the DR aspect of the ClassManagement package.
	 * @access public
	 * @return void
	 */
	function setupDR()
	{
		
	}
	
	/**
	 * Sets up the necessary DataSetTypes for the DataManager.
	 * @access public
	 * @return void
	 */
	function setupDataManager()
	{
		// this function will create all the DataSetTypes we need in the DataManager.
		
	}
	
}

/**
 * This defines the {@link DataSetType} for our {@link CanonicalCourse}s.
 * @package harmoni.osid.classmanagement
 * @copyright 2004
 * @version $Id: ClassManagementSetup.class.php,v 1.1 2004/06/03 21:27:14 gabeschine Exp $
 */
class CanonicalCourseDataSetType extends HarmoniType {

	function CanonicalCourseDataSetType() {
		parent::HarmoniType("Harmoni","ClassManagement","CanonicalCourseDataSet");
	}
}