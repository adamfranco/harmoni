<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Node objects.
 * 
 * @version $Id: DefaultNodeType.class.php,v 1.1 2005/01/11 17:40:20 adamfranco Exp $
 * @package harmoni.osid.hierarchy2
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class DefaultNodeType extends HarmoniType {

	function DefaultNodeType() {
		$this->HarmoniType("harmoni", "hierarchy", "node");
	}

}

?>