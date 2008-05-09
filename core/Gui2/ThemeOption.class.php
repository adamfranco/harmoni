<?php
/**
 * @since 5/9/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

require_once(dirname(__FILE__).'/ThemeOption.interface.php');

/**
 * This class represents a theme option which is made up of a set of choices.
 * 
 * @since 5/9/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
class Harmoni_Gui2_ThemeOption
	implements Harmoni_Gui2_ThemeOptionInterface
{
	
	/**
	 * Constructor
	 * 
	 * @param string $id
	 * @param string $displayName
	 * @param string $description
	 * @param array $choices
	 * @return null
	 * @access public
	 * @since 5/9/08
	 */
	public function __construct ($id, $displayName, $description, array $choices) {
		ArgumentValidator::validate($id, NonzeroLengthStringValidatorRule::getRule());
		ArgumentValidator::validate($displayName, NonzeroLengthStringValidatorRule::getRule());
		ArgumentValidator::validate($description, StringValidatorRule::getRule());
		
		$this->id = $id;
		$this->displayName = $displayName;
		$this->description = $description;
		$this->choices = $choices;
	}
	
	/**
	 * Answer the id string of this Option
	 * 
	 * @return string
	 * @access public
	 * @since 5/9/08
	 */
	public function getIdString () {
		return $this->id;
	}
	
	/**
	 * Answer the display name of this option
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getDisplayName () {
		return $this->displayName;
	}
	
	/**
	 * Answer a description of this option
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getDescription () {
		return $this->description;
	}
	
	/**
	 * Get the allowed values for this option.
	 * 
	 * @return array of strings
	 * @access public
	 * @since 5/6/08
	 */
	public function getValues () {
		$values = array();
		foreach ($this->choices as $choice)
			$values[] = $choice->key;
		return $values;
	}
	
	/**
	 * Get text labels for the values for this option.
	 * 
	 * @return array of strings
	 * @access public
	 * @since 5/6/08
	 */
	public function getLabels () {
		$labels = array();
		foreach ($this->choices as $choice)
			$labels[] = $choice->label;
		return $labels;
	}
	
	/**
	 * Set the value of this option
	 * 
	 * @param string $value
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function setValue ($value) {
		$found = false;
		foreach ($this->choices as $choice) {
			if ($choice->key == $value) {
				$found = true;
				break;
			}
		}
		if (!$found)
			throw new OperationFailedException("'$value' is not in the allowed list.");
		
		$this->currentValue = $value;
	}
	
	/**
	 * Answer the current Value
	 * 
	 * @return string
	 * @access public
	 * @since 5/9/08
	 */
	public function getValue () {
		if (isset($this->currentValue))
			return $this->currentValue;
		else
			return $this->getDefaultValue();
	}
	
	/**
	 * Set the value of this option to be the default.
	 * 
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function useDefault () {
		$this->setValue($this->getDefaultValue());
	}
	
	/**
	 * Answer the default value
	 * 
	 * @return string
	 * @access public
	 * @since 5/9/08
	 */
	public function getDefaultValue () {
		foreach ($this->choices as $choice) {
			if ($choice->isDefault == true)
				return $choice->key;
		}
		
		// If none is default, use the first.
		return $this->choices[0]->key;
	}
	
}

/**
 * A class for ThemeOption Choices
 * 
 * @since 5/9/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
class Harmoni_Gui2_Choice {
		
	
	
}


?>