<?php

require_once(HARMONI."oki2/shared/HarmoniProperties.class.php");
require_once(HARMONI."oki2/shared/ConfigurationPropertiesType.class.php");


/**
 * Properties for configuring Managers
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid_v2.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ConfigurationProperties.class.php,v 1.2 2007/04/12 15:37:33 adamfranco Exp $
 */
class ConfigurationProperties
	extends HarmoniProperties
{

	/**
	 * Constructor. Create a new Properties object.
	 * 
	 * @param object Type $type
	 * @return object
	 * @access public
	 * @since 11/18/04
	 */
	function ConfigurationProperties() {
		$this->_type = new ConfigurationPropertiesType;
		$this->_properties = array();
	}
}