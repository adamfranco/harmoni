<?php

require_once(HARMONI."GUIManager/Component.class.php");

/**
 * Heading components are identical to Block components with the only exception
 * that their type is set to <code>HEADING</code>.
 * <br><br>
 * <code>Components</code> are the basic units that can be displayed on
 * the screen. The main method <code>render()</code> which renders the component 
 * on the screen.
 * @version $Id: Heading.class.php,v 1.1 2004/07/23 02:44:17 dobomode Exp $
 * @package harmoni.gui.components
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class Heading extends Component {

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
	 * @param optional StyleCollections styles,... Zero, one, or more StyleCollection 
	 * objects that will be added to the newly created Component. Warning, this will
	 * result in copying the objects instead of referencing them as using
	 * <code>addStyle()</code> would do.
	 **/
	function Heading($content, $index) {
		// ** parameter validation
		$rule =& new StringValidatorRule($content);
		ArgumentValidator::validate($content, $rule, true);
		// ** end of parameter validation	

		$this->Component($content, HEADING, $index);
		
		// if there are style collections to add
		if (func_num_args() > 2)
			for ($i = 2; $i < func_num_args(); $i++)
				$this->addStyle(func_get_arg($i));
	}

}

?>