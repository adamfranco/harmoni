<?php

require_once(HARMONI."oki2/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Node objects.
 *
 * @package harmoni.osid_v2.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DefaultNodeType.class.php,v 1.7 2007/04/12 15:37:31 adamfranco Exp $
 **/

class DefaultNodeType 
	extends HarmoniType 
{

	function __construct() {
		parent::__construct("Hierarchy", "Harmoni", "Node", "Default node type");
	}

}

?>