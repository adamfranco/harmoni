<?

require_once(HARMONI."oki2/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Qualifier objects.
 * 
 * @version $Id: DefaultQualifierType.class.php,v 1.2 2005/01/18 16:39:59 adamfranco Exp $
 * @package harmoni.osid.authorization
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/
 
class DefaultQualifierType 
	extends HarmoniType 
{

	function DefaultQualifierType() {
		$this->HarmoniType("harmoni", "authorization", "qualifier");
	}

}

?>