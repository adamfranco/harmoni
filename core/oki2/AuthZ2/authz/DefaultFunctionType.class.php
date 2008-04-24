<?php

require_once(HARMONI."oki2/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Function objects.
 *
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DefaultFunctionType.class.php,v 1.1 2008/04/24 20:51:43 adamfranco Exp $
 */

class AuthZ2_DefaultFunctionType 
	extends HarmoniType 
{

	function __construct() {
		parent::__construct("harmoni", "authorization", "function");
	}

}

?>