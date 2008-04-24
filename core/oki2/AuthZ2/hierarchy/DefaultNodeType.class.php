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
 * @version $Id: DefaultNodeType.class.php,v 1.1 2008/04/24 20:51:43 adamfranco Exp $
 **/

class AuthZ2_DefaultNodeType 
	extends HarmoniType 
{

	function __construct() {
		$this->HarmoniType("Hierarchy", "Harmoni", "Node", "Default node type");
	}

}

?>