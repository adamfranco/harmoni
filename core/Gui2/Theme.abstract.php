<?php
/**
 * @since 5/15/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

/**
 * This abstract class defines a number of methods that may be useful to all theme
 * implementations
 * 
 * @since 5/15/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
abstract class Harmoni_Gui2_ThemeAbstract {
	
	/*********************************************************
	 * Theme options
	 *********************************************************/
	
	/**
	 * Answer true if this theme supports options.
	 * 
	 * @return boolean
	 * @access public
	 * @since 5/6/08
	 */
	public function supportsOptions () {
		return true;
	}
	
	/**
	 * Answer an object that implements the ThemeOptionsInterface
	 * for this theme. This could be the same or a different object.
	 * 
	 * @return object Harmoni_Gui2_ThemeOptionsInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getOptionsSession () {
		return $this;
	}
	
	/*********************************************************
	 * Theme Options Session methods
	 *********************************************************/
	/**
	 * Answer an array of ThemeOption objects
	 * 
	 * @return array of Harmoni_Gui2_ThemeOptionInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getOptions () {
		if (!isset($this->options))
			$this->loadOptions();
		return $this->options;
	}
	
	/**
	 * Answer an option by Id-string
	 * 
	 * @param string $id
	 * @return Harmoni_Gui2_ThemeOptionInterface
	 * @access public
	 * @since 5/9/08
	 */
	public function getOption ($id) {
		foreach ($this->getOptions() as $option) {
			if ($option->getIdString() == $id)
				return $option;
		}
		
		throw new UnknownIdException("No option known with id '$id' in theme '".$this->getIdString()."'.");
	}
	
	/**
	 * Answer true if the current options value is to use defaults.
	 * 
	 * @return boolean
	 * @access public
	 * @since 5/6/08
	 */
	public function usesDefaults () {
		foreach ($this->getOptions() as $option) {
			if ($option->getValue() != $option->getDefaultValue())
				return false;
		}
		
		return true;
	}
	
	/**
	 * Answer a string version of the current option-values that
	 * can be fed back into setOptions() to return to the current
	 * state.
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getOptionsValue () {
		$value = '';
		
		foreach ($this->getOptions() as $option) {
			if ($option->getValue() != $option->getDefaultValue())
				$value .= '&amp;'.$option->getIdString().'='.$option->getValue();
		}
		
		return $value;
	}
	
	/**
	 * Given a string created by getOptionsValue(), set the current
	 * state of the options to match.
	 * 
	 * @param string $optionsValue
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function setOptionsValue ($optionsValue) {
		$options = $this->getOptions();
		if (!count($options)) {
			if (strlen($optionsValue))
				throw new OperationFailedException("No options to accept the value passed.");
			return;	
		}
		
		if (!preg_match_all('/&amp;([a-zA-Z_-]{1,50})=([a-zA-Z_-]{1,50})/', $optionsValue, $matches))
			throw new InvalidArgumentException("'$optionsValue' is not a valid options value.");
		
		for ($i = 0; $i < count($matches[1]); $i++) {
			$option = $this->getOption($matches[1][$i]);
			$option->setValue($matches[2][$i]);
		}
	}
	
	/**
	 * Set all options to use their defaults
	 * 
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function useDefaults () {
		$this->loadOptions();
	}
	
	/**
	 * Load the options.xml file if it exists
	 * 
	 * @return null
	 * @access protected
	 * @since 5/9/08
	 */
	protected function loadOptions () {
		$doc = $this->getOptionsDocument();
		if (!isset($doc->documentElement)) {
			$this->options = array();
			return;
		}
		$this->options = $this->buildOptionsFromDocument($doc);
	}
	
	
	/**
	 * Build options from an xml document.
	 * 
	 * @param DOMDocument $doc
	 * @return array of ThemeOptionInterface objects
	 * @access protected
	 * @since 5/15/08
	 */
	protected function buildOptionsFromDocument (DOMDocument $doc) {
		$xpath = new DOMXPath($doc);
		$options = array();
		foreach ($xpath->query('/options/option') as $optionElement) {
			$displayName = $this->getPathLangVersion($xpath, './displayName', $optionElement);
			$description = $this->getPathLangVersion($xpath, './description', $optionElement);
			
			$choices = array();
			foreach ($xpath->query('./choice', $optionElement) as $choiceElement) {
				$choice = new Harmoni_Gui2_Choice;
				$choice->key = $xpath->query('./key', $choiceElement)->item(0)->nodeValue;
				$choice->label = $this->getPathLangVersion($xpath, './label', $choiceElement);
				if ($choiceElement->hasAttribute('isDefault') 
						&& $choiceElement->getAttribute('isDefault') == 'true')
					$choice->isDefault = true;
				else
					$choice->isDefault = false;
				
				$choice->settings = array();
				foreach ($xpath->query('./setting', $choiceElement) as $settingElement) {
					$choice->settings[$settingElement->getAttribute('marker')] = $settingElement->nodeValue;
				}
				
				$choices[] = $choice;
			}
			$options[] = new Harmoni_Gui2_ThemeOption($optionElement->getAttribute('id'), $displayName, $description, $choices);
		}
		return $options;
	}
	
	/**
	 * Get the version of an element in the best language available
	 * 
	 * @param object DOMXPath $xpath
	 * @param string $path
	 * @param object DOMElement $element
	 * @return string
	 * @access protected
	 * @since 5/9/08
	 */
	protected function getPathLangVersion (DOMXPath $xpath, $path, DOMElement $element) {
			$langMgr = Services::getService("LanguageManager");
			$lang = $langMgr->getLanguage();
			
			// Current language
			if ($xpath->query($path."[@lang = '$lang']", $element)->length) {
				return $xpath->query($path."[@lang = '$lang']", $element)->item(0)->nodeValue;
			}
			
			// Try another country's version of the same language
			$langOnly = substr($lang, 0, strpos($lang, '_'));
			$regex = '/'.$langOnly.'_.+/';
			foreach ($xpath->query($path, $element) as $elem) {
				if (preg_match($regex, $elem->getAttribute('lang'))) {
					return $elem->nodeValue;
				}
			}
			
			// Default to english if available
			if ($xpath->query($path."[@lang = 'en_US']", $element)->length) {
				return  $xpath->query($path."[@lang = 'en_US']", $element)->item(0)->nodeValue;
			}
			
			// Answer the first one
			if ($xpath->query($path, $element)->length) {
				return  $xpath->query($path, $element)->item(0)->nodeValue;
			}
			
			throw new OperationFailedException("No elements found that match '$path'.");
	}
	
	/**
	 * Answer an array of Component types
	 * 
	 * @return array
	 * @access public
	 * @since 5/6/08
	 */
	public function getComponentTypes () {
		return array (	'Block_Background',
						'Block_Standard',
						'Block_Sidebar',
						'Block_Alert',
						
						'Menu_Left',
						'Menu_Right',
						'Menu_Top',
						'Menu_Bottom',
						
						'Menu_Sub',
						'MenuItem_Link_Selected',
						'MenuItem_Link_Unselected',
						'MenuItem_Heading',
						
						'Heading_1',
						'Heading_2',
						'Heading_3',
						'Heading_Sidebar',
						
						'Header',
						'Footer'
					);
	}
	
	/**
	 * Replace relative URLs with one that will work.
	 * 
	 * @param string $templateContent
	 * @return string
	 * @access protected
	 * @since 5/6/08
	 */
	protected function replaceRelativeUrls ($templateContent) {
		$srcRegex = '/
src=[\'"]

(?: \.\/ )?	# Optional current directy marker
images\/
([a-z0-9\.\/_-]+)

[\'"]

/ix';
		$urlRegex = '/
url\([\'"]?

(?: \.\/ )?	# Optional current directy marker
images\/
([a-z0-9\.\/_-]+)

[\'"]?\)

/ix';

		$harmoni = Harmoni::instance();
		preg_match_all($srcRegex, $templateContent, $matches);
		for ($i = 0; $i < count($matches[0]); $i++) {
			$url = $harmoni->request->mkURLWithoutContext('gui2', 'theme_image', 
					array('theme' => $this->getIdString(), 'file' => $matches[1][$i]));
			$replacement = 'src="'.$url->write().'"';
			$templateContent = str_replace($matches[0][$i], $replacement, $templateContent);
		}
		
		preg_match_all($urlRegex, $templateContent, $matches);
		for ($i = 0; $i < count($matches[0]); $i++) {
			$url = $harmoni->request->mkURLWithoutContext('gui2', 'theme_image', 
					array('theme' => $this->getIdString(), 'file' => $matches[1][$i]));
			$replacement = "url('".str_replace('&amp;', '&', $url->write())."')";
			$templateContent = str_replace($matches[0][$i], $replacement, $templateContent);
		}
		
		return $templateContent;
	}
	
	/**
	 * Resolve a type and index into one of our component types
	 * 
	 * @param int $type
	 * @param int $index
	 * @return string
	 * @access protected
	 * @since 5/6/08
	 */
	protected function resolveType ($type, $index) {
		// ** parameter validation
		$rule = ChoiceValidatorRule::getRule(BLANK, HEADING, HEADER, FOOTER, BLOCK, MENU, 
										SUB_MENU, MENU_ITEM_LINK_UNSELECTED,
										MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER);
		ArgumentValidator::validate($type, $rule, true);
		ArgumentValidator::validate($index, IntegerValidatorRule::getRule(), true);
		
		switch ($type) {
			case BLANK:
			case OTHER:
				return 'Blank';
			
			case BLOCK:
				switch ($index) {
					case BACKGROUND_BLOCK:
						return 'Block_Background';
					case STANDARD_BLOCK:
					case WIZARD_BLOCK:
					case EMPHASIZED_BLOCK:
						return 'Block_Standard';
					case SIDEBAR_BLOCK:
						return 'Block_Sidebar';
					default:
						return 'Block_Alert';
				}
			
			case MENU:
				switch ($index) {
					case MENU_LEFT:
						return 'Menu_Left';
					case MENU_RIGHT:
						return 'Menu_Right';
					case MENU_TOP:
						return 'Menu_Top';
					default:
						return 'Menu_Bottom';
				}
			case SUB_MENU:
				return 'Menu_Sub';
			case MENU_ITEM_LINK_UNSELECTED:
				return 'MenuItem_Link_Unselected';
			case MENU_ITEM_LINK_SELECTED:
				return 'MenuItem_Link_Selected';
			case MENU_ITEM_HEADING:
				return 'MenuItem_Heading';
				
			case HEADING:
				switch ($index) {
					case 1:
						return 'Heading_1';
					case 2:
						return 'Heading_2';
					case 4:
						return 'Heading_Sidebar';
					default:
						return 'Heading_3';
				}
			
			case HEADER:
				return 'Header';
			case FOOTER:
				return 'Footer';
			
			default:
				throw new InvalidArgumentException("Usuported type, $type.");
		}
	}
	
}

?>