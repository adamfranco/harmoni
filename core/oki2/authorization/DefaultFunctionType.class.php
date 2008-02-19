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
 * @version $Id: DefaultFunctionType.class.php,v 1.7 2008/02/19 21:43:20 adamfranco Exp $
 */

class DefaultFunctionType 
	extends HarmoniType 
{

	function __construct() {
		parent::__construct("harmoni", "authorization", "function");
	}

}

?>