<?php

require_once(HARMONI."GUIManager/Component.class.php");

/**
 * This is a simple implementation of a Blank component. Blank components do not
 * have any content and naturally have their type set to <code>BLANK</code>.
 * <br /><br />
 * <code>Components</code> are the basic units that can be displayed on
 * the screen. The main method <code>render()</code> which renders the component 
 * on the screen.
 * @version $Id: Blank.class.php,v 1.3 2005/01/03 20:50:07 adamfranco Exp $
 * @package harmoni.gui.components
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class Blank extends Component {

	/**
	 * The constructor.
	 * @access public
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
	function Blank($index) {
		$this->Component(null, BLANK, $index);
		
		// if there are style collections to add
		if (func_num_args() > 1)
			for ($i = 1; $i < func_num_args(); $i++)
				$this->addStyle(func_get_arg($i));
	}

}

?>