<?php

require_once(HARMONI."GUIManager/Component.class.php");

/**
 * This is a simple implementation of a Block component. Block components are
 * very simple, and in reality do not differ much from the generic component.
 * Blocks are capable of storing an arbitrary content (string) and naturally have
 * their type set to <code>BLOCK</code>. Unlike the generic component, the content
 * of Blocks is required.
 * <br /><br />
 * <code>Components</code> are the basic units that can be displayed on
 * the screen. The main method <code>render()</code> which renders the component 
 * on the screen.
 *
 * @package harmoni.gui.components
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Block.class.php,v 1.6 2005/03/29 19:44:09 adamfranco Exp $
 */
class Block extends Component {

	/**
	 * The constructor.
	 * @access public
	 * @param string content This is an arbitrary string that will be printed,
	 * whenever the user calls the <code>render()</code> method. The parameter
	 * is required.
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
	function Block($content, $index) {
		// ** parameter validation
		$rule =& StringValidatorRule::getRule()($content);
		ArgumentValidator::validate($content, $rule, true);
		// ** end of parameter validation	

		$this->Component($content, BLOCK, $index);
		
		// if there are style collections to add
		if (func_num_args() > 2)
			for ($i = 2; $i < func_num_args(); $i++)
				$this->addStyle(func_get_arg($i));
	}

}

?>