<?

require_once(HARMONI."oki/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Node objects.
 * 
 * @version $Id: DefaultNodeType.class.php,v 1.1 2004/06/14 03:38:19 dobomode Exp $
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