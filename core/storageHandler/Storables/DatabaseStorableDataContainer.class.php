<?php

require_once(HARMONI . "utilities/DataContainer.abstract.php");

/**
 * The DatabaseStorableDataContainer stores several arguments that will be passed
 * to the constructor of a DatabaseStorable object.
 *
 * @package harmoni.storage.storables
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DatabaseStorableDataContainer.class.php,v 1.3 2005/01/19 21:10:13 adamfranco Exp $
 */

class DatabaseStorableDataContainer extends DataContainer {

	/**
	 * Constructor -- sets up the allowed fields for this kind of {@link DataContainer}
	 * <br /><br />
	 * This container includes the following fields:
	 * <br />
	 * *******add more********
	 * 
	 * @see {@link DatabaseStorable}
	 * @see {@link DataContainer}
	 * @access public
	 */
	function DatabaseStorableDataContainer()
	{ 
		// initialize the data container
		$this -> init(); 

		// add the fields we want to allow
		$stringValidatorRule =& new StringValidatorRule();
		$integerValidatorRule =& new IntegerValidatorRule();
		$this -> add("dbIndex",  $integerValidatorRule);
		$this -> add("dbTable", $stringValidatorRule);
		$this -> add("pathColumn", $stringValidatorRule);
		$this -> add("nameColumn", $stringValidatorRule);
		$this -> add("sizeColumn", $stringValidatorRule);
		$this -> add("dataColumn", $stringValidatorRule);
	}
} 

?>