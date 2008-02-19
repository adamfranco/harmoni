<?php

require_once(HARMONI."oki2/shared/HarmoniType.class.php");

/**
 * This class represents the default Type for Qualifier objects.
 * 
 *
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DefaultQualifierType.class.php,v 1.8 2008/02/19 21:43:20 adamfranco Exp $
 */
class DefaultQualifierType 
	extends HarmoniType 
{

	function __construct() {
		parent::__construct("authorization", "edu.middlebury.harmoni", "qualifier");
	}

}

?>