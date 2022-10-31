<?php

require_once(HARMONI."GUIManager/Component.class.php");

/**
 * <code>MenuItem</code> components are a direct implementation of the
 * <code>MenuItemInterface</code> interface. Their functionality is limited to 
 * displaying a text block
 * <br /><br />
 * <code>MenuItem</code> is an extension of <code>Component</code>; <code>MenuItems</code>
 * have display names and the ability to be added to <code>Menu</code> objects.
 *
 * @package harmoni.gui.components
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MenuItem.class.php,v 1.1 2006/01/20 20:52:40 adamfranco Exp $
 */
class MenuItem extends Component /* implements MenuItemInterface */ {

	/**
	 * The display name of this menu item.
	 * @var string _text 
	 * @access private
	 */
	var $_text;
	
	/**
	 * The constructor.
	 * @access public
	 * @param string text The display name of this menu item.
	 * @param integer index The index of this component. The index has no semantic meaning: 
	 * you can think of the index as 'level' of the component. Alternatively, 
	 * the index could serve as means of distinguishing between components with 
	 * the same type. Most often one would use the index in conjunction with
	 * the <code>getStylesForComponentType()</code> and 
	 * <code>addStyleForComponentType()</code> methods.
	 * @param optional object StyleCollections styles,... Zero, one, or more StyleCollection 
	 * objects that will be added to the newly created Component. Warning, this will
	 * result in copying the objects instead of referencing them as using
	 * <code>addStyle()</code> would do.
	 **/
	function __construct($text, $index) {
		// ** parameter validation
		ArgumentValidator::validate($text, StringValidatorRule::getRule(), true);
		// ** end of parameter validation	

		$this->_text = $text;

		parent::__construct($text, MENU_ITEM_HEADING, $index);
		
		// if there are style collections to add
		if (func_num_args() > 2)
			for ($i = 2; $i < func_num_args(); $i++)
				$this->addStyle(func_get_arg($i));
	}

	/**
	 * Returns the display name of this menu item.
	 * @access public
	 * @return string The display name of this menu item.
	 **/
	function getDisplayName() {
		return $this->_text;
	}
	
	/**
	 * Sets the display name of this menu item.
	 * @access public
	 * @param string text The new display name.
	 **/
	function setDisplayName($text) {
		// ** parameter validation
		ArgumentValidator::validate($text, StringValidatorRule::getRule(), true);
		// ** end of parameter validation	

		$this->_text = $text;
	}

}

?>