<?php

require_once(HARMONI."GUIManager/Theme.class.php");

/**
 * This MenuTheme abstract class implements solely the <code>addMenu</code> and <code>getMenu</code>
 * methods. If the user desires a proper complete implementation of the <code>MenuTheme</code> 
 * interface, then there are two ways of doing that:<br /><br />
 * <ol>
 *      <li> The user could overload setMenu so that as a new menu is added,
 * 	    it is appropriately incorporated in a <code>Container</code> along with
 *      the <code>Theme</code> component and all other previously added menus.
 * 	    This is the recommended solution.
 *      </li>
 * 		<li> The user could overload root Theme methods (at least <code>printPage()</code>) to
 * 	    account for added menus. In other words, HTML generating methods will
 *      dynamically generate menu-related output as they are called.
 * 	    </li>
 * </ol>
 * <br />
 * 
 * A <code>MenuTheme</code> is an extension of the generic <code>Theme</code> interface
 * that adds support for multi-level navigation menus. A <code>MenuTheme</code>, 
 * like a normal </code>Theme</code> has a single <code>Component</code>; however,
 * it allows the user to surround that component with multi-level navigation menus.
 *
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MenuTheme.abstract.php,v 1.2 2005/03/29 19:44:09 adamfranco Exp $
 **/
class MenuThemeAbstract extends Theme /* implements MenuThemeInterface */ {
	
	/**
	 * An array storing all menus of this theme. Each element is a <code>Menu</code>
	 * object.
	 * @attribute private array _menus
	 */
	var $_menus;
	
	/**
	 * Adds a new menu to this theme.
	 * @access public
	 * @param ref object menu A <code>Menu</code> object to be added to this theme.
	 * @param integer level A positive integer specifying the <code>level</code> of the
	 * menu that is being added. Only one menu can exist at any given level. 
	 * Levels cannot be skipped. Levels allow the user to create a hierarchy of menus.
	 **/
	function addMenu(& $menu, $level) {
		// ** parameter validation
		ArgumentValidator::validate($menu, ExtendsValidatorRule::getRule("Menu"), true);
		ArgumentValidator::validate($level > 0, TrueValidatorRule::getRule(), true);
		// ** end of parameter validation		
		
		// two things need to be true in order for this menu to be added
		// 1) no levels before the given are empty
		// 2) no menu has been set for this level already
		if ($level > 1 && !isset($this->_menus[$level-1])) {
			$err = "Error when adding a menu to a theme: all prior menu levels must be non-empty.";
			throwError(new Error($err, "GUIManager", false));
			return;		    
		}
		if (isset($this->_menus[$level])) {
			$err = "A menu has already been set for the given level.";
			throwError(new Error($err, "GUIManager", false));
			return;		    
		}
		
		// now add the menu
		$this->_menus[$level] =& $menu;
	}
	
	/**
	 * Returns the menu (if exists) at the given level.
	 * @access public
	 * @param integer level An integer specifying the <code>level</code> of the
	 * menu that is to be returned. Levels start at 1. Only one menu can exist at any given level.
	 * Levels cannot be skipped. Levels allow the user to create a hierarchy of menus.
	 * @return ref object The <code>Menu</code> object at the specified level, or <code>NULL</code>
	 * if no menu was found.
	 **/
	function & getMenu($level) {
		// ** parameter validation
		ArgumentValidator::validate($level > 0, TrueValidatorRule::getRule(), true);
		// ** end of parameter validation		
		
		if (isset($this->_menus[$level]))
			return $this->_menus[$level];
		else
			return null;
	}
	
	
	/**
	 * Returns the number of menus in this Theme.
	 * @access public
	 * @return integer The number of menus.
	 **/
	function getNumberOfMenus() {
		return count($this->_menus);
	}
	
	
}

?>