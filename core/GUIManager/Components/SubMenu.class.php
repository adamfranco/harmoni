<?php
/**
 * @since 9/21/06
 * @package harmoni.gui.components
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SubMenu.class.php,v 1.2 2006/11/30 22:02:02 adamfranco Exp $
 */ 

/**
 * <##>
 * 
 * @since 9/21/06
 * @package harmoni.gui.components
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SubMenu.class.php,v 1.2 2006/11/30 22:02:02 adamfranco Exp $
 */
class SubMenu
	extends Menu
{
		
	/**
	 * The constructor.
	 * @access public
	 * @param ref object layout The <code>Layout</code> of this container.
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
	function SubMenu(&$layout, $index) {
		$this->Container($layout, SUB_MENU, $index);
		
		$this->_selectedId = null;

		// if there are style collections to add
		if (func_num_args() > 2)
			for ($i = 2; $i < func_num_args(); $i++)
				$this->addStyle(func_get_arg($i));
	}
	
}

?>