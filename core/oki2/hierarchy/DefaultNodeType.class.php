<?

require_once(HARMONI."oki2/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Node objects.
 * 
 * @version $Id: DefaultNodeType.class.php,v 1.2 2005/01/17 21:07:04 adamfranco Exp $
 * @package harmoni.osid.hierarchy
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class DefaultNodeType 
	extends HarmoniType 
{

	function DefaultNodeType() {
		$this->HarmoniType("harmoni", "hierarchy", "node");
	}

}

?>